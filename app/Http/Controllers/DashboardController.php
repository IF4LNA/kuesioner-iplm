<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari dropdown atau default ke tahun terbaru
        $selectedYear = $request->input('tahun', Jawaban::max('tahun'));

        // Total perpustakaan terdaftar
        $totalPerpustakaan = Perpustakaan::count();

        // Perpustakaan yang sudah mengisi kuesioner (mengisi semua pertanyaan)
        $totalKuesionerSelesai = Perpustakaan::whereHas('jawaban', function ($query) use ($selectedYear) {
            $query->where('tahun', $selectedYear);
        })->count();

        // Progres pengisian (% perpustakaan yang sudah mengisi)
        $progresKuesioner = ($totalPerpustakaan > 0) ? ($totalKuesionerSelesai / $totalPerpustakaan) * 100 : 0;

        // Total perpustakaan yang belum mengisi
        $totalBelumMengisi = $totalPerpustakaan - $totalKuesionerSelesai;

        // Dropdown Tahun (ambil tahun dari tabel `jawabans`)
        $tahunList = Pertanyaan::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.dashboard', compact(
            'totalPerpustakaan',
            'totalKuesionerSelesai',
            'progresKuesioner',
            'totalBelumMengisi',
            'selectedYear',
            'tahunList'
        ));
    }
}
