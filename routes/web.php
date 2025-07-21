<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
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

     Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    //PatientsP
    // Route::resource('patients', PatientController::class);
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/patients/services', [PatientController::class, 'storeService'])->name('patients.services.store');

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
