<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminProfile;
use App\Models\Kampus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKampusController extends Controller
{
    /**
     * Display all admins grouped by campus
     */
    public function index(): View
    {
        $admins = User::where('role', 'admin')
            ->with(['adminProfile', 'kampus'])
            ->latest()
            ->paginate(15);

        $kampusList = Kampus::where('is_active', true)->get();

        return view('superadmin.admins.index', compact('admins', 'kampusList'));
    }

    /**
     * Show the form for creating a new admin for a campus
     */
    public function create(): View
    {
        $kampusList = Kampus::where('is_active', true)->get();

        return view('superadmin.admins.create', compact('kampusList'));
    }

    /**
     * Store a newly created campus admin
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'kampus_id' => 'required|exists:kampus,id',
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'kampus_id' => $request->kampus_id,
            'is_active' => true,
        ]);

        AdminProfile::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'department' => $request->department,
            'status' => 'active',
            'appointed_at' => now(),
        ]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', "Admin {$user->name} berhasil ditambahkan.");
    }

    /**
     * Show the form for editing an admin
     */
    public function edit($id): View
    {
        $admin = User::where('role', 'admin')->with(['adminProfile', 'kampus'])->findOrFail($id);
        $kampusList = Kampus::where('is_active', true)->get();

        return view('superadmin.admins.edit', compact('admin', 'kampusList'));
    }

    /**
     * Update the specified admin
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'kampus_id' => 'nullable|exists:kampus,id',
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'kampus_id' => $request->kampus_id,
        ]);

        $admin->adminProfile()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'phone' => $request->phone,
                'department' => $request->department,
                'status' => $request->status,
            ]
        );

        return redirect()->route('superadmin.admins.index')
            ->with('success', "Admin {$admin->name} berhasil diperbarui.");
    }

    /**
     * Delete the specified admin
     */
    public function destroy($id): RedirectResponse
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    /**
     * Toggle admin active status
     */
    public function toggleStatus($id): RedirectResponse
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->update(['is_active' => ! $admin->is_active]);

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Admin {$admin->name} berhasil {$status}.");
    }
}
