<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Kolom nama harus diisi.',
            'password.required' => 'Kolom password harus diisi.',
        ]);
    

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak terdaftar.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            // Password salah
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->withInput();
        }

        // Jika lolos semua, login user
        Auth::login($user);

        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'pustakawan') {
            return redirect()->route('pustakawan.dashboard');
        }

        // Default redirect
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        auth()->logout();  // Logout pengguna
        $request->session()->invalidate();  // Hapus session
        $request->session()->regenerateToken();  // Regenerasi token untuk keamanan

        // Redirect ke halaman utama setelah logout
        return redirect('/')->with('message', 'Anda telah logout');
    }

    // Form Lupa Password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim Email Reset Password
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan Form Reset Password
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Proses Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset!')
            : back()->withErrors(['email' => __($status)]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset!')
            : back()->withErrors(['email' => __($status)]);
    }
}
