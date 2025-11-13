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
        // Inline middleware to restrict to Super User without modifying Kernel
        $this->middleware(function ($request, $next) {
            if (! Auth::check() || Auth::user()->role !== 'Super User') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password'] ?? 'password');

        User::create($data);

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


