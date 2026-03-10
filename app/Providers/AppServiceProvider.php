<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            \Illuminate\Support\Facades\View::share('setting', \App\Models\Setting::first());
        }

        \Illuminate\Support\Facades\View::composer('layouts.superadmin', function ($view) {
            if (auth()->check() && auth()->user()->isSuperAdmin()) {
                $view->with('quickKampusList', \App\Models\Kampus::where('is_active', true)->orderBy('nama')->get());
            }
        });
    }
}
