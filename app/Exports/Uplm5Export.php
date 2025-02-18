<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;

class Uplm5Export implements FromCollection, WithHeadings, WithMapping
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;

    public function __construct($jenis = null, $subjenis = null, $tahun = null)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan']);

        // Filter berdasarkan jenis dan subjenis
        if ($this->jenis) {
            $query->whereHas('jenis', function ($q) {
                $q->where('jenis', $this->jenis);
            });
        }

        if ($this->subjenis) {
            $query->whereHas('jenis', function ($q) {
                $q->where('subjenis', $this->subjenis);
            });
        }

        // Filter berdasarkan tahun pertanyaan
        if ($this->tahun) {
            $query->whereHas('jawaban.pertanyaan', function ($q) {
                $q->where('tahun', $this->tahun)->where('kategori', 'UPLM 5');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Tahun',
            'Nama Perpustakaan',
            'NPP',
            'Jenis Perpustakaan',
            'Sub Jenis Perpustakaan',
            'Alamat',
            'Kelurahan',
            'Kecamatan',
        ];

        // Ambil pertanyaan khusus untuk UPLM 4
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
        foreach ($pertanyaan as $pertanyaanItem) {
            $headings[] = $pertanyaanItem->teks_pertanyaan;
        }

        return $headings;
    }

    public function map($item): array
    {
        $data = [
            $item->id,
            $item->created_at->format('Y'),
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->alamat ?? '-',
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        // Ambil jawaban untuk pertanyaan UPLM 4
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban->firstWhere('id_pertanyaan', $pertanyaanItem->id_pertanyaan);
            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }
}