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
        $roles = Role::all();
        $currentUserRole = Auth::user()->role ?? '';

        // Filter users based on current user's role
        $query = User::query();

        if ($currentUserRole === 'Admin') {
            // Admin can see all users except Superadmin
            $query->where('role', '!=', 'Superadmin')
                  ->where('role', '!=', 'Super User');
        } elseif (in_array($currentUserRole, ['Superadmin', 'Super User'])) {
            // Superadmin can see all users including Admin
            // No filtering needed - show all users
        } else {
            // Other roles see no users
            $query->where('id', '=', 0); // Empty result
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
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('register')->with('success', 'User role updated successfully.');
    }

    /**
     * Delete user
     */
    public function destroy(User $user): RedirectResponse
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

        $user->delete();

        return redirect()->route('register')->with('success', 'User deleted successfully.');
    }
}
