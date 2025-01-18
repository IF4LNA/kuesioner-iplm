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
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required',
            'nama_perpustakaan' => 'required_if:role,pustakawan',
            'jenis' => 'required_if:role,pustakawan',
            'subjenis' => 'required_if:role,pustakawan', // Tambahkan validasi untuk subjenis
        ]);
        
        // Buat akun baru
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password); // Jangan lupa untuk enkripsi password
        $user->role = $request->role;
        $user->save();

        // Jika role adalah pustakawan, simpan data perpustakaan
        if ($request->role == 'pustakawan') {
            // Cari id_jenis berdasarkan kombinasi jenis dan subjenis
            $jenis = DB::table('jenis_perpustakaans')
                ->where('jenis', $request->jenis)
                ->where('subjenis', $request->subjenis)
                ->first();
        
            if (!$jenis) {
                // Jika kombinasi jenis dan subjenis tidak ditemukan, beri pesan error
                return redirect()->back()->withErrors(['message' => 'Jenis dan subjenis tidak ditemukan.']);
            }
        
            // Simpan data ke tabel perpustakaans
            DB::table('perpustakaans')->insert([
                'nama_perpustakaan' => $request->nama_perpustakaan,
                'id_jenis' => $jenis->id_jenis, // Gunakan id_jenis dari tabel jenis_perpustakaans
                'id_akun' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
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

    // Fungsi untuk mendapatkan subjenis berdasarkan jenis yang dipilih
    public function getSubjenis($jenis)
    {
        // Ambil data subjenis yang sesuai berdasarkan jenis
        $subjenis = JenisPerpustakaan::where('jenis', $jenis)
            ->whereNotNull('subjenis')
            ->pluck('subjenis');

        return response()->json(['subjenis' => $subjenis]);
    }
}
