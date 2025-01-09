<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class AdminController extends Controller
{
    // Middleware untuk admin
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->middleware('noCache'); // Mencegah caching
    }

    // Dashboard admin
    public function index()
    {
        return view('admin.dashboard');
    }

    public function createUser()
    {
        return view('admin.akun');
    }

    public function recap()
    {
        return view('admin.rekapitulasi');
    }

    public function notifications()
    {
        return view('admin.notifikasi');
    }

    public function settings()
    {
        return view('admin.pengaturan');
    }

    //buat akun
    public function createAccountForm()
    {
        return view('admin.create-account');
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,pustakawan',
            'nama_perpustakaan' => 'required_if:role,pustakawan',
            'jenis' => 'required_if:role,pustakawan|in:umum,sd,smp,mts,sma,smk,ma,khusus,perguruan_tinggi',
        ]);

        // Simpan user
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Jika role adalah pustakawan, simpan data perpustakaan
        if ($request->role == 'pustakawan') {
            Perpustakaan::create([
                'nama_perpustakaan' => $request->nama_perpustakaan,
                'jenis' => $request->jenis,
                'id_akun' => $user->id,
            ]);
        }

        // Menyimpan aktivitas log
        ActivityLog::create([
            'action' => 'Buat Akun',
            'description' => 'Akun baru telah dibuat dengan username: ' . $request->username,
            'id_akun' => auth()->user()->id, // Menggunakan id admin yang sedang login
            'created_at' => now(), // Menyimpan waktu saat log dibuat
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

    public function showActivityLogs()
    {
        // Mengambil data activity logs dengan relasi user
        $activityLogs = ActivityLog::with('user')->get();
        return view('admin.activity-logs', compact('activityLogs'));
    }
}
