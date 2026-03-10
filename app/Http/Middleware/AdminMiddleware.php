<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->role, ['admin', 'super_admin'])) {
            return redirect('/')->with('error', 'Akses ditolak.')->with('warning', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        // Jika dia adalah Super Admin yang memantau panel admin biasa
        if ($user->role === 'super_admin') {
            // Pastikan ada session kampus yang dipilih untuk dipantau
            $viewingKampusId = $request->session()->get('viewing_kampus_id');
            \Illuminate\Support\Facades\Log::info('Super Admin assessing dashboard. viewing_kampus_id is: '.($viewingKampusId ?? 'NULL').' | Session ID: '.$request->session()->getId());

            if (! $viewingKampusId) {
                return redirect()->route('superadmin.dashboard')
                    ->with('warning', 'Pilih kampus yang ingin Anda pantau terlebih dahulu.');
            }

            $allowedMethods = ['GET', 'HEAD', 'OPTIONS'];
            if (! in_array($request->method(), $allowedMethods)) {
                if (! $request->is('logout')) {
                    return back()->with('error', 'Mode Read-Only Aktif: Super Admin tidak dapat melakukan aktivitas CRUD pada panel kampus.');
                }
            }
        }

        if (! $user->is_active) {
            Auth::logout();

            return redirect('/')->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        return $next($request);
    }
}
