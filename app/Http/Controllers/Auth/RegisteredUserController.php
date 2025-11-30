<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Get all roles (unchanged)
        $roles = Role::all();
        $currentUserRole = Auth::user()->role ?? '';

        // Query only Superadmin and Admin users
        $query = User::whereIn('role', ['Superadmin', 'Admin']);

        if ($currentUserRole === 'Admin') {
            // Admin can only see Admins
            $query->where('role', 'Admin');
        } elseif (in_array($currentUserRole, ['Superadmin', 'Super User'])) {
            // Superadmin can see Superadmin + Admin
            // No extra filter needed
        } else {
            // Other roles see no users
            $query->where('id', 0);
        }

        $users = $query->orderBy('name')->paginate(20);

        return view('auth.register', compact('roles', 'users'));
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

// dd("dol");
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Only auto-login if it's a guest registration, not admin creating user
        if (!Auth::check()) {
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        }

        // If admin is creating user, redirect back to register page
        return redirect()->route('register')->with('success', 'User created successfully.');
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $currentUserRole = Auth::user()->role ?? '';

        // Prevent users from modifying themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('register')->with('error', 'You cannot change your own role.');
        }

        // Prevent Admin from modifying Superadmin
        if ($currentUserRole === 'Admin' && in_array($user->role, ['Superadmin', 'Super User'])) {
            return redirect()->route('register')->with('error', 'You do not have permission to modify this user.');
        }

        $request->validate([
            'role' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update role
        $user->role = $request->role;

        // Update password only if provided
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('register')->with('success', 'User role updated successfully.');
    }

    /**
     * Delete user
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Prevent users from deleting themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('register')->with('error', 'You cannot delete yourself.');
        }

        $currentUserRole = Auth::user()->role ?? '';

        // Prevent Admin from deleting Superadmin
        if ($currentUserRole === 'Admin' && in_array($user->role, ['Superadmin', 'Super User'])) {
            return redirect()->route('register')->with('error', 'You do not have permission to delete this user.');
        }

        // Instead of removing the record, mark it as deleted by setting `delete` = true.
        // The User model has a global scope to exclude records where `delete` is true.
        $user->delete = true;
        $user->save();

        return redirect()->route('register')->with('success', 'User marked as deleted.');
    }
}
