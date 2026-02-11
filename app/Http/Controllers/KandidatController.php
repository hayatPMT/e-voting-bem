<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    /**
     * Daftar semua kandidat
     */
    public function index()
    {
        $kandidat = Kandidat::withCount('votes')->orderBy('nama')->paginate(10);

        return view('admin.kandidat.index', compact('kandidat'));
    }

    /**
     * Form tambah kandidat
     */
    public function create()
    {
        return view('admin.kandidat.create');
    }

    /**
     * Simpan kandidat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('nama', 'visi', 'misi');
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kandidat', 'public');
            $data['foto'] = $path;
        }

        Kandidat::create($data);

        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil ditambahkan.');
    }

    /**
     * Form edit kandidat
     */
    public function edit($id)
    {
        $kandidat = Kandidat::findOrFail($id);

        return view('admin.kandidat.edit', compact('kandidat'));
    }

    /**
     * Update kandidat
     */
    public function update(Request $request, $id)
    {
        $kandidat = Kandidat::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('nama', 'visi', 'misi');
        if ($request->hasFile('foto')) {
            if ($kandidat->foto) {
                Storage::disk('public')->delete($kandidat->foto);
            }
            $data['foto'] = $request->file('foto')->store('kandidat', 'public');
        }

        $kandidat->update($data);

        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil diubah.');
    }

    /**
     * Hapus kandidat
     */
    public function destroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        if ($kandidat->foto) {
            Storage::disk('public')->delete($kandidat->foto);
        }
        $kandidat->delete();

        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil dihapus.');
    }
}
