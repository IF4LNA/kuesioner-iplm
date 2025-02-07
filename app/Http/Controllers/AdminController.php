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
            'username'           => 'required|string|max:255',
            'password'           => 'required|string|min:8',
            'role'               => 'required',
            'nama_perpustakaan'  => 'required_if:role,pustakawan',
            'jenis'              => 'required_if:role,pustakawan',
        ];

        // Jika role adalah pustakawan dan jenis yang dipilih adalah 'umum' atau 'sekolah',
        // maka validasi subjenis diperlukan.
        if ($request->role === 'pustakawan' && in_array($request->jenis, ['umum', 'sekolah'])) {
            $rules['subjenis'] = 'required';
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
            // Cari data jenis perpustakaan berdasarkan pilihan.
            // Untuk jenis 'umum' dan 'sekolah', gunakan kombinasi jenis dan subjenis,
            // sedangkan untuk 'perguruan tinggi' dan 'khusus', cari yang subjenis-nya NULL.
            if (in_array($request->jenis, ['umum', 'sekolah'])) {
                $jenisData = DB::table('jenis_perpustakaans')
                    ->where('jenis', $request->jenis)
                    ->where('subjenis', $request->subjenis)
                    ->first();
            } else {
                $jenisData = DB::table('jenis_perpustakaans')
                    ->where('jenis', $request->jenis)
                    ->whereNull('subjenis')
                    ->first();
            }

            if (!$jenisData) {
                return redirect()->back()->withErrors(['message' => 'Jenis dan subjenis tidak ditemukan.']);
            }

            // Simpan data ke tabel perpustakaans
            DB::table('perpustakaans')->insert([
                'nama_perpustakaan' => $request->nama_perpustakaan,
                'id_jenis'          => $jenisData->id_jenis,
                'id_akun'           => $user->id,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // Menyimpan aktivitas log
        ActivityLog::create([
            'action'      => 'Buat Akun',
            'description' => 'Akun baru telah dibuat dengan username: ' . $request->username,
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

    public function showActivityLogs()
    {
        // Mengambil data activity logs dengan relasi user
        $activityLogs = ActivityLog::with('user')->get();
        return view('admin.activity-logs', compact('activityLogs'));
    }

    public function getSubjenis($jenis)
    {
        // Ambil data subjenis yang sesuai, hanya untuk jenis yang memiliki subjenis
        $subjenis = JenisPerpustakaan::where('jenis', $jenis)
            ->whereNotNull('subjenis')
            ->pluck('subjenis');

        return response()->json(['subjenis' => $subjenis]);
    }
}
