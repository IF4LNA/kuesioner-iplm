<?php

namespace App\Exports;

use App\Models\Perpustakaan;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Concerns\FromView;

class UplmPdfExport implements FromView
{
    protected $jenis, $subjenis, $tahun, $perPage, $page;

    public function __construct($jenis, $subjenis, $tahun, $perPage, $page)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function view(): View
{
    $query = Perpustakaan::with('jenis', 'kelurahan.kecamatan.kota');

    if ($this->jenis) {
        $query->whereHas('jenis', fn($q) => $q->where('jenis', $this->jenis));
    }

    if ($this->subjenis) {
        $query->whereHas('jenis', fn($q) => $q->where('subjenis', $this->subjenis));
    }

    if ($this->tahun) {
        $query->whereHas('jawaban', function ($q) {
            $q->whereHas('pertanyaan', function ($p) {
                $p->where('tahun', $this->tahun)->where('kategori', 'UPLM 2');
            });
        });
    }
    
    // Ambil data sesuai paginasi
    $totalData = $query->count(); // Hitung total data
    $allData = $query->skip(($this->page - 1) * $this->perPage)
                     ->take($this->perPage)
                     ->get();

    // Nomor awal selalu 1 di setiap halaman
    $startNumber = 1; 

    // Format data dengan nomor urut dari 1 lagi di setiap halaman
    $formattedData = $allData->map(function ($perpustakaan, $index) use ($startNumber) {
        return [
            'no' => $startNumber + $index, // Selalu mulai dari 1
            'nama_perpustakaan' => $perpustakaan->nama_perpustakaan,
            'npp' => $perpustakaan->npp,
            'jenis_perpustakaan' => $perpustakaan->jenis?->jenis ?? '-',
            'subjenis' => $perpustakaan->jenis?->subjenis ?? '-',
            'alamat' => $perpustakaan->alamat,
            'kontak' => $perpustakaan->kontak,
            'kelurahan' => $perpustakaan->kelurahan?->nama_kelurahan ?? '-',
            'kecamatan' => $perpustakaan->kelurahan?->kecamatan?->nama_kecamatan ?? 'Tidak ada data',
            'kota' => $perpustakaan->kelurahan?->kecamatan?->kota?->nama_kota ?? '-',
        ];
    });

    // Buat paginasi manual agar tetap sesuai dengan paginasi utama
    $paginatedData = new LengthAwarePaginator(
        $formattedData,
        $totalData,
        $this->perPage,
        $this->page
    );

    return view('admin.uplm_pdf', [
        'data' => $paginatedData,
        'headings' => [
            'No', 'Nama Perpustakaan', 'Npp', 'Jenis Perpustakaan', 'Subjenis',
            'Alamat', 'Kontak', 'Kelurahan', 'Kecamatan', 'Kota',
        ]
    ]);
}
}
