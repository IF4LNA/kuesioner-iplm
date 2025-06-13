<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use App\Models\JenisPerpustakaan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
    public function storeAccount(Request $request)
    {
        // Validasi input
        $rules = [
            'username'           => 'required|string|max:255|unique:users,username',
            'password'           => 'required|string|min:8',
            'role'               => 'required',
            'nama_perpustakaan'  => 'required_if:role,pustakawan',
            'jenis'              => 'required_if:role,pustakawan',
        ];
    
        // Jika role adalah pustakawan, cek apakah jenis memiliki subjenis
        if ($request->role === 'pustakawan') {
            $hasSubjenis = JenisPerpustakaan::where('jenis', $request->jenis)
                ->whereNotNull('subjenis')
                ->exists();
    
            // Jika jenis memiliki subjenis, maka subjenis wajib diisi
            if ($hasSubjenis) {
                $rules['subjenis'] = 'required';
            }
        }
    
        $request->validate($rules);
    
        // Buat akun baru
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();
    
        // Jika role adalah pustakawan, simpan data perpustakaan
        if ($request->role == 'pustakawan') {
            // Cari data jenis perpustakaan
            $query = JenisPerpustakaan::where('jenis', $request->jenis);
            
            // Jika jenis memiliki subjenis, tambahkan kondisi where untuk subjenis
            $hasSubjenis = JenisPerpustakaan::where('jenis', $request->jenis)
                ->whereNotNull('subjenis')
                ->exists();
                
            if ($hasSubjenis) {
                $query->where('subjenis', $request->subjenis);
            } else {
                $query->whereNull('subjenis');
            }
    
            $jenisData = $query->first();
    
            if (!$jenisData) {
                return redirect()->back()->withErrors(['message' => 'Jenis perpustakaan tidak ditemukan.']);
            }

                // Cek apakah username sudah digunakan
    if (User::where('username', $request->username)->exists()) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['username' => 'Username sudah digunakan. Silakan pilih username lain.']);
    }
    
            // Simpan data ke tabel perpustakaans
            Perpustakaan::create([
                'nama_perpustakaan' => $request->nama_perpustakaan,
                'id_jenis'          => $jenisData->id_jenis,
                'id_akun'           => $user->id,
            ]);
        }
    
        // Menyimpan aktivitas log
        ActivityLog::create([
            'action'      => 'Buat Akun',
            'description' => 'Akun baru telah dibuat dengan username: ' . $request->username,
            'id_akun'     => auth()->user()->id,
        ]);
    
        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

    public function getSubjenis($jenis)
    {
        // Cek apakah jenis ini memiliki subjenis di database
        $hasSubjenis = JenisPerpustakaan::where('jenis', $jenis)
            ->whereNotNull('subjenis')
            ->exists();
    
        // Jika memiliki subjenis, ambil data subjenis
        $subjenis = [];
        if ($hasSubjenis) {
            $subjenis = JenisPerpustakaan::where('jenis', $jenis)
                ->whereNotNull('subjenis')
                ->pluck('subjenis')
                ->unique()
                ->values()
                ->all();
        }
    
        return response()->json([
            'hasSubjenis' => $hasSubjenis,
            'subjenis' => $subjenis
        ]);
    }
}
