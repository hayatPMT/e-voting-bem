<?php

namespace App\Http\Controllers;

use App\Models\VotingBooth;
use Illuminate\Http\Request;

class VotingBoothController extends Controller
{
    /**
     * Display a listing of voting booths
     */
    public function index()
    {
        $booths = VotingBooth::withCount('attendanceApprovals')->get();

        return view('admin.voting-booths.index', compact('booths'));
    }

    /**
     * Show the form for creating a new voting booth
     */
    public function create()
    {
        return view('admin.voting-booths.create');
    }

    /**
     * Store a newly created voting booth
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_booth' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        VotingBooth::create($validated);

        return redirect()
            ->route('admin.voting-booths.index')
            ->with('success', 'Kamar vote berhasil dibuat');
    }

    /**
     * Show the form for editing the specified voting booth
     */
    public function edit(string $id)
    {
        $booth = VotingBooth::findOrFail($id);

        return view('admin.voting-booths.edit', compact('booth'));
    }

    /**
     * Update the specified voting booth
     */
    public function update(Request $request, string $id)
    {
        $booth = VotingBooth::findOrFail($id);

        $validated = $request->validate([
            'nama_booth' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $booth->update($validated);

        return redirect()
            ->route('admin.voting-booths.index')
            ->with('success', 'Kamar vote berhasil diperbarui');
    }

    /**
     * Remove the specified voting booth
     */
    public function destroy(string $id)
    {
        $booth = VotingBooth::findOrFail($id);
        $booth->delete();

        return redirect()
            ->route('admin.voting-booths.index')
            ->with('success', 'Kamar vote berhasil dihapus');
    }

    /**
     * Toggle voting booth status
     */
    public function toggleStatus(string $id)
    {
        $booth = VotingBooth::findOrFail($id);
        $booth->update(['is_active' => ! $booth->is_active]);

        return back()->with('success', 'Status kamar vote berhasil diubah');
    }

    /**
     * Show waiting screen for a specific booth
     */
    public function standby($id)
    {
        $booth = VotingBooth::findOrFail($id);

        return view('voting-booth.standby', compact('booth'));
    }

    /**
     * Validate voter token and redirect to voting page
     */
    public function validateToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:6',
            'booth_id' => 'required|exists:voting_booths,id',
        ]);

        $token = strtoupper($request->token);

        $approval = \App\Models\AttendanceApproval::where('session_token', $token)
            ->where('status', 'approved')
            ->first();

        if (! $approval) {
            return back()->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        // Assign this booth to the attendance record
        $approval->update(['voting_booth_id' => $request->booth_id]);

        // Check if student already voted
        if ($approval->mahasiswa->mahasiswaProfile->has_voted) {
            $approval->markAsVoted();

            return back()->with('error', 'Mahasiswa tersebut sudah melakukan voting.');
        }

        return redirect()->route('voting-booth.voting', $approval->session_token);
    }

    /**
     * Check for any approved voter assigned to this booth (Legacy polling)
     */
    public function checkStandby($id)
    {
        // ... kept for compatibility ...
    }

    /**
     * Portal to select which booth to open
     */
    public function portal()
    {
        $booths = VotingBooth::where('is_active', true)->get();

        return view('voting-booth.portal', compact('booths'));
    }
}
