<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;

class PustakawanController extends Controller
{
    public function showForm()
{
    // Mengambil pengguna yang sedang login
    $user = auth()->user();  // Mendapatkan pengguna yang sedang login
    
    // Mengambil data perpustakaan yang terkait dengan pengguna (pustakawan)
    $perpustakaan = $user->perpustakaan; // Mengambil relasi perpustakaan dari pengguna yang login
    
    // Memastikan data ditemukan sebelum mengirimkan ke view
    if ($perpustakaan) {
        return view('pustakawan.kuesioner', [
            'namaPerpustakaan' => $perpustakaan->nama_perpustakaan,
            'jenisPerpustakaan' => $perpustakaan->jenis,
        ]);
    } else {
        // Jika data perpustakaan tidak ditemukan, bisa mengarahkan ke halaman lain atau menampilkan pesan error
        return redirect()->route('home')->with('error', 'Perpustakaan tidak ditemukan untuk akun ini');
    }
}


    public function __construct()
    {
        $this->middleware('role:pustakawan');
        $this->middleware('noCache'); // Terapkan middleware untuk mencegah caching
    }

    // Halaman dashboard pustakawan
    public function index()
    {
        return view('pustakawan.dashboard');
    }

    // Halaman form data diri sebelum mengisi kuesioner
    public function kuesioner()
    {
        return view('pustakawan.kuesioner');
    }

    // Menangani kirim data dan redirect ke halaman isikuesioner
    public function kirimData(Request $request)
    {
        // Menambahkan logika untuk menyimpan data jika diperlukan

        // Setelah data dikirim, redirect ke halaman isikuesioner
        return redirect()->route('pustakawan.isikuesioner');
    }
}


