<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Patient;
use App\Models\User;
use App\Models\PatientAssign;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Vaccine;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\UTCDateTime;
use App\Http\Controllers\UserAdminController;

// Default route: show welcome if guest, dashboard if logged in
Route::get('/', function () {
    if (Auth::check()) {
        $patient = Patient::count();
        $doctors = User::count();
        $ticket = PatientAssign::count();

        // Add medicine and vaccine data
        $medicineCount = Medicine::count();
        $vaccineCount = Vaccine::count();

        // Calculate revenue from different sources
        // Option 1: Medicine revenue (total value of medicine inventory)
        $medicineRevenue = Medicine::sum('price') ?? 0;

        // Option 2: Service-based revenue (estimate based on completed services)
        $serviceRevenue = Service::where('status', 'completed')->count() * 50; // $50 per completed service

        // Option 3: Assignment-based revenue (estimate based on processed assignments)
        $assignmentRevenue = PatientAssign::whereNotNull('processed_at')->count() * 25; // $25 per processed assignment

        // Option 4: Cash vs NSSF revenue (different rates)
        $cashAssignments = PatientAssign::where('payment_type', 'cash')->whereNotNull('processed_at')->count();
        $nssfAssignments = PatientAssign::where('payment_type', 'nssf')->whereNotNull('processed_at')->count();
        $paymentRevenue = ($cashAssignments * 30) + ($nssfAssignments * 20); // $30 cash, $20 NSSF

        // Total revenue calculation (you can choose which method to use)
        $totalPaySum = $paymentRevenue; // Using payment-based revenue

        $startDate = now()->subMonths(6);

        $aggregation = Patient::raw(function ($collection) use ($startDate) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new UTCDateTime($startDate)
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
            'medicineCount',
            'vaccineCount',
            'dates',
            'counts'
        ));
    }

    return view('welcome');
})->name('dashboard');

