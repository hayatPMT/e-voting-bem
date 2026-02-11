<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile page
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->getProfile();

        return view('profile.index', compact('user', 'profile'));
    }

    /**
     * Update user profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->getProfile();

        // Validation rules based on role
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ];

        if ($user->isMahasiswa()) {
            $rules['nim'] = 'required|string|max:20|unique:mahasiswa_profiles,nim,'.($profile->id ?? '');
            $rules['program_studi'] = 'nullable|string|max:100';
            $rules['angkatan'] = 'nullable|string|max:4';
            $rules['semester'] = 'nullable|integer|min:1|max:14';
        } else {
            $rules['department'] = 'nullable|string|max:100';
            $rules['bio'] = 'nullable|string|max:500';
        }

        $validated = $request->validate($rules);

        // Update user table
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update profile table
        if ($profile) {
            $profileData = [
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'province' => $validated['province'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
            ];

            if ($user->isMahasiswa()) {
                $profileData['nim'] = $validated['nim'];
                $profileData['program_studi'] = $validated['program_studi'] ?? null;
                $profileData['angkatan'] = $validated['angkatan'] ?? null;
                $profileData['semester'] = $validated['semester'] ?? null;
            } else {
                $profileData['department'] = $validated['department'] ?? null;
                $profileData['bio'] = $validated['bio'] ?? null;
            }

            $profile->update($profileData);
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update user avatar/photo
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->getProfile();

        if (! $profile) {
            return redirect()->route('profile.index')->with('error', 'Profil tidak ditemukan.');
        }

        // Delete old avatar if exists
        if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
            Storage::disk('public')->delete($profile->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        $profile->update(['avatar' => $avatarPath]);

        return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Verify current password
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui.');
    }
}
