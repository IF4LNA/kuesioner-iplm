<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perpustakaan;
use Illuminate\Support\Facades\Hash;

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

    // Halaman UPLM
    public function showUplm($id)
    {
        $viewName = 'admin.uplm' . $id;

        if (view()->exists($viewName)) {
            return view($viewName);
        } else {
            // Handle error or provide a fallback view
            return abort(404, 'Page not found');
        }
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

        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

}

