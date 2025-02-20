<?php

namespace App\Exports;

use App\Models\Perpustakaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UplmPdfExport implements FromView
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;

    public function __construct($jenis, $subjenis, $tahun)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $query = Perpustakaan::with('jenis', 'kelurahan.kecamatan.kota');

        if ($this->jenis) {
            $query->whereHas('jenis', function ($query) {
                $query->where('jenis', $this->jenis);
            });
        }

        if ($this->subjenis) {
            $query->whereHas('jenis', function ($query) {
                $query->where('subjenis', $this->subjenis);
            });
        }

        if ($this->tahun) {
            $query->whereYear('created_at', $this->tahun);
        }

        $data = $query->get()->map(function ($perpustakaan) {
            return [
                'id_perpustakaan' => $perpustakaan->id_perpustakaan,
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

        return view('admin.uplm_pdf', [
            'data' => $data,
            'headings' => [
                'No',
                'Nama Perpustakaan',
                'Npp',
                'Jenis Perpustakaan',
                'Subjenis',
                'Alamat',
                'Kontak',
                'Kelurahan',
                'Kecamatan',
                'Kota',
            ]
        ]);
    }
}