<?php

namespace App\Http\Middleware;

use App\Models\Kampus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveCampusFromSlug
{
    /**
     * Resolve the campus from the URL slug and bind it to the request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('kampus_slug');

        if (! $slug) {
            abort(404);
        }

        $kampus = Kampus::where('slug', $slug)->where('is_active', true)->first();

        if (! $kampus) {
            abort(404, 'Portal kampus tidak ditemukan atau tidak aktif.');
        }

        // Share the campus globally for this request
        $request->merge(['resolved_kampus' => $kampus]);
        $request->attributes->set('kampus', $kampus);

        // Share to all views
        view()->share('portalKampus', $kampus);

        return $next($request);
    }
}
