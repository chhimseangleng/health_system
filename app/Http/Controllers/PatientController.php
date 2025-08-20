<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%");
            });
        }

        $patients = $query->latest()->get();

        $services = Service::all();

        return view('patients.index', compact('patients', 'services'));
    }

    public function create()
    {
        return redirect()->route('patients.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
        ]);

        Patient::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'date' => $validated['date'],
            'patient_id' => 'PAT-' . Str::random(8), // Example: PAT-12345678
        ]);

        return redirect()->back()->with('success', 'Patient added successfully!');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
        ]);

        $patient->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'date' => $validated['date'],
        ]);

        $patient->save();

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'patient_id' => 'required|exists:patients,_id',
            'service_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:pending,completed,cancelled'
        ]);

        Service::create([
            'service_name' => $validated['service_name'],
            'patient_id' => $validated['patient_id'],
            'service_date' => $validated['service_date'] ?? now(),
            'notes' => $validated['notes'] ?? '',
            'status' => $validated['status'] ?? 'pending'
        ]);

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    public function showServices($id)
    {
        $patient = Patient::with('services')->findOrFail($id);
        return view('patients.services', compact('patient'));
    }
}
