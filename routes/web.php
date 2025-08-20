<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $patient = Patient::count();
    $doctors = User::count();
    // $ticket = Ticket::count();
    $ticket = 5;
    // $totalPaySum = Ticket::sum('total_pay');
    $totalPaySum = 100;

    // MongoDB aggregation to group patients by date
    $startDate = now()->subMonths(6);

    $aggregation = Patient::raw(function ($collection) use ($startDate) {
        return $collection->aggregate([
            [
                '$match' => [
                    'created_at' => [
                        '$gte' => new MongoDB\BSON\UTCDateTime($startDate)
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => [
                        'year' => ['$year' => '$created_at'],
                        'month' => ['$month' => '$created_at'],
                        'day' => ['$dayOfMonth' => '$created_at'],
                    ],
                    'count' => ['$sum' => 1],
                ]
            ],
            [
                '$sort' => ['_id.year' => 1, '_id.month' => 1, '_id.day' => 1],
            ]
        ]);
    });

    // Format results
    $dates = [];
    $counts = [];

    foreach ($aggregation as $item) {
        $date = \Carbon\Carbon::createFromDate(
            $item->_id['year'],
            $item->_id['month'],
            $item->_id['day']
        )->format('Y-m-d');

        $dates[] = $date;
        $counts[] = $item->count;
    }

    return view('dashboard', compact(
        'patient',
        'doctors',
        'ticket',
        'totalPaySum',
        'dates',
        'counts'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Regiser
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    //Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('/patients/{id}/services', [PatientController::class, 'showServices'])->name('patients.services.index');
    Route::post('/patients/services', [PatientController::class, 'storeService'])->name('patients.services.store');

    // workspace
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace.index');
    // vaccine
    Route::get('workspace/vaccine/index', [WorkspaceController::class, 'vaccineIndex'])->name('workspace.vaccine.index');
    Route::post('workspace/vaccine/store', [WorkspaceController::class, 'vaccineStore'])->name('workspace.vaccine.store');
    Route::get('workspace/vaccine/comeback', [WorkspaceController::class, 'comeback'])->name('workspace.vaccine.comeback');
    Route::post('workspace/vaccine/comeback/adddose', [WorkspaceController::class, 'addDose'])->name('workspace.vaccine.addDose');

    Route::get('workspace/vaccine/vaccinelist',[WorkspaceController::class, 'vaccineList'])->name('workspace.vaccine.vaccineList');
    Route::post('workspace/vaccineCategory/store', [WorkspaceController::class, 'vaccineCategoryStore'])->name('workspace.vaccineCategory.store');

    // common diseases
    Route::get('workspace/common-diseases/index', [WorkspaceController::class, 'commonDiseasesIndex'])->name('workspace.common-diseases.index');
    // gynecology
    Route::get('workspace/gynecology/index', [WorkspaceController::class, 'gynecologyIndex'])->name('workspace.gynecology.index');
    // medicine
    Route::get('workspace/medicine/index', [WorkspaceController::class, 'medicineIndex'])->name('workspace.medicine.index');

    // Medicine Management Routes
    Route::prefix('workspace/medicine')->name('workspace.medicine.')->group(function () {
        Route::get('/', [App\Http\Controllers\MedicineController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MedicineController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MedicineController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\MedicineController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\MedicineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MedicineController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\MedicineController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/stock', [App\Http\Controllers\MedicineController::class, 'updateStock'])->name('updateStock');
        Route::get('/dashboard', [App\Http\Controllers\MedicineController::class, 'dashboard'])->name('dashboard');
    });

    //Doctors
    Route::resource('doctors', DoctorController::class);

    Route::resource('appointments', AppointmentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Language switcher
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'kh'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    })->name('lang.switch');
});

require __DIR__ . '/auth.php';
