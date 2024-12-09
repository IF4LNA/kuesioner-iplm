<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'pustakawan') {
                return redirect()->route('pustakawan.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Login gagal, periksa username dan password Anda!',
            'password' => 'Password yang Anda masukkan salah!'
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();  // Logout pengguna
        $request->session()->invalidate();  // Hapus session
        $request->session()->regenerateToken();  // Regenerasi token untuk keamanan
        
        // Redirect ke halaman utama setelah logout
        return redirect('/')->with('message', 'Anda telah logout');
    }
    }
    