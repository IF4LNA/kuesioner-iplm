<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

    // Mengirim data dari form ke database yang di redirect ke halaman isi kuesioner
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'alamat' => 'required|string|max:50',
            'npp' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:50|regex:/^[0-9+\-\s]+$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144',
            'desa_kelurahan' => 'required|integer|exists:kelurahans,id',
        ]);

        // Ambil data perpustakaan dari user yang login
        $perpustakaan = auth()->user()->perpustakaan;

        // Jika perpustakaan tidak ditemukan, kembalikan dengan error
        if (!$perpustakaan) {
            return redirect()->route('pustakawan.isikuesioner')->with('error', 'Data perpustakaan tidak ditemukan.');
        }

        // Proses penyimpanan foto jika diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($perpustakaan->foto) {
                Storage::disk('public')->delete($perpustakaan->foto);
            }
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        } else {
            $fotoPath = $perpustakaan->foto; // Gunakan foto lama jika tidak diunggah foto baru
        }

        // Update data perpustakaan
        $perpustakaan->update([
            'alamat' => $request->alamat,
            'npp' => $request->npp,
            'kontak' => $request->kontak,
            'foto' => $fotoPath,
            'id_kelurahan' => $request->desa_kelurahan,
        ]);

        return redirect()->route('pustakawan.isikuesioner')->with('success', 'Data pustakawan berhasil disimpan.');
    }

    public function showForm()
    {
        $user = auth()->user();
        $perpustakaan = $user->perpustakaan;
        $kotas = Kota::all();

        if ($perpustakaan) {
            $jenisPerpustakaan = $perpustakaan->jenis;

            return view('pustakawan.kuesioner', [
                'namaPerpustakaan' => $perpustakaan->nama_perpustakaan,
                'jenisPerpustakaan' => $jenisPerpustakaan ? $jenisPerpustakaan->jenis : 'memanggil data jenis',
                'kotas' => $kotas,
                'alamatPustakawan' => $perpustakaan->alamat,
                'nppPustakawan' => $perpustakaan->npp,
                'kontakPustakawan' => $perpustakaan->kontak,
                'fotoPustakawan' => $perpustakaan->foto, // Kirimkan foto ke view
                'selectedKota' => $perpustakaan->kelurahan->kecamatan->kota->id ?? null,  // Ambil ID Kota
                'selectedKecamatan' => $perpustakaan->kelurahan->kecamatan->id ?? null,  // Ambil ID Kecamatan
                'selectedKelurahan' => $perpustakaan->kelurahan->id ?? null,  // Ambil ID Kelurahan
            ]);
        }

        return redirect()->route('home')->with('error', 'Perpustakaan tidak ditemukan untuk akun ini');
    }


    public function isikuesioner(Request $request)
{
    // Mengambil daftar tahun unik dari tabel pertanyaan
    $tahunList = Pertanyaan::select('tahun')->distinct()->pluck('tahun');

    // Cek apakah ada tahun yang dipilih
    $tahun = $request->input('tahun');
    $pertanyaans = collect();
    $jawaban = collect();
    $idPerpustakaan = auth()->user()->perpustakaan->id_perpustakaan;
    
    // Tahun sekarang
    $tahunSekarang = now()->year;
    
    // Status apakah bisa mengedit
    $editable = true;

    if ($tahun) {
        // Ambil pertanyaan berdasarkan tahun yang dipilih
        $pertanyaans = Pertanyaan::where('tahun', $tahun)->get();

        // Ambil jawaban yang sudah diisi oleh perpustakaan untuk tahun tersebut
        $jawaban = Jawaban::where('tahun', $tahun)
            ->where('id_perpustakaan', $idPerpustakaan)
            ->pluck('jawaban', 'id_pertanyaan');

        // Jika tahun lebih kecil dari tahun sekarang, set editable menjadi false
        if ($tahun < $tahunSekarang) {
            $editable = false;
        }
    }

    // Kirim data ke view
    return view('pustakawan.isikuesioner', compact('tahunList', 'pertanyaans', 'tahun', 'jawaban', 'editable'));
}


public function submit(Request $request)
{
    // Ambil tahun dari request
    $tahun = $request->input('tahun');
    $tahunSekarang = now()->year;

    // Cek jika tahun sudah lewat, tolak penyimpanan
    if ($tahun < $tahunSekarang) {
        return redirect()->back()->with('error', 'Jawaban untuk tahun yang sudah lewat tidak dapat diubah.');
    }

    // Validasi input jawaban
    $request->validate([
        'jawaban' => 'required|array',
        'jawaban.*' => 'required|string|max:255',
        'tahun' => 'required|integer',
    ]);

    // Dapatkan id_perpustakaan dari user yang login
    $idPerpustakaan = auth()->user()->perpustakaan->id_perpustakaan;

    // Loop untuk menyimpan atau memperbarui jawaban
    foreach ($request->jawaban as $idPertanyaan => $jawabanText) {
        Jawaban::updateOrCreate(
            [
                'id_pertanyaan' => $idPertanyaan,
                'id_perpustakaan' => $idPerpustakaan,
                'tahun' => $tahun,
            ],
            [
                'jawaban' => $jawabanText,
                'user_id' => auth()->user()->id,
            ]
        );
    }

    return redirect()->route('pustakawan.jawabanTersimpan')->with('success', 'Jawaban berhasil disimpan!');
}


    // PustakawanController.php

    public function jawabanTersimpan()
    {
        // Menampilkan halaman jawaban tersimpan setelah proses penyimpanan berhasil
        return view('pustakawan.jawabanTersimpan');  // Mengarahkan ke view jawaban_tersimpan
    }
}
