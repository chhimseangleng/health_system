<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Vaccine;
use App\Models\VaccineCategory;
use App\Models\CommonDisease;
use App\Models\GynecologyDisease;
use App\Models\Gynecology;
use App\Models\PatientAssign;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Exports\CommonDiseaseExport;

class WorkspaceController extends Controller
{
    public function vaccineCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dose' => 'required|integer|min:1',
        ]);

        // Create and save new VaccineCategory
        $category = VaccineCategory::create([
            'name' => $validated['name'],
            'dose' => $validated['dose'],
        ]);

        // Redirect or return response
        return redirect()->back()->with('success', 'Vaccine category added successfully!');
    }

    public function vaccineList()
    {
        $categories = VaccineCategory::all();

        // Fetch vaccine patients with incomplete information using PatientAssign
        $incompletePatients = Patient::whereHas('assignments', function($query) {
            $query->where('assigned_to', 'vaccine');
        })->where(function($query) {
            $query->where('vaccine_info_complete', '!=', true)
                  ->orWhereNull('vaccine_info_complete');
        })->latest()->paginate(10);

        return view('workspace.vaccine.vaccineList', compact('categories', 'incompletePatients'));
    }

    public function vaccineCategoryUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dose' => 'required|integer|min:1',
        ]);

        $category = VaccineCategory::findOrFail($id);
        $category->update([
            'name' => $validated['name'],
            'dose' => $validated['dose'],
        ]);

        return redirect()->back()->with('success', 'Vaccine category updated successfully!');
    }

    public function vaccineCategoryDestroy($id)
    {
        $category = VaccineCategory::findOrFail($id);

        // Cascade delete related vaccines, then delete category
        \App\Models\Vaccine::where('vaccine_category_id', (string) $id)->delete();
        $category->delete();

        return redirect()->back()->with('success', 'Vaccine category deleted successfully!');
    }

    public function showVaccinePatientForm($patientId)
    {
        $patient = Patient::with('assignments')->findOrFail($patientId);
        $categories = VaccineCategory::all();

        // Get the PatientAssign record for this patient and vaccine assignment
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'vaccine')
            ->latest()
            ->first();

        return view('workspace.vaccine.patient-form', compact('patient', 'categories', 'patientAssign'));
    }

    public function storeVaccinePatientInfo(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'father_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'required|string|max:20',
            // 'carer' => 'nullable|string|max:255',
            // 'carer_phone' => 'nullable|string|max:20',
            'birth_location' => 'required|string|max:255',
            'current_location' => 'required|string|max:255',
            'vaccine_category_id' => 'required|string',
            'description' => 'required|string',
            'vaccination_date' => 'required|date',
            'comeback' => 'nullable|string',
        ]);

        // Store additional vaccine data
        $additionalData = [
            'father_name' => $validated['father_name'],
            'father_phone' => $validated['father_phone'],
            'mother_name' => $validated['mother_name'],
            'mother_phone' => $validated['mother_phone'],
            // 'carer' => $validated['carer'],
            // 'carer_phone' => $validated['carer_phone'],
            'birth_location' => $validated['birth_location'],
            'current_location' => $validated['current_location'],
            'vaccine_category_id' => $validated['vaccine_category_id'],
            'description' => $validated['description'],
            'vaccination_date' => $validated['vaccination_date'],
            'comeback' => !empty($validated['comeback']) && $validated['comeback'] === 'on',
            'comeback_count' => 1,
        ];

        // Update patient with additional data and mark as complete
        $patient->update([
            'vaccine_additional_data' => $additionalData,
            'vaccine_info_complete' => true,
            // 'carer' => $validated['carer'],
            // 'carer_phone' => $validated['carer_phone'],
        ]);

        // Update PatientAssign status to completed
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'vaccine')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'completed',
                'processed_at' => now()
            ]);
        }

        // Also create a vaccine record
        $vaccine = new Vaccine();
        $vaccine->fill([
            'name' => $patient->first_name . ' ' . $patient->last_name,
            'bod' => $patient->date_of_birth,
            'age' => \Carbon\Carbon::parse($patient->date_of_birth)->age,
            'father_name' => $validated['father_name'],
            'father_phone' => $validated['father_phone'],
            'mother_name' => $validated['mother_name'],
            'mother_phone' => $validated['mother_phone'],
            // 'carer' => $validated['carer'],
            // 'carer_phone' => $validated['carer_phone'],
            'birth_location' => $validated['birth_location'],
            'current_location' => $validated['current_location'],
            'vaccine_category_id' => $validated['vaccine_category_id'],
            'description' => $validated['description'],
            'currentDate' => $validated['vaccination_date'],
            'comeback' => !empty($validated['comeback']) && $validated['comeback'] === 'on',
            'comeback_count' => 1,
            'dose_dates' => [$validated['vaccination_date']], // Initialize with first dose date
        ]);

        if ($vaccine->comeback) {
            $vaccine->first_come = now()->toDateString();
            $vaccine->complete = false; // Mark as incomplete since they need to come back
        } else {
            $vaccine->complete = true; // Mark as complete if no comeback needed
        }

        $vaccine->save();

        // Add history entry for vaccine administration
        $historyData = [
            'vaccine_category_id' => $validated['vaccine_category_id'],
            'description' => $validated['description'],
            'vaccination_date' => $validated['vaccination_date'],
            'comeback' => $vaccine->comeback,
            'comeback_count' => $vaccine->comeback_count,
            'father_name' => $validated['father_name'],
            'father_phone' => $validated['father_phone'],
            'mother_name' => $validated['mother_name'],
            'mother_phone' => $validated['mother_phone'],
            'birth_location' => $validated['birth_location'],
            'current_location' => $validated['current_location'],
            'vaccine_record_id' => $vaccine->_id
        ];

        $patient->addHistoryEntry('vaccine', $historyData, Auth::user()->name ?? 'Unknown');

        return redirect()->route('workspace.vaccine.index')
            ->with('success', 'Vaccine information added successfully!');
    }

    public function dismissVaccinePatient($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $patient->update(['vaccine_info_complete' => true]);

        // Update PatientAssign status to completed when dismissing
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'vaccine')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'completed',
                'processed_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Patient dismissed from vaccine completion list.');
    }

    public function addDose(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'id' => 'required|string',
            'comeback' => 'nullable|string',
        ]);

        $vaccineDose = Vaccine::find($data['id']); // find vaccine record

        if (!$vaccineDose) {
            return redirect()->back()->withErrors(['id' => 'Vaccine record not found']);
        }

        // Increment comeback_count by 1
        $vaccineDose->comeback_count = ($vaccineDose->comeback_count ?? 0) + 1;

        // Store the current date when dose is added to array
        $doseDates = $vaccineDose->dose_dates ?? [];
        $doseDates[] = now()->toDateString();
        $vaccineDose->dose_dates = $doseDates;

        // Get max dose from related vaccine category
        $maxDose = 0;
        if ($vaccineDose->vaccineCategory) {
            $maxDose = (int) $vaccineDose->vaccineCategory->dose;
        }

        // If comeback_count >= maxDose, set comeback to false and mark as complete
        if ($vaccineDose->comeback_count >= $maxDose) {
            $vaccineDose->comeback = false;
            $vaccineDose->complete = true; // Mark as complete when all doses are given
        } else {
            // Otherwise, set comeback based on checkbox input (optional)
            $vaccineDose->comeback = (isset($data['comeback']) && $data['comeback'] === 'on');
            $vaccineDose->complete = false; // Still incomplete if more doses needed
        }

        $vaccineDose->save();

        return redirect()->back()->with('success', 'Dose updated successfully.');
    }


    public function comeback(Request $request)
    {
        $search = $request->input('search');

        $query = Vaccine::where('comeback', true);

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Order by comeback_count (dose sequence) ascending, then by creation date
        // This ensures first vaccines appear first, second vaccines appear second, etc.
        $query->orderBy('comeback_count', 'asc')
              ->orderBy('created_at', 'asc');

        // paginate, 10 items per page
        $vaccinesComeback = $query->paginate(10)->appends(['search' => $search]);

        return view('workspace.vaccine.comeback', compact('vaccinesComeback', 'search'));
    }


    public function vaccineStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bod' => 'required|date|before_or_equal:today',
            'age' => 'required|integer|min:0',
            'father_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'required|string|max:20',
            // 'carer' => 'nullable|string|max:255',
            // 'carer_phone' => 'nullable|string|max:20',
            'birth_location' => 'required|string|max:255',
            'current_location' => 'required|string|max:255',
            'vaccine_category_id' => 'required|string',
            'description' => 'required|string',
            'currentDate' => 'required|date',
            'comeback' => 'nullable|string', // checkbox - 'on' or null
        ]);

        // dd("dol");

        $validated['comeback_count'] = 1;
        $validated['dose_dates'] = [$validated['currentDate']]; // Initialize with first dose date

        // Normalize comeback to boolean
        $validated['comeback'] = !empty($validated['comeback']) && $validated['comeback'] === 'on';

        // Set completion status based on comeback
        $validated['complete'] = !$validated['comeback']; // Complete if no comeback needed

        // Create new model instance to bypass mass assignment restrictions
        $vaccine = new Vaccine();
        $vaccine->fill($validated);

        // If comeback is true, set first_come to today
        if ($validated['comeback']) {
            $vaccine->first_come = now()->toDateString(); // e.g., "2025-08-10"
        }

        // Save in Mongo
        $vaccine->save();

        return redirect()->back()->with('success', 'Vaccine record saved successfully.');
    }


    public function index()
    {
        $userRole = Auth::user()->role ?? null;

        // Get incomplete patients count for each role
        $incompleteCounts = [
            'vaccine' => 0,
            'gynecology' => 0,
            'common diseases' => 0,
            'medicine' => 0,
        ];

        // Only fetch counts for the user's specific role
        if ($userRole) {
            $roleKey = strtolower($userRole);

            // Map role names to match patient role field
            $roleMapping = [
                'vaccine' => 'vaccine',
                'gynecology' => 'gynecology',
                'common diseases' => 'common disease',
                'medicine' => 'medicine'
            ];

            if (isset($roleMapping[$roleKey])) {
                $patientRole = $roleMapping[$roleKey];

                // Track completion for different roles
                if ($roleKey === 'vaccine') {
                    $incompleteCounts['vaccine'] = Patient::whereHas('assignments', function($query) use ($patientRole) {
                        $query->where('assigned_to', $patientRole)
                              ->where('status', 'pending');
                    })->where(function($query) {
                        $query->where('vaccine_info_complete', '!=', true)
                              ->orWhereNull('vaccine_info_complete');
                    })->count();
                } elseif ($roleKey === 'common diseases') {
                    $incompleteCounts['common diseases'] = Patient::whereHas('assignments', function($query) use ($patientRole) {
                        $query->where('assigned_to', $patientRole)
                              ->where('status', 'pending');
                    })->where(function($query) {
                        $query->where('common_disease_info_complete', '!=', true)
                              ->orWhereNull('common_disease_info_complete');
                    })->count();
                } elseif ($roleKey === 'gynecology') {
                    $incompleteCounts['gynecology'] = Patient::whereHas('assignments', function($query) use ($patientRole) {
                        $query->where('assigned_to', $patientRole)
                              ->where('status', 'pending');
                    })->where(function($query) {
                        $query->where('gynecology_info_complete', '!=', true)
                              ->orWhereNull('gynecology_info_complete');
                    })->count();
                }
            }
        }

        return view('workspace.index', compact('userRole', 'incompleteCounts'));
    }

    public function vaccineIndex(Request $request)
    {
        $search = $request->input('search');

        $query = Vaccine::query();

        // Apply search filter if search term is provided
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('father_name', 'like', '%' . $search . '%')
                  ->orWhere('mother_name', 'like', '%' . $search . '%');
            });
        }

        // Fetch vaccines with pagination, 10 items per page, sorted by latest date
        $vaccines = $query->orderBy('currentDate', 'desc')->paginate(7)->appends(['search' => $search]);

        // Fetch all vaccine categories
        $categories = VaccineCategory::all();

        // Fetch vaccine patients with incomplete information using PatientAssign
        // Fetch patients with pending vaccine assignments
        $incompletePatients = Patient::whereHas('assignments', function($query) {
            $query->where('assigned_to', 'vaccine')
                  ->where('status', 'pending');
        })
        ->where(function($query) {
            $query->where('vaccine_info_complete', '!=', true)
                  ->orWhereNull('vaccine_info_complete');
        })
        ->with(['assignments' => function($query) {
            $query->where('assigned_to', 'vaccine')
                  ->where('status', 'pending')
                  ->latest();
        }])
        ->latest()
        ->get();

        // Pass all to the view
        return view('workspace.vaccine.index', compact('vaccines', 'categories', 'search', 'incompletePatients'));
    }



    public function commonDiseasesIndex()
    {
        $diseases = CommonDisease::orderBy('updated_at', 'desc')->paginate(7);
        // Map of medicine id to name for rendering prescriptions (normalize keys to string)
        $medicineMap = \App\Models\Medicine::get(['_id','name'])
            ->mapWithKeys(function ($m) {
                return [ (string) $m->_id => $m->name ];
            })
            ->all();

        // $why = PatientAssign::get();
        // return $why;
        // Fetch patients with pending common disease assignments using PatientAssign
      $incompletePatients = Patient::whereHas('assignments', function ($query) {
        $query->where('assigned_to', 'common disease')
              ->where('status', 'pending');
    })
    ->where(function ($query) {
        $query->where('common_disease_info_complete', false)
              ->orWhere('common_disease_info_complete', 0)
              ->orWhere('common_disease_info_complete', 'false')
              ->orWhereNull('common_disease_info_complete');
    })
    ->with(['assignments' => function ($query) {
        $query->where('assigned_to', 'common disease')
              ->where('status', 'pending');
    }])
    ->latest()
    ->get();




        return view('workspace.common-diseases.index', compact('diseases', 'incompletePatients', 'medicineMap'));
    }

    public function commonDiseasesPrint()
    {
        $diseases = CommonDisease::orderBy('updated_at', 'desc')->get();
        return view('workspace.common-diseases.print', compact('diseases'));
    }


    public function exportCommonDiseasePdf($id)
    {
        $record = CommonDisease::findOrFail($id);
        $medicineMap = \App\Models\Medicine::get(['_id','name'])
            ->mapWithKeys(function ($m) { return [(string) $m->_id => $m->name]; })
            ->all();
        [$path, $download] = CommonDiseaseExport::savePdf($record, 'workspace.common-diseases.export-pdf', [
            'record' => $record,
            'medicineMap' => $medicineMap,
        ]);
        $full = storage_path('app/' . $path);
        if (file_exists($full)) {
            return response()->download($full, $download)->deleteFileAfterSend(true);
        }
        // Fallback: stream directly if file not found
        $bytes = \App\Exports\CommonDiseaseExport::generatePdf($record, 'workspace.common-diseases.export-pdf', [
            'record' => $record,
            'medicineMap' => $medicineMap,
        ]);
        return response($bytes, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $download . '"',
        ]);
    }

    public function commonDiseasesStore(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'physician' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|in:M,F',
            'drug_diagnosis' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
            'staff_name' => 'nullable|string|max:255',
        ]);

        CommonDisease::create($data);

        return redirect()->back()->with('success', 'Disease saved');
    }

    public function commonDiseasesEdit($id)
    {
        $disease = CommonDisease::findOrFail($id);
        return view('workspace.common-diseases.edit', compact('disease'));
    }

    public function commonDiseasesUpdate(\Illuminate\Http\Request $request, $id)
    {
        $disease = CommonDisease::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'physician' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|in:M,F',
            'drug_diagnosis' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
            'staff_name' => 'nullable|string|max:255',
        ]);

        $disease->update($data);

        return redirect()->route('workspace.common-diseases.index')->with('success', 'Disease updated successfully!');
    }

    public function commonDiseasesDestroy($id)
    {
        $disease = CommonDisease::findOrFail($id);
        $disease->delete();

        return redirect()->route('workspace.common-diseases.index')->with('success', 'Disease deleted successfully!');
    }

    public function gynecologyIndex()
    {
        // Fetch gynecology records with patient information
        $gynecologyRecords = Gynecology::with('patient')->orderBy('updated_at', 'desc')->paginate(10);

        // Fetch patients with pending gynecology assignments using PatientAssign
        $incompletePatients = Patient::whereHas('assignments', function ($query) {
            $query->where('assigned_to', 'gynecology')
                  ->where('status', 'pending');
        })
        ->where(function ($query) {
            $query->where('gynecology_info_complete', false)
                  ->orWhere('gynecology_info_complete', 0)
                  ->orWhere('gynecology_info_complete', 'false')
                  ->orWhereNull('gynecology_info_complete');
        })
        ->with(['assignments' => function ($query) {
            $query->where('assigned_to', 'gynecology')
                  ->where('status', 'pending');
        }])
        ->latest()
        ->get();

        return view('workspace.gynecology.index', compact('gynecologyRecords', 'incompletePatients'));
    }

    public function gynecologyStore(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        GynecologyDisease::create($data);

        return redirect()->route('workspace.gynecology.index')->with('success', 'Disease added successfully!');
    }

    public function gynecologyEdit($id)
    {
        $gynecologyRecord = Gynecology::with('patient')->findOrFail($id);
        $patient = $gynecologyRecord->patient ?? Patient::findOrFail($gynecologyRecord->patient_id);
        $gynecologyDiseases = GynecologyDisease::orderBy('name')->get(['_id', 'name']);
        $medicines = Medicine::orderBy('name')->get(['_id', 'name']);

        return view('workspace.gynecology.patient-form', compact('patient', 'gynecologyDiseases', 'medicines', 'gynecologyRecord'));
    }

    public function gynecologyUpdate(Request $request, $id)
    {
        $gynecologyRecord = Gynecology::findOrFail($id);

        $validated = $request->validate([
            'disease_id' => 'required|string',
            'symptoms' => 'required|string',
            'notes' => 'nullable|string',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medicine_id' => 'required_with:prescriptions|string',
            'prescriptions.*.total_medicine' => 'nullable|integer|min:0',
            'prescriptions.*.total_day' => 'nullable|integer|min:0',
            'prescriptions.*.times' => 'nullable|string|max:255',
        ]);

        // Resolve disease name
        $selectedDisease = GynecologyDisease::find($validated['disease_id']);
        $diseaseName = $selectedDisease ? $selectedDisease->name : ($gynecologyRecord->disease_name ?? 'Unknown');

        // Rebuild prescriptions and medication summary
        $prescriptions = [];
        $medicationSummary = '';
        if (isset($validated['prescriptions']) && is_array($validated['prescriptions'])) {
            foreach ($validated['prescriptions'] as $prescription) {
                if (!empty($prescription['medicine_id'])) {
                    $medicine = Medicine::find($prescription['medicine_id']);
                    $medicineName = $medicine ? $medicine->name : 'Unknown Medicine';
                    $prescriptions[] = [
                        'medicine_id' => $prescription['medicine_id'],
                        'medicine_name' => $medicineName,
                        'total_medicine' => $prescription['total_medicine'] ?? null,
                        'total_day' => $prescription['total_day'] ?? null,
                        'times' => $prescription['times'] ?? '',
                    ];
                    $medicationSummary .= $medicineName;
                    if (!empty($prescription['total_day'])) { $medicationSummary .= " (Total Day: {$prescription['total_day']})"; }
                    if (!empty($prescription['total_medicine'])) { $medicationSummary .= " (Total Medicine: {$prescription['total_medicine']})"; }
                    if (!empty($prescription['times'])) { $medicationSummary .= " ({$prescription['times']})"; }
                    $medicationSummary .= '; ';
                }
            }
        }
        $medicationSummary = rtrim($medicationSummary, '; ');

        // Update record
        $gynecologyRecord->update([
            'disease_id' => $validated['disease_id'],
            'disease_name' => $diseaseName,
            'symptoms' => $validated['symptoms'],
            'medication' => $medicationSummary,
            'prescriptions' => $prescriptions,
            'notes' => $validated['notes'] ?? null,
            // keep treatment_date as original; updated_at will refresh automatically
            'staff_name' => auth()->user()->name ?? ($gynecologyRecord->staff_name ?? 'Unknown'),
        ]);

        return redirect()->route('workspace.gynecology.index')->with('success', 'Gynecology record updated successfully!');
    }

    public function gynecologyDestroy($id)
    {
        $gynecologyRecord = Gynecology::findOrFail($id);
        $gynecologyRecord->delete();

        return redirect()->route('workspace.gynecology.index')->with('success', 'Gynecology record deleted successfully!');
    }

    public function showGynecologyPatientForm($patientId)
    {
        $patient = Patient::with('assignments')->findOrFail($patientId);

        // Get the PatientAssign record for this patient and gynecology assignment
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'gynecology')
            ->latest()
            ->first();

        // Fetch all gynecology diseases for dropdown
        $gynecologyDiseases = GynecologyDisease::orderBy('name')->get(['_id', 'name']);

        // Fetch all medicines for dropdown
        $medicines = Medicine::orderBy('name')->get(['_id', 'name']);

        return view('workspace.gynecology.patient-form', compact('patient', 'patientAssign', 'gynecologyDiseases', 'medicines'));
    }

    public function storeGynecologyPatientInfo(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'disease_id' => 'required|string',
            'symptoms' => 'required|string',
            'notes' => 'nullable|string',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medicine_id' => 'required_with:prescriptions|string',
            'prescriptions.*.total_medicine' => 'nullable|integer|min:0',
            'prescriptions.*.total_day' => 'nullable|integer|min:0',
            'prescriptions.*.times' => 'nullable|string|max:255',
        ]);

        // Get the selected disease
        $selectedDisease = GynecologyDisease::find($validated['disease_id']);
        $diseaseName = $selectedDisease ? $selectedDisease->name : 'Unknown';

        // Process prescriptions
        $prescriptions = [];
        $medicationSummary = '';

        if (isset($validated['prescriptions']) && is_array($validated['prescriptions'])) {
            foreach ($validated['prescriptions'] as $prescription) {
                if (!empty($prescription['medicine_id'])) {
                    $medicine = Medicine::find($prescription['medicine_id']);
                    $medicineName = $medicine ? $medicine->name : 'Unknown Medicine';

                    $prescriptions[] = [
                        'medicine_id' => $prescription['medicine_id'],
                        'medicine_name' => $medicineName,
                        'total_medicine' => $prescription['total_medicine'] ?? null,
                        'total_day' => $prescription['total_day'] ?? null,
                        'times' => $prescription['times'] ?? '',
                    ];

                    // Build medication summary
                    $medicationSummary .= $medicineName;
                    if (!empty($prescription['total_day'])) {
                        $medicationSummary .= " (Total Day: {$prescription['total_day']})";
                    }
                    if (!empty($prescription['total_medicine'])) {
                        $medicationSummary .= " (Total Medicine: {$prescription['total_medicine']})";
                    }
                    if (!empty($prescription['times'])) {
                        $medicationSummary .= " ({$prescription['times']})";
                    }
                    $medicationSummary .= "; ";
                }
            }
        }


        // Trim trailing separator from summary
        $medicationSummary = rtrim($medicationSummary, '; ');

        // Calculate and validate stock requirements, then decrement stock
        if (!empty($prescriptions)) {
            // Aggregate required quantities per medicine
            $requiredByMedicineId = [];
            foreach ($prescriptions as $p) {
                $medicineId = (string) ($p['medicine_id'] ?? '');
                if ($medicineId === '') { continue; }

                $totalMedicine = $p['total_medicine'] ?? null;
                $requiredQty = null;
                if ($totalMedicine !== null) {
                    $requiredQty = (int) $totalMedicine;
                }

                if ($requiredQty !== null && $requiredQty > 0) {
                    if (!isset($requiredByMedicineId[$medicineId])) {
                        $requiredByMedicineId[$medicineId] = 0;
                    }
                    $requiredByMedicineId[$medicineId] += $requiredQty;
                }
            }

            if (!empty($requiredByMedicineId)) {
                // Fetch medicines and check stock availability
                $medicineIds = array_keys($requiredByMedicineId);
                $medicines = \App\Models\Medicine::whereIn('_id', $medicineIds)->get(['_id','name','stock_quantity']);
                $stockErrors = [];
                $availableById = [];
                foreach ($medicines as $m) {
                    $idStr = (string) $m->_id;
                    $availableById[$idStr] = (int) ($m->stock_quantity ?? 0);
                }
                foreach ($requiredByMedicineId as $id => $req) {
                    $available = $availableById[$id] ?? null;
                    if ($available === null) {
                        $stockErrors[] = 'Selected medicine not found: #' . $id;
                    } elseif ($available < $req) {
                        $name = optional($medicines->firstWhere('_id', $id))->name ?? ('#' . $id);
                        $stockErrors[] = 'Insufficient stock for ' . $name . ' (need ' . $req . ', available ' . $available . ').';
                    }
                }

                if (!empty($stockErrors)) {
                    return redirect()->back()->withErrors($stockErrors)->withInput();
                }

                // Decrement stock atomically per medicine
                foreach ($requiredByMedicineId as $id => $req) {
                    if ($req > 0) {
                        \App\Models\Medicine::where('_id', $id)->decrement('stock_quantity', (int) $req);
                    }
                }
            }
        }


        // Create gynecology record
        Gynecology::create([
            'patient_id' => $patientId,
            'disease_id' => $validated['disease_id'],
            'disease_name' => $diseaseName,
            'symptoms' => $validated['symptoms'],
            'medication' => $medicationSummary,
            'prescriptions' => $prescriptions,
            'notes' => $validated['notes'],
            'treatment_date' => now()->toDateString(),
            'staff_name' => auth()->user()->name ?? 'Unknown',
        ]);

        // dd("dol nis");

        // Update patient with gynecology information and mark as complete
        $patient->update([
            'gynecology_info_complete' => true,
        ]);

        // Update PatientAssign status to completed
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'gynecology')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'completed',
                'processed_at' => now()
            ]);
        }

        return redirect()->route('workspace.gynecology.index')->with('success', 'Gynecology information completed successfully!');
    }

    public function dismissGynecologyPatient($patientId)
    {
        // Update PatientAssign status to dismissed
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'gynecology')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'dismissed',
                'processed_at' => now()
            ]);
        }

        return redirect()->route('workspace.gynecology.index')->with('success', 'Patient dismissed successfully!');
    }

    public function medicineIndex()
    {
        return redirect()->route('workspace.medicine.index');
    }

    public function showCommonDiseasePatientForm($patientId)
    {
        $patient = Patient::with('assignments')->findOrFail($patientId);

        // Get the PatientAssign record for this patient and common disease assignment
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'common disease')
            ->latest()
            ->first();

        // Fetch all medicines for dropdown
        $medicines = Medicine::orderBy('name')->get(['_id', 'name']);

        return view('workspace.common-diseases.patient-form', compact('patient', 'patientAssign', 'medicines'));
    }

    public function storeCommonDiseasePatientInfo(Request $request, $patientId)
    {
        // dd("dol");
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'symptoms' => 'required|string|max:1000',
            'diagnosis' => 'required|string|max:500',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medicine_id' => 'required_with:prescriptions|string',
            'prescriptions.*.total_medicine' => 'nullable|integer|min:0',
            'prescriptions.*.total_day' => 'nullable|integer|min:0',
            'prescriptions.*.times' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'follow_up_date' => 'nullable|date|after:today',
        ]);

        // Process prescriptions (simplified structure like gynecology)
        $prescriptions = [];
        $medicationSummary = '';

        if (isset($validated['prescriptions']) && is_array($validated['prescriptions'])) {
            foreach ($validated['prescriptions'] as $prescription) {
                if (!empty($prescription['medicine_id'])) {
                    $medicine = Medicine::find($prescription['medicine_id']);
                    $medicineName = $medicine ? $medicine->name : 'Unknown Medicine';

                    $prescriptions[] = [
                        'medicine_id' => $prescription['medicine_id'],
                        'medicine_name' => $medicineName,
                        'total_medicine' => $prescription['total_medicine'] ?? null,
                        'total_day' => $prescription['total_day'] ?? null,
                        'times' => $prescription['times'] ?? '',
                    ];

                    // Build medication summary
                    $medicationSummary .= $medicineName;
                    if (!empty($prescription['total_day'])) {
                        $medicationSummary .= " (Total Day: {$prescription['total_day']})";
                    }
                    if (!empty($prescription['total_medicine'])) {
                        $medicationSummary .= " (Total Medicine: {$prescription['total_medicine']})";
                    }
                    if (!empty($prescription['times'])) {
                        $medicationSummary .= " ({$prescription['times']})";
                    }
                    $medicationSummary .= "; ";
                }
            }
        }

        // Clean up medication summary
        $medicationSummary = rtrim($medicationSummary, '; ');

        // Calculate and validate stock requirements, then decrement stock
        if (!empty($prescriptions)) {
            // Aggregate required quantities per medicine
            $requiredByMedicineId = [];
            foreach ($prescriptions as $p) {
                $medicineId = (string) ($p['medicine_id'] ?? '');
                if ($medicineId === '') { continue; }

                $totalMedicine = $p['total_medicine'] ?? null;
                $totalDays = $p['total_day'] ?? null;

                // Use total_medicine if provided
                $requiredQty = null;
                if ($totalMedicine !== null) {
                    $requiredQty = (int) $totalMedicine;
                }

                if ($requiredQty !== null && $requiredQty > 0) {
                    if (!isset($requiredByMedicineId[$medicineId])) {
                        $requiredByMedicineId[$medicineId] = 0;
                    }
                    $requiredByMedicineId[$medicineId] += $requiredQty;
                }
            }

            if (!empty($requiredByMedicineId)) {
                // Fetch medicines and check stock availability
                $medicineIds = array_keys($requiredByMedicineId);
                $medicines = \App\Models\Medicine::whereIn('_id', $medicineIds)->get(['_id','name','stock_quantity']);
                $stockErrors = [];
                $availableById = [];
                foreach ($medicines as $m) {
                    $idStr = (string) $m->_id;
                    $availableById[$idStr] = (int) ($m->stock_quantity ?? 0);
                }
                foreach ($requiredByMedicineId as $id => $req) {
                    $available = $availableById[$id] ?? null;
                    if ($available === null) {
                        $stockErrors[] = 'Selected medicine not found: #' . $id;
                    } elseif ($available < $req) {
                        $name = optional($medicines->firstWhere('_id', $id))->name ?? ('#' . $id);
                        $stockErrors[] = 'Insufficient stock for ' . $name . ' (need ' . $req . ', available ' . $available . ').';
                    }
                }

                if (!empty($stockErrors)) {
                    return redirect()->back()->withErrors($stockErrors)->withInput();
                }

                // Decrement stock atomically per medicine
                foreach ($requiredByMedicineId as $id => $req) {
                    if ($req > 0) {
                        \App\Models\Medicine::where('_id', $id)->decrement('stock_quantity', (int) $req);
                    }
                }
            }
        }

        $additionalData = [
            'symptoms' => $validated['symptoms'],
            'diagnosis' => $validated['diagnosis'],
            'medication' => $medicationSummary,
            'prescriptions' => $prescriptions,
            'notes' => $validated['notes'],
            'follow_up_date' => $validated['follow_up_date'],
            'treatment_date' => now()->toDateString(),
        ];

        // Update patient with additional data and mark as complete
        $patient->update([
            'common_disease_additional_data' => $additionalData,
            'common_disease_info_complete' => true,
        ]);

        // Update PatientAssign status to completed
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'common disease')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'completed',
                'processed_at' => now()
            ]);
        }

        // Also create a common disease record
        $commonDisease = new CommonDisease();
        $commonDisease->fill([
            'name' => $patient->first_name . ' ' . $patient->last_name,
            'category' => $validated['diagnosis'], // Using diagnosis as category
            'physician' => Auth::user()->name ?? 'Unknown',
            'age' => \Carbon\Carbon::parse($patient->date_of_birth)->age,
            'gender' => strtoupper(substr($patient->gender, 0, 1)),
            'drug_diagnosis' => $medicationSummary,
            'village' => $patient->address,
            'commune' => 'N/A', // You can add this to patient model if needed
            'staff_name' => Auth::user()->name ?? 'Unknown',
        ]);

        // Attach structured prescriptions separately in case of fillable restrictions
        $commonDisease->prescriptions = $prescriptions;
        $commonDisease->save();

        // Add history entry for common disease treatment
        $historyData = [
            'symptoms' => $validated['symptoms'],
            'diagnosis' => $validated['diagnosis'],
            'medication' => $medicationSummary,
            'prescriptions' => $prescriptions,
            'notes' => $validated['notes'],
            'follow_up_date' => $validated['follow_up_date'],
            'treatment_date' => now()->toDateString(),
            'physician' => Auth::user()->name ?? 'Unknown',
            'age' => \Carbon\Carbon::parse($patient->date_of_birth)->age,
            'gender' => strtoupper(substr($patient->gender, 0, 1)),
            'village' => $patient->address,
            'common_disease_record_id' => $commonDisease->_id
        ];

        $patient->addHistoryEntry('common_disease', $historyData, Auth::user()->name ?? 'Unknown');

        return redirect()->route('workspace.common-diseases.index')
            ->with('success', 'Common disease information added successfully!');
    }

    public function dismissCommonDiseasePatient($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $patient->update(['common_disease_info_complete' => true]);

        // Update PatientAssign status to completed when dismissing
        $patientAssign = PatientAssign::where('patient_id', $patientId)
            ->where('assigned_to', 'common disease')
            ->latest()
            ->first();

        if ($patientAssign) {
            $patientAssign->update([
                'status' => 'completed',
                'processed_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Patient dismissed from common disease completion list.');
    }

    public function commonDiseasePatientSearch(Request $request)
    {
        $q = (string) $request->query('q', '');
        $limit = (int) $request->query('limit', 8);
        $limit = max(1, min($limit, 20));

        if ($q === '') {
            return response()->json(['data' => []]);
        }

        $patients = Patient::whereHas('assignments', function($query) {
                $query->where('assigned_to', 'common disease')
                      ->where('status', 'pending');
            })
            ->where(function($query) use ($q) {
                $query->where('first_name', 'like', '%' . $q . '%')
                      ->orWhere('last_name', 'like', '%' . $q . '%');
            })
            ->latest()
            ->limit($limit)
            ->get(['_id', 'first_name', 'last_name']);

        $data = $patients->map(function($p) {
            return [
                'id' => (string) $p->_id,
                'name' => trim(($p->first_name ?? '') . ' ' . ($p->last_name ?? '')),
                'url' => route('workspace.common-diseases.patient.form', $p->_id),
            ];
        })->values();

        return response()->json(['data' => $data]);
    }
}
