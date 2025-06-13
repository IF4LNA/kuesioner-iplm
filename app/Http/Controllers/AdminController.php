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
        'username' => 'required|string|max:255|unique:users,username',
        'password' => 'required|string|min:8',
        'role' => 'required',
        'nama_perpustakaan' => 'required_if:role,pustakawan',
        'jenis' => 'required_if:role,pustakawan',
    ];

    // Jika role adalah pustakawan, cek apakah jenis memiliki subjenis
    if ($request->role === 'pustakawan') {
        $hasSubjenis = JenisPerpustakaan::where('jenis', $request->jenis)
            ->whereNotNull('subjenis')
            ->exists();

        if ($hasSubjenis) {
            $rules['subjenis'] = 'required';
        }
    }

    // Validasi request
    $validatedData = $request->validate($rules);

    // Buat akun baru
    $user = User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role' => $request->role
    ]);

    // Jika role adalah pustakawan, simpan data perpustakaan
    if ($request->role == 'pustakawan') {
        $query = JenisPerpustakaan::where('jenis', $request->jenis);
        
        if ($hasSubjenis) {
            $query->where('subjenis', $request->subjenis);
        } else {
            $query->whereNull('subjenis');
        }

        $jenisData = $query->first();

        if (!$jenisData) {
            return redirect()->back()->withErrors(['message' => 'Jenis perpustakaan tidak ditemukan.']);
        }

        Perpustakaan::create([
            'nama_perpustakaan' => $request->nama_perpustakaan,
            'id_jenis' => $jenisData->id_jenis,
            'id_akun' => $user->id,
        ]);
    }

    // Menyimpan aktivitas log
    ActivityLog::create([
        'action' => 'Buat Akun',
        'description' => 'Akun baru telah dibuat dengan username: ' . $request->username,
        'id_akun' => auth()->user()->id,
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
