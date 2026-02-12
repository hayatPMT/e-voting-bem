<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use Illuminate\Http\Request;

class TahapanController extends Controller
{
    /**
     * Display a listing of tahapan
     */
    public function index()
    {
        $tahapans = Tahapan::orderBy('waktu_mulai', 'desc')->get();
        $currentTahapan = Tahapan::getCurrentTahapan();

        return view('admin.tahapan.index', compact('tahapans', 'currentTahapan'));
    }

    /**
     * Show the form for creating a new tahapan
     */
    public function create()
    {
        return view('admin.tahapan.create');
    }

    /**
     * Store a newly created tahapan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $tahapan = Tahapan::create($validated);

        return redirect()
            ->route('admin.tahapan.index')
            ->with('success', 'Tahapan berhasil dibuat');
    }

    /**
     * Show the form for editing the specified tahapan
     */
    public function edit(string $id)
    {
        $tahapan = Tahapan::findOrFail($id);

        return view('admin.tahapan.edit', compact('tahapan'));
    }

    /**
     * Update the specified tahapan
     */
    public function update(Request $request, string $id)
    {
        $tahapan = Tahapan::findOrFail($id);

        $validated = $request->validate([
            'nama_tahapan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $tahapan->update($validated);

        return redirect()
            ->route('admin.tahapan.index')
            ->with('success', 'Tahapan berhasil diperbarui');
    }

    /**
     * Remove the specified tahapan
     */
    public function destroy(string $id)
    {
        $tahapan = Tahapan::findOrFail($id);

        if ($tahapan->is_current) {
            return back()->with('error', 'Tidak dapat menghapus tahapan yang sedang aktif');
        }

        $tahapan->delete();

        return redirect()
            ->route('admin.tahapan.index')
            ->with('success', 'Tahapan berhasil dihapus');
    }

    /**
     * Set tahapan as current/active
     */
    public function setAsCurrent(string $id)
    {
        $tahapan = Tahapan::findOrFail($id);
        $tahapan->setAsCurrent();

        return redirect()
            ->route('admin.tahapan.index')
            ->with('success', 'Tahapan berhasil diaktifkan');
    }

    /**
     * Update tahapan status
     */
    public function updateStatus(Request $request, string $id)
    {
        $tahapan = Tahapan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,active,completed',
        ]);

        $tahapan->update($validated);

        return redirect()
            ->route('admin.tahapan.index')
            ->with('success', 'Status tahapan berhasil diperbarui');
    }
}
