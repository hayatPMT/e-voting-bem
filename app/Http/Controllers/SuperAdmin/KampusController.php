<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use App\Models\Kandidat;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KampusController extends Controller
{
    /**
     * Display a listing of all campuses
     */
    public function index(): View
    {
        $kampusList = Kampus::withCount([
            'admins',
            'users as mahasiswa_count' => function ($query) {
                $query->where('role', 'mahasiswa');
            },
        ])->latest()->paginate(10);

        return view('superadmin.kampus.index', compact('kampusList'));
    }

    /**
     * Show the form for creating a new campus
     */
    public function create(): View
    {
        return view('superadmin.kampus.create');
    }

    /**
     * Store a newly created campus
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:kampus,kode',
            'slug' => 'nullable|string|max:50|alpha_dash|unique:kampus,slug',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('kampus-logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Auto-generate slug from kode if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Kampus::generateSlug($validated['kode']);
        }

        $kampus = Kampus::create($validated);

        // Create default settings for this campus
        Setting::create([
            'kampus_id' => $kampus->id,
            'election_name' => "E-Voting BEM {$kampus->nama}",
            'voting_start' => now(),
            'voting_end' => now()->addDay(),
        ]);

        return redirect()->route('superadmin.kampus.show', $kampus)
            ->with('success', "Kampus {$kampus->nama} berhasil ditambahkan. Link portal: {$kampus->portal_url}");
    }

    /**
     * Display the specified campus
     */
    public function show(Kampus $kampus): View
    {
        $kampus->load(['admins.adminProfile', 'settings', 'kandidats', 'votingBooths', 'tahapan']);

        $totalVotes = Kandidat::where('kampus_id', $kampus->id)->sum('total_votes')
            + \App\Models\Vote::whereHas('kandidat', fn ($q) => $q->where('kampus_id', $kampus->id))->count();

        $kandidats = Kandidat::withCount('votes')->where('kampus_id', $kampus->id)->get();

        return view('superadmin.kampus.show', compact('kampus', 'totalVotes', 'kandidats'));
    }

    /**
     * Show the form for editing the campus
     */
    public function edit(Kampus $kampus): View
    {
        return view('superadmin.kampus.edit', compact('kampus'));
    }

    /**
     * Update the specified campus
     */
    public function update(Request $request, Kampus $kampus): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => "required|string|max:20|unique:kampus,kode,{$kampus->id}",
            'slug' => "nullable|string|max:50|alpha_dash|unique:kampus,slug,{$kampus->id}",
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($kampus->logo) {
                Storage::disk('public')->delete($kampus->logo);
            }
            $validated['logo'] = $request->file('logo')->store('kampus-logos', 'public');
        }

        // Auto-generate slug from kode if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Kampus::generateSlug($validated['kode']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $kampus->update($validated);

        return redirect()->route('superadmin.kampus.show', $kampus)
            ->with('success', "Data kampus {$kampus->nama} berhasil diperbarui.");
    }

    /**
     * Remove the specified campus
     */
    public function destroy(Kampus $kampus): RedirectResponse
    {
        if ($kampus->admins()->exists()) {
            return back()->with('error', 'Kampus tidak dapat dihapus karena masih memiliki admin terdaftar.');
        }

        $kampus->delete();

        return redirect()->route('superadmin.kampus.index')
            ->with('success', 'Kampus berhasil dihapus.');
    }

    /**
     * Toggle campus active status
     */
    public function toggleStatus(Kampus $kampus): RedirectResponse
    {
        $kampus->update(['is_active' => ! $kampus->is_active]);

        $status = $kampus->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Kampus {$kampus->nama} berhasil {$status}.");
    }

    /**
     * Set campus context and redirect to admin dashboard for monitoring
     */
    public function monitor(Request $request, Kampus $kampus): RedirectResponse
    {
        $request->session()->put('viewing_kampus_id', $kampus->id);
        $request->session()->save();

        \Illuminate\Support\Facades\Log::info('Setting viewing_kampus_id to: '.$kampus->id.' | Session ID: '.$request->session()->getId());

        return redirect()->route('admin.dashboard')
            ->with('info', "Anda sedang memantau Panel Admin kampus {$kampus->nama} (Mode Read-Only).");
    }

    /**
     * Exit monitoring mode
     */
    public function exitMonitor(Request $request): RedirectResponse
    {
        $request->session()->forget('viewing_kampus_id');

        return redirect()->route('superadmin.dashboard')
            ->with('success', 'Berhasil keluar dari mode monitoring.');
    }
}
