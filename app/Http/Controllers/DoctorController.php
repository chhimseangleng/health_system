<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where(function($query) {
                        $query->whereNotIn('role', ['Superadmin', 'Super User', 'Admin'])
                              ->orWhereNull('role')
                              ->orWhere('role', '');
                    })
                    ->get();

        return view("doctor.index", compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Redirect to index — we don't have a separate "show" page for doctors
        return redirect()->route('doctors.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = User::findOrFail($id);

        $roles = Role::all();

        return view('doctor.edit', compact('doctor', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',_id',
            'role' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $doctor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $doctor->password = Hash::make($validated['password']);
            $doctor->save();
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = User::findOrFail($id);

        // Prevent deleting the currently authenticated user
        if (auth()->check() && (string) auth()->id() === (string) $doctor->_id) {
            return redirect()->route('doctors.index')->withErrors(trans('lang.cannot_delete_self') ?: 'You cannot delete your own account.');
        }

        // Soft-delete by default: set delete flag
        $doctor->delete = true;
        $doctor->save();

        return redirect()->route('doctors.index')->with('success', trans('lang.user deleted') ?: 'user deleted successfully!');
    }

    /**
     * Soft-delete a doctor (set delete flag).
     */
    public function softDelete(Request $request, string $id)
    {
        $doctor = User::findOrFail($id);

        if (auth()->check() && (string) auth()->id() === (string) $doctor->_id) {
            return redirect()->route('doctors.index')->withErrors(trans('lang.cannot_delete_self') ?: 'You cannot delete your own account.');
        }

        $doctor->delete = true;
        $doctor->save();

        return redirect()->route('doctors.index')->with('success', trans('lang.user deleted') ?: 'user deleted successfully!');
    }
}
