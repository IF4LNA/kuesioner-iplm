<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\User;
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
        // Ambil data pengguna yang login
        $user = Auth::user();
        $username = $user->username;

        // Ambil data perpustakaan terkait
        $perpustakaan = Perpustakaan::where('id_akun', $user->id)->first();

        // Jika tidak ada perpustakaan, kembalikan pesan error
        if (!$perpustakaan) {
            return redirect()->back()->with('error', 'Data perpustakaan tidak ditemukan.');
        }

        // Ambil tahun sekarang
        $tahunSekarang = now()->year;

        // Statistik Cepat
        $totalPertanyaan = Pertanyaan::where('tahun', $tahunSekarang)->count();
        $pertanyaanDijawab = Jawaban::where('id_perpustakaan', $perpustakaan->id_perpustakaan)
            ->where('tahun', $tahunSekarang)
            ->count();
        $pertanyaanBelumDijawab = $totalPertanyaan - $pertanyaanDijawab;

        // Aktivitas Terbaru (satu jawaban terbaru per tahun)
        $aktivitasTerbaru = Jawaban::where('id_perpustakaan', $perpustakaan->id_perpustakaan)
            ->with('pertanyaan') // Eager load relasi pertanyaan
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('tahun') // Kelompokkan berdasarkan tahun
            ->map(function ($jawabanPerTahun) {
                return $jawabanPerTahun->first(); // Ambil satu jawaban terbaru per tahun
            });

        // Data untuk bar chart (jawaban per bulan)
        $jawabanPerBulan = Jawaban::where('id_perpustakaan', $perpustakaan->id_perpustakaan)
            ->where('tahun', $tahunSekarang)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Inisialisasi array untuk data chart (12 bulan)
        $chartData = array_fill(0, 12, 0); // Index 0 = Januari, 11 = Desember
        foreach ($jawabanPerBulan as $bulan => $total) {
            $chartData[$bulan - 1] = $total; // Sesuaikan index (bulan dimulai dari 1)
        }

        return view('pustakawan.dashboard', compact(
            'username',
            'totalPertanyaan',
            'pertanyaanDijawab',
            'pertanyaanBelumDijawab',
            'aktivitasTerbaru',
            'chartData' // Data untuk chart
        ));
    }

    // Mengirim data dari form ke database yang di redirect ke halaman isi kuesioner
    public function store(Request $request)
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Validasi input
        $rules = [
            'alamat' => 'required|string|max:50',
            'npp' => 'required|string|max:50',
            'kontak' => 'nullable|string|max:50|regex:/^[0-9+\-\s]+$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144',
            'desa_kelurahan' => 'required|integer|exists:kelurahans,id',
        ];

        // Jika email diubah, tambahkan validasi unique
        if ($request->email !== $user->email) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
        } else {
            $rules['email'] = 'required|string|email|max:255';
        }

        $request->validate($rules);

        // Ambil data perpustakaan dari user yang login
        /** @var \App\Models\User $user */
        $perpustakaan = $user->perpustakaan;

        // Jika perpustakaan tidak ditemukan, kembalikan dengan error
        if (!$perpustakaan) {
            return redirect()->route('pustakawan.isikuesioner')->with('error', 'Data perpustakaan tidak ditemukan.');
        }

        // Update email user jika email diubah
        if ($request->email !== $user->email) {
            $user->update([
                'email' => $request->email,
            ]);
        }

        // Proses penyimpanan foto jika diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($perpustakaan->foto) {
                Storage::disk('public')->delete($perpustakaan->foto);
            }

            // Ambil nama asli file
            $originalName = $request->file('foto')->getClientOriginalName();

            // Simpan dengan nama asli di dalam folder 'fotos' di penyimpanan publik
            $fotoPath = $request->file('foto')->storeAs('fotos', $originalName, 'public');
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

    // Tahun sekarang dan tahun depan
    $tahunSekarang = now()->year;
    $tahunDepan = $tahunSekarang + 1;

    // Status apakah bisa mengedit
    $editable = false;

    if ($tahun) {
        // Ambil pertanyaan berdasarkan tahun yang dipilih
        $pertanyaans = Pertanyaan::where('tahun', $tahun)->get();

        // Ambil jawaban yang sudah diisi oleh perpustakaan untuk tahun tersebut
        $jawaban = Jawaban::where('tahun', $tahun)
            ->where('id_perpustakaan', $idPerpustakaan)
            ->pluck('jawaban', 'id_pertanyaan');

        // Jika tahun yang dipilih adalah tahun sekarang atau tahun depan, set editable menjadi true
        if ($tahun == $tahunSekarang || $tahun == $tahunDepan) {
            $editable = true;
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
    $tahunDepan = $tahunSekarang + 1;

    // Cek jika tahun lebih kecil dari tahun sekarang, tolak penyimpanan
    if ($tahun < $tahunSekarang) {
        return redirect()->back()->with('error', 'Jawaban hanya dapat diisi untuk tahun sekarang atau tahun depan.');
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


    public function jawabanTersimpan()
    {
        // Menampilkan halaman jawaban tersimpan setelah proses penyimpanan berhasil
        return view('pustakawan.jawabanTersimpan');  // Mengarahkan ke view jawaban_tersimpan
    }
}
