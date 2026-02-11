<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of admin users
     */
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->with('adminProfile')
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        AdminProfile::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'department' => $request->department,
            'address' => $request->address,
            'status' => 'active',
            'appointed_at' => now(),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Display the specified admin
     */
    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->load('adminProfile');

        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->load('adminProfile');

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $admin->adminProfile()->update([
            'phone' => $request->phone,
            'department' => $request->department,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil diperbarui');
    }

    /**
     * Delete the specified admin
     */
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus');
    }

    /**
     * Toggle admin status
     */
    public function toggleStatus($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $newStatus = $admin->is_active ? false : true;
        $admin->update(['is_active' => $newStatus]);

        return back()->with('success', 'Status admin berhasil diubah');
    }
}
