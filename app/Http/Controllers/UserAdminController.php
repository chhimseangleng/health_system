<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Inline middleware to restrict to Admin or Superadmin
        $this->middleware(function ($request, $next) {
            $userRole = Auth::user()->role ?? '';
            if (! Auth::check() || !in_array($userRole, ['Admin', 'Superadmin', 'Super User'])) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
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
        }
        
        $users = $query->orderBy('name')->paginate(20);
        $roles = \App\Models\Role::all();
        
        return view('admin.index', compact('users', 'roles'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => 'required|string|max:100',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User created successfully.']);
        }

        return redirect()->route('admin.index')->with('success', 'User created successfully.');
    }

    public function edit(User $admin)
    {
        return view('admin.edit', ['user' => $admin]);
    }

    public function update(Request $request, User $admin)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$admin->id}",
            'role' => 'required|string|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $admin)
    {
        if (Auth::id() === $admin->id) {
            return redirect()->route('admin.index')->with('error', 'You cannot delete yourself.');
        }

        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}


