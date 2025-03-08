<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    protected function authenticate($request, array $guards)
    {
        parent::authenticate($request, $guards);

        if (Auth::check() && Auth::user()->role === 'admin') {
            // Cek apakah aktivitas login sudah dicatat di sesi
            if (!session()->has('logged_activity')) {
                ActivityLog::create([
                    'action'      => 'Login',
                    'description' => 'Admin telah login dengan username: ' . Auth::user()->username,
                    'id_akun'     => Auth::user()->id,
                    'created_at'  => now(),
                ]);

                // Set sesi agar tidak mencatat ulang
                session(['logged_activity' => true]);
            }
        }
    }
}

