<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaTemplateExport;
use App\Imports\MahasiswaImport;
use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of mahasiswa
     */
    public function index()
    {
        $mahasiswa = MahasiswaProfile::with('user')
            ->paginate(15);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new mahasiswa
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Store a newly created mahasiswa in database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'required|string|unique:mahasiswa_profiles',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|size:4',
        ]);

        // Default password is NIM
        $password = $request->nim;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role' => 'mahasiswa',
            'is_active' => true,
        ]);

        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'angkatan' => $request->angkatan,
            'semester' => 1, // Default semester
            'status' => 'active',
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan. Password default adalah NIM.');
    }

    /**
     * Download Excel Template for Import
     */
    public function downloadTemplate()
    {
        return Excel::download(new MahasiswaTemplateExport, 'template_mahasiswa.xlsx');
    }

    /**
     * Import Mahasiswa from CSV
     */
    /**
     * Import Mahasiswa from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:4096',
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file'));

            return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: '.$e->getMessage());
        }
    }

    /**
     * Display the specified mahasiswa
     */
    public function show($id)
    {
        $mahasiswa = MahasiswaProfile::findOrFail($id);
        $mahasiswa->load('user');

        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified mahasiswa
     */
    public function edit($id)
    {
        $mahasiswa = MahasiswaProfile::findOrFail($id);
        $mahasiswa->load('user');

        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified mahasiswa
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = MahasiswaProfile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$mahasiswa->user_id}",
            'nim' => "required|string|unique:mahasiswa_profiles,nim,{$id}",
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|size:4',
            'semester' => 'required|integer|min:1|max:8',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,graduated,suspended',
        ]);

        $mahasiswa->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $mahasiswa->update([
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    /**
     * Delete the specified mahasiswa
     */
    public function destroy($id)
    {
        $mahasiswa = MahasiswaProfile::findOrFail($id);
        $mahasiswa->user()->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus');
    }

    /**
     * Export mahasiswa list to CSV
     */
    /**
     * Export mahasiswa list to CSV
     */
    public function export()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=mahasiswa_'.date('Y-m-d_H-i-s').'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['NIM', 'Nama', 'Email', 'Program Studi', 'Angkatan', 'Semester', 'Status', 'Sudah Voting'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            MahasiswaProfile::with('user')->chunk(100, function ($mahasiswas) use ($file) {
                foreach ($mahasiswas as $m) {
                    fputcsv($file, [
                        $m->nim,
                        $m->user->name ?? '',
                        $m->user->email ?? '',
                        $m->program_studi,
                        $m->angkatan,
                        $m->semester,
                        $m->status,
                        $m->has_voted ? 'Ya' : 'Tidak',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Resets a student's voting status and corrects the vote count
     */
    public function toggleVotingStatus($id)
    {
        /** @var MahasiswaProfile $mahasiswa */
        $mahasiswa = MahasiswaProfile::findOrFail($id);

        if ($mahasiswa->has_voted && $mahasiswa->vote_receipt) {
            try {
                // 1. Decrypt the receipt to find out which candidate they voted for
                $receiptData = decrypt($mahasiswa->vote_receipt);
                $kandidatId = $receiptData['kandidat_id'];

                // 2. Find ONE anonymous vote record for that candidate and delete it
                // This ensures the rekap count decreases by 1 for the correct candidate
                $vote = \App\Models\Vote::where('kandidat_id', $kandidatId)
                    ->whereNull('user_id')
                    ->first();

                if ($vote) {
                    $vote->delete();
                }
            } catch (\Exception $e) {
                // Log if deduction fails (e.g. data corrupt), but still allow reset
                \Illuminate\Support\Facades\Log::warning("Could not deduct vote count during reset for student {$id}: ".$e->getMessage());
            }
        }

        // 3. Reset the student's personal voting status
        $mahasiswa->update([
            'has_voted' => false,
            'voted_at' => null,
            'vote_receipt' => null,
        ]);

        return back()->with('success', 'Status voting mahasiswa berhasil direset dan perolehan suara telah dikurangi secara otomatis.');
    }
}
