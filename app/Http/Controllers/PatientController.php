<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Service;
use App\Models\PatientAssign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('assignments');

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by gender (additional filter)
        if ($request->has('gender') && !empty($request->gender) && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        $patients = $query->latest()->paginate(10);

        $services = Service::all();

        // Get available roles for assignment (moved to PatientAssign)
        $roles = PatientAssign::getAssignmentTypes();

        return view('patients.index', compact('patients', 'services', 'roles'));
    }

    public function create()
    {
        return redirect()->route('patients.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ]);

        // Check if patient already exists
        $existingPatient = Patient::findExistingPatient(
            $validated['first_name'],
            $validated['last_name'],
            $validated['phone'],
            $validated['date_of_birth']
        );

        if ($existingPatient) {
            return redirect()->back()->with('error', 'Patient already exists!');
        }

        // Create new patient without role
        $patient = Patient::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
        ]);

        return redirect()->back()->with('success', 'Patient added successfully! You can now assign them to a service.');
    }

    /**
     * Search for existing patients
     */
    public function searchPatients(Request $request)
    {
        $searchTerm = $request->get('search');

        if (empty($searchTerm)) {
            return response()->json(['patients' => []]);
        }

        $patients = Patient::searchPatients($searchTerm);

        return response()->json(['patients' => $patients]);
    }

    /**
     * Assign existing patient to a service
     */
    public function assignExistingPatient(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,_id',
            'role' => 'required|in:vaccine,common disease,gynecology,medicine',
        ]);

        $patient = Patient::findOrFail($validated['patient_id']);
        $patient->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', 'Patient ' . $patient->first_name . ' ' . $patient->last_name . ' has been assigned to ' . $validated['role'] . ' service!');
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
            'gender' => 'required|in:male,female,other',
        ]);

        $patient->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
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

    /**
     * Show assignment form for a patient
     */
    public function showAssignmentForm($id)
    {
        // dd("jere0");
        $patient = Patient::findOrFail($id);
        $assignmentTypes = PatientAssign::getAssignmentTypes();
        $paymentTypes = PatientAssign::getPaymentTypes();

        // Get users for assignment (you can filter by role if needed)
        $users = User::where('role', '!=', 'Medicine')->get();

        return view('patients.assign', compact('patient', 'assignmentTypes', 'paymentTypes', 'users'));
    }

    /**
     * Assign patient to a service
     */
    public function assignPatient(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'assigned_to' => 'required|in:vaccine,common disease,gynecology,medicine',
            'payment_type' => 'required|string',
            'assigned_user_id' => 'required|exists:users,_id', // New: validate assigned user
        ]);

        $patient = Patient::findOrFail($id);

        // Create new assignment
        PatientAssign::create([
            'patient_id' => $patient->_id,
            'assigned_to' => $validated['assigned_to'],
            'assigned_user_id' => $validated['assigned_user_id'], // New: track assigned user
            'assigned_date' => now(),
            'payment_type' => $validated['payment_type'],
            'status' => 'pending', // New: set initial status
        ]);

        // dd("ok");

        return redirect()->route('patients.index')->with('success', 'Patient assigned to ' . $validated['assigned_to'] . ' service successfully!');
    }

    /**
     * Mark a patient assignment as read by the assigned user
     */
    public function markAssignmentAsRead($assignmentId)
    {
        $assignment = PatientAssign::findOrFail($assignmentId);

        // Check if the current user is the assigned user
        if (Auth::user()->_id !== $assignment->assigned_user_id) {
            return redirect()->back()->with('error', 'You are not authorized to mark this assignment as read.');
        }

        $assignment->markAsRead();

        return redirect()->back()->with('success', 'Assignment marked as read successfully!');
    }

    /**
     * Mark a patient assignment as processed by the assigned user
     */
    public function markAssignmentAsProcessed($assignmentId)
    {
        $assignment = PatientAssign::findOrFail($assignmentId);

        // Check if the current user is the assigned user
        if (Auth::user()->_id !== $assignment->assigned_user_id) {
            return redirect()->back()->with('error', 'You are not authorized to mark this assignment as processed.');
        }

        $assignment->update([
            'processed_at' => now(),
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Assignment marked as processed successfully!');
    }

    /**
     * Get assignments for the current user
     */
    public function myAssignments()
    {
        $userId = Auth::user()->_id;

        // Get paginated assignments for the current user with patient information
        $assignments = PatientAssign::where('assigned_user_id', $userId)
            ->with(['patient'])
            ->orderBy('assigned_date', 'desc')
            ->paginate(10); // You can adjust the per-page value as needed

        // Filter out assignments with invalid patients (on the current page)
        $validAssignments = $assignments->getCollection()->filter(function ($assignment) {
            return $assignment->patient !== null;
        });

        // Log any invalid assignments for debugging (on the current page)
        $invalidAssignments = $assignments->getCollection()->filter(function ($assignment) {
            return $assignment->patient === null;
        });

        if ($invalidAssignments->count() > 0) {
            \Log::warning('Found assignments with invalid patients (paginated)', [
                'invalid_count' => $invalidAssignments->count(),
                'invalid_ids' => $invalidAssignments->pluck('_id')->toArray()
            ]);
        }

        // Group assignments by status for better organization (on the current page)
        $assignmentsByStatus = [
            'pending' => $validAssignments->where('status', 'pending'),
            'in_progress' => $validAssignments->where('status', 'in_progress'),
            'completed' => $validAssignments->where('status', 'completed'),
            'cancelled' => $validAssignments->where('status', 'cancelled'),
        ];

        // Get counts for each status (for all assignments, not just current page)
        $allValidAssignments = PatientAssign::where('assigned_user_id', $userId)
            ->whereHas('patient')
            ->get();

        $statusCounts = [
            'total' => $allValidAssignments->count(),
            'pending' => $allValidAssignments->where('status', 'pending')->count(),
            'in_progress' => $allValidAssignments->where('status', 'in_progress')->count(),
            'completed' => $allValidAssignments->where('status', 'completed')->count(),
            'cancelled' => $allValidAssignments->where('status', 'cancelled')->count(),
        ];

        // Replace the paginator's collection with the filtered valid assignments for the current page
        $assignments->setCollection($validAssignments->values());

        // Pass the paginator as $validAssignments to the view
        return view('patients.my-assignments', [
            'validAssignments' => $assignments,
            'assignmentsByStatus' => $assignmentsByStatus,
            'statusCounts' => $statusCounts,
        ]);
    }

    /**
     * Get assignment statistics for the current user
     */
    public function getAssignmentStats()
    {
        $userId = Auth::user()->_id;

        $stats = [
            'total' => PatientAssign::where('assigned_user_id', $userId)->count(),
            'pending' => PatientAssign::where('assigned_user_id', $userId)
                ->whereNull('read_at')
                ->count(),
            'in_progress' => PatientAssign::where('assigned_user_id', $userId)
                ->whereNotNull('read_at')
                ->whereNull('processed_at')
                ->count(),
            'completed' => PatientAssign::where('assigned_user_id', $userId)
                ->whereNotNull('processed_at')
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get completed assignments for the current user
     */
    public function getCompletedAssignments()
    {
        $assignments = PatientAssign::where('assigned_user_id', Auth::user()->_id)
            ->whereNotNull('processed_at') // Only show completed assignments
            ->with(['patient'])
            ->orderBy('processed_at', 'desc')
            ->get();

        return response()->json(['assignments' => $assignments]);
    }

    /**
     * Debug method to see what's in the database
     */
    public function debugAssignments()
    {
        $userId = Auth::user()->_id;

        $allAssignments = PatientAssign::where('assigned_user_id', $userId)->get();
        $pendingAssignments = PatientAssign::where('assigned_user_id', $userId)
            ->whereNull('processed_at')
            ->get();
        $completedAssignments = PatientAssign::where('assigned_user_id', $userId)
            ->whereNotNull('processed_at')
            ->get();

        return response()->json([
            'user_id' => $userId,
            'total_assignments' => $allAssignments->count(),
            'pending_assignments' => $pendingAssignments->count(),
            'completed_assignments' => $completedAssignments->count(),
            'all_assignments' => $allAssignments->toArray(),
            'pending_assignments' => $pendingAssignments->toArray(),
            'completed_assignments' => $completedAssignments->toArray()
        ]);
    }
}
