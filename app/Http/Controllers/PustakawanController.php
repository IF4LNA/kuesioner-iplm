<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PustakawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:pustakawan');
        $this->middleware('noCache');
    }

    // Menampilkan halaman dashboard pustakawan
    public function index()
    {
        return view('pustakawan.dashboard');
    }

    // Menampilkan halaman isi kuesioner pustakawan
    public function isikuesioner(Request $request)
    {
        // Mengambil daftar tahun unik dari tabel pertanyaan
        $tahunList = Pertanyaan::select('tahun')->distinct()->pluck('tahun');

        // Cek apakah ada tahun yang dipilih
        $tahun = $request->input('tahun');
        $pertanyaans = collect();  // Menginisialisasi sebagai koleksi kosong

        if ($tahun) {
            // Ambil pertanyaan berdasarkan tahun yang dipilih
            $pertanyaans = Pertanyaan::where('tahun', $tahun)->get();
        }

        // Kirim data ke view
        return view('pustakawan.isikuesioner', compact('tahunList', 'pertanyaans', 'tahun'));
    }


    // Menampilkan data akun login, relasi kota/kec/kel di form
    public function showForm()
    {
        $user = auth()->user();
        $perpustakaan = $user->perpustakaan;
        $kotas = Kota::all();

        if ($perpustakaan) {
            return view('pustakawan.kuesioner', [
                'namaPerpustakaan' => $perpustakaan->nama_perpustakaan,
                'jenisPerpustakaan' => $perpustakaan->jenis,
                'kotas' => $kotas,
                'alamatPustakawan' => $perpustakaan->alamat,
                'nppPustakawan' => $perpustakaan->npp,
                'kontakPustakawan' => $perpustakaan->kontak,
            ]);
        }   

        return redirect()->route('home')->with('error', 'Perpustakaan tidak ditemukan untuk akun ini');
    }

    public function submit(Request $request)
    {
        // Validasi input jawaban
        $request->validate([
            'jawaban' => 'required|array',  // pastikan jawaban adalah array
            'jawaban.*' => 'required|string|max:255',  // pastikan setiap jawaban adalah string yang valid
            'tahun' => 'required|integer',
        ]);

        // Dapatkan id_perpustakaan dari user yang login
        $idPerpustakaan = auth()->user()->perpustakaan->id_perpustakaan;  // Asumsi relasi sudah dibuat di User model

        // Loop untuk menyimpan jawaban
        foreach ($request->jawaban as $idPertanyaan => $jawabanText) {
            // Simpan jawaban ke dalam database
            Jawaban::create([
                'id_pertanyaan' => $idPertanyaan,
                'jawaban' => $jawabanText,
                'tahun' => $request->tahun,
                'user_id' => auth()->user()->id,  // menambahkan ID user untuk identifikasi siapa yang mengirim
                'id_perpustakaan' => $idPerpustakaan,  // Menambahkan id_perpustakaan yang sesuai
            ]);
        }

        // Redirect ke halaman jawaban tersimpan dengan pesan sukses
        return redirect()->route('pustakawan.jawabanTersimpan')->with('success', 'Jawaban berhasil disimpan!');
    }

    // PustakawanController.php

    public function jawabanTersimpan()
    {
        // Menampilkan halaman jawaban tersimpan setelah proses penyimpanan berhasil
        return view('pustakawan.jawabanTersimpan');  // Mengarahkan ke view jawaban_tersimpan
    }




    // Mengirim data dari form ke database yang di redirect ke halaman isi kuesioner
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:50',
            'npp' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:50|regex:/^[0-9+\-\s]+$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desa_kelurahan' => 'required|integer|exists:kelurahans,id',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        $perpustakaan = auth()->user()->perpustakaan;
        if ($perpustakaan) {
            $perpustakaan->update([
                'alamat' => $request->alamat,
                'npp' => $request->npp,
                'kontak' => $request->kontak,
                'foto' => $fotoPath,
                'id_kelurahan' => $request->desa_kelurahan,
            ]);

            return redirect()->route('pustakawan.isikuesioner')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('pustakawan.isikuesioner')->with('error', 'Perpustakaan tidak ditemukan');
    }
}
