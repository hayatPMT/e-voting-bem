<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;

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
        $csv = "NIM,Nama Lengkap,Email,Program Studi,Angkatan\n";
        $csv .= "12345678,Contoh Mahasiswa,contoh@student.ac.id,Teknik Informatika,2023\n";

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="template_import_mahasiswa.csv"');
    }

    /**
     * Import Mahasiswa from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Skip header
        fgetcsv($handle);

        $successCount = 0;
        $errors = [];
        $row = 1;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $row++;
            if (count($data) < 5) {
                continue;
            }

            $nim = trim($data[0]);
            $nama = trim($data[1]);
            $email = trim($data[2]);
            $prodi = trim($data[3]);
            $angkatan = trim($data[4]);

            // Check duplicate
            if (MahasiswaProfile::where('nim', $nim)->exists() || User::where('email', $email)->exists()) {
                $errors[] = "Baris $row: NIM $nim atau Email $email sudah terdaftar.";

                continue;
            }

            try {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => bcrypt($nim), // Password default NIM
                    'role' => 'mahasiswa',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                MahasiswaProfile::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'program_studi' => $prodi,
                    'angkatan' => $angkatan,
                    'semester' => 1,
                    'status' => 'active',
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Baris $row: Gagal menyimpan data ($nim).";
            }
        }

        fclose($handle);

        $message = "Berhasil mengimpor $successCount mahasiswa.";
        if (count($errors) > 0) {
            $message .= ' Gagal: '.count($errors).' baris.';
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
    public function export()
    {
        $mahasiswa = MahasiswaProfile::with('user')->get();

        $csv = "NIM,Nama,Email,Program Studi,Angkatan,Semester,Status,Sudah Voting\n";

        foreach ($mahasiswa as $m) {
            $csv .= "\"{$m->nim}\",\"{$m->user->name}\",\"{$m->user->email}\",\"{$m->program_studi}\",\"{$m->angkatan}\",\"{$m->semester}\",\"{$m->status}\",\"".($m->has_voted ? 'Ya' : 'Tidak')."\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="mahasiswa_'.date('Y-m-d').'.csv"');
    }

    /**
     * Toggle voting eligibility
     */
    public function toggleVotingStatus($id)
    {
        $mahasiswa = MahasiswaProfile::findOrFail($id);

        // Reset voting status if needed
        $mahasiswa->update([
            'has_voted' => false,
            'voted_at' => null,
        ]);

        return back()->with('success', 'Status voting mahasiswa berhasil direset');
    }
}
