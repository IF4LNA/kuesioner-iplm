<?php

namespace App\Exports;

use App\Models\Perpustakaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UplmExport implements FromCollection, WithHeadings, WithMapping
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;
    protected $page;
    protected $perPage;

    public function __construct($jenis, $subjenis, $tahun, $page = 1, $perPage = 10)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function collection()
    {
        return collect(
            Perpustakaan::with('jenis', 'kelurahan.kecamatan.kota')
                ->when($this->jenis, fn($query) => $query->whereHas('jenis', fn($q) => $q->where('jenis', $this->jenis)))
                ->when($this->subjenis, fn($query) => $query->whereHas('jenis', fn($q) => $q->where('subjenis', $this->subjenis)))
                ->when($this->tahun, fn($query) => $query->whereHas('jawaban.pertanyaan', fn($q) => $q->where('tahun', $this->tahun)))
                ->paginate($this->perPage, ['*'], 'page', $this->page)
                ->items() // Mengambil hasil paginasi sebagai array
        );
    }

    public function map($perpustakaan): array
{
    static $counter = 0; // Variabel statis agar tetap dihitung dalam satu ekspor
    $counter++; // Tambah nomor urut setiap baris

    return [
        $counter, // Menampilkan nomor urut dari 1 setiap ekspor
        $perpustakaan->nama_perpustakaan,
        $perpustakaan->npp,
        $perpustakaan->jenis?->jenis ?? '-',
        $perpustakaan->jenis?->subjenis ?? '-',
        $perpustakaan->alamat,
        $perpustakaan->kontak,
        $perpustakaan->kelurahan?->nama_kelurahan ?? '-',
        $perpustakaan->kelurahan?->kecamatan?->nama_kecamatan ?? '-',
        $perpustakaan->kelurahan?->kecamatan?->kota?->nama_kota ?? '-',
    ];
}


    public function headings(): array
    {
        return [
            'No',
            'Nama Perpustakaan',
            'NPP',
            'Jenis Perpustakaan',
            'Subjenis',
            'Alamat',
            'Kontak',
            'Kelurahan',
            'Kecamatan',
            'Kota',
        ];
    }
}