// Redirect /dashboard → /
Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('/patients/{id}/services', [PatientController::class, 'showServices'])->name('patients.services.index');
    Route::post('/patients/services', [PatientController::class, 'storeService'])->name('patients.services.store');

    // Patient Assignment Routes
    Route::get('/patients/{id}/assign', [PatientController::class, 'showAssignmentForm'])->name('patients.assign');
    Route::post('/patients/{id}/assign', [PatientController::class, 'assignPatient'])->name('patients.assign.store');

    // Debug route for patient assignment issues
    Route::get('/patients/{id}/debug', [PatientController::class, 'debugPatient'])->name('patients.debug');

    // Assignment Status Tracking Routes
    Route::patch('/assignments/{id}/read', [PatientController::class, 'markAssignmentAsRead'])->name('assignments.read');
    Route::patch('/assignments/{id}/processed', [PatientController::class, 'markAssignmentAsProcessed'])->name('assignments.processed');
    Route::get('/my-assignments', [PatientController::class, 'myAssignments'])->name('assignments.my');
    Route::get('/assignments/completed', [PatientController::class, 'getCompletedAssignments'])->name('assignments.completed');
    Route::get('/assignments/debug', [PatientController::class, 'debugAssignments'])->name('assignments.debug');

    // Workspace
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace.index');
    Route::get('workspace/vaccine/index', [WorkspaceController::class, 'vaccineIndex'])->name('workspace.vaccine.index');
    Route::post('workspace/vaccine/store', [WorkspaceController::class, 'vaccineStore'])->name('workspace.vaccine.store');
    Route::get('workspace/vaccine/comeback', [WorkspaceController::class, 'comeback'])->name('workspace.vaccine.comeback');
    Route::post('workspace/vaccine/comeback/adddose', [WorkspaceController::class, 'addDose'])->name('workspace.vaccine.addDose');

    Route::get('workspace/vaccine/vaccinelist', [WorkspaceController::class, 'vaccineList'])->name('workspace.vaccine.vaccineList');
    Route::post('workspace/vaccineCategory/store', [WorkspaceController::class, 'vaccineCategoryStore'])->name('workspace.vaccineCategory.store');
    Route::put('workspace/vaccineCategory/{id}', [WorkspaceController::class, 'vaccineCategoryUpdate'])->name('workspace.vaccineCategory.update');
    Route::delete('workspace/vaccineCategory/{id}', [WorkspaceController::class, 'vaccineCategoryDestroy'])->name('workspace.vaccineCategory.destroy');

    // Vaccine patient info
    Route::get('workspace/vaccine/patient/{patientId}/form', [WorkspaceController::class, 'showVaccinePatientForm'])->name('workspace.vaccine.patient.form');
    Route::post('workspace/vaccine/patient/{patientId}/store', [WorkspaceController::class, 'storeVaccinePatientInfo'])->name('workspace.vaccine.patient.store');
    Route::post('workspace/vaccine/patient/{patientId}/dismiss', [WorkspaceController::class, 'dismissVaccinePatient'])->name('workspace.vaccine.patient.dismiss');

    // Common diseases
    Route::get('workspace/common-diseases/index', [WorkspaceController::class, 'commonDiseasesIndex'])->name('workspace.common-diseases.index');
    Route::post('workspace/common-diseases', [WorkspaceController::class, 'commonDiseasesStore'])->name('workspace.common-diseases.store');
    Route::get('workspace/common-diseases/{id}/edit', [WorkspaceController::class, 'commonDiseasesEdit'])->name('workspace.common-diseases.edit');
    Route::put('workspace/common-diseases/{id}', [WorkspaceController::class, 'commonDiseasesUpdate'])->name('workspace.common-diseases.update');
    Route::delete('workspace/common-diseases/{id}', [WorkspaceController::class, 'commonDiseasesDestroy'])->name('workspace.common-diseases.destroy');
    Route::get('workspace/common-diseases/print', [WorkspaceController::class, 'commonDiseasesPrint'])->name('workspace.common-diseases.print');
    Route::get('workspace/common-diseases/{id}/export/csv', [WorkspaceController::class, 'exportCommonDiseaseCsv'])->name('workspace.common-diseases.export.csv');
    Route::get('workspace/common-diseases/{id}/export/pdf', [WorkspaceController::class, 'exportCommonDiseasePdf'])->name('workspace.common-diseases.export.pdf');

    // Common disease patient info
    Route::get('workspace/common-diseases/patient/{patientId}/form', [WorkspaceController::class, 'showCommonDiseasePatientForm'])->name('workspace.common-diseases.patient.form');
    Route::post('workspace/common-diseases/patient/{patientId}/store', [WorkspaceController::class, 'storeCommonDiseasePatientInfo'])->name('workspace.common-diseases.patient.store');
    Route::post('workspace/common-diseases/patient/{patientId}/dismiss', [WorkspaceController::class, 'dismissCommonDiseasePatient'])->name('workspace.common-diseases.patient.dismiss');
    Route::get('workspace/common-diseases/patient-search', [WorkspaceController::class, 'commonDiseasePatientSearch'])->name('workspace.common-diseases.patient.search');

    // Gynecology
    Route::get('workspace/gynecology/index', [WorkspaceController::class, 'gynecologyIndex'])->name('workspace.gynecology.index');
    Route::post('workspace/gynecology/store', [WorkspaceController::class, 'gynecologyStore'])->name('workspace.gynecology.store');
    Route::get('workspace/gynecology/{id}/edit', [WorkspaceController::class, 'gynecologyEdit'])->name('workspace.gynecology.edit');
    Route::put('workspace/gynecology/{id}', [WorkspaceController::class, 'gynecologyUpdate'])->name('workspace.gynecology.update');
    Route::delete('workspace/gynecology/{id}', [WorkspaceController::class, 'gynecologyDestroy'])->name('workspace.gynecology.destroy');

    // Gynecology patient info
    Route::get('workspace/gynecology/patient/{patientId}/form', [WorkspaceController::class, 'showGynecologyPatientForm'])->name('workspace.gynecology.patient.form');
    Route::post('workspace/gynecology/patient/{patientId}/store', [WorkspaceController::class, 'storeGynecologyPatientInfo'])->name('workspace.gynecology.patient.store');
    Route::post('workspace/gynecology/patient/{patientId}/dismiss', [WorkspaceController::class, 'dismissGynecologyPatient'])->name('workspace.gynecology.patient.dismiss');

    // Medicine
    Route::get('workspace/medicine/index', [WorkspaceController::class, 'medicineIndex'])->name('workspace.medicine.index');

    // ✅ Fixed Medicine Management Routes
    Route::prefix('workspace/medicine')->name('workspace.medicine.')->group(function () {
        Route::get('/', [App\Http\Controllers\MedicineController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MedicineController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MedicineController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\MedicineController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\MedicineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MedicineController::class, 'update'])->name('update'); // ✅ Correct route
        Route::delete('/{id}', [App\Http\Controllers\MedicineController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/stock', [App\Http\Controllers\MedicineController::class, 'updateStock'])->name('updateStock');
        Route::post('/{id}/dispense', [App\Http\Controllers\MedicineController::class, 'dispense'])->name('dispense');
        Route::post('/bulk-dispense', [App\Http\Controllers\MedicineController::class, 'bulkDispense'])->name('bulkDispense');
        Route::get('/dashboard', [App\Http\Controllers\MedicineController::class, 'dashboard'])->name('dashboard');
    });

    // Doctors
    Route::resource('doctors', DoctorController::class);

    // Super User admin CRUD for users
    Route::resource('admin', UserAdminController::class)->except(['show']);

    // Appointments
    Route::resource('appointments', AppointmentController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::post('/locale', App\Http\Controllers\LocaleController::class)->name('locale.change');

});

require __DIR__ . '/auth.php';
