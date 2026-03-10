<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getKampusId()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (! $user) {
            return null;
        }

        if ($user->role === 'super_admin') {
            return session('viewing_kampus_id');
        }

        return $user->kampus_id;
    }
}
