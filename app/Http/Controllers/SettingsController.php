<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the settings form
     */
    public function index()
    {
        $setting = Setting::first();
        // If no settings exist (should be seeded, but just in case), create a default one
        if (! $setting) {
            $setting = Setting::create([
                'voting_start' => now(),
                'voting_end' => now()->addDay(),
            ]);
        }

        return view('admin.settings', compact('setting'));
    }

    /**
     * Update the voting schedule
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'election_name' => 'nullable|string|max:255',
            'election_logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'voting_start' => 'required|date',
            'voting_end' => 'required|date|after:voting_start',
        ]);

        $setting = Setting::first();

        $data = [
            'election_name' => $request->election_name,
            'voting_start' => $request->voting_start,
            'voting_end' => $request->voting_end,
        ];

        // Handle logo upload
        if ($request->hasFile('election_logo')) {
            // Delete old logo if exists
            if ($setting && $setting->election_logo) {
                \Storage::disk('public')->delete($setting->election_logo);
            }

            $logoPath = $request->file('election_logo')->store('election-logos', 'public');
            $data['election_logo'] = $logoPath;
        }

        if (! $setting) {
            Setting::create($data);
        } else {
            $setting->update($data);
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan voting berhasil diperbarui.');
    }
}
