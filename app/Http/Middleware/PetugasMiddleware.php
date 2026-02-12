<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('petugas.login');
        }

        if (! auth()->user()->isPetugas()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
