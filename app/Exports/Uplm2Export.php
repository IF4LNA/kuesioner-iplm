<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;

class Uplm2Export implements FromCollection, WithHeadings, WithMapping
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;
    protected $page;
    protected $perPage;
    protected $currentTahun;

    public function __construct($jenis = null, $subjenis = null, $tahun = null, $page = 1, $perPage = 10)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->currentTahun = $tahun ?: Pertanyaan::where('kategori', 'UPLM 2')->max('tahun');
    }

    public function collection()
    {
        $query = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jenis', 'jawaban.pertanyaan']);

        // Gabungkan filter jenis & subjenis
        if ($this->jenis || $this->subjenis) {
            $query->whereHas('jenis', function ($q) {
                if ($this->jenis) {
                    $q->where('jenis', $this->jenis);
                }
                if ($this->subjenis) {
                    $q->where('subjenis', $this->subjenis);
                }
            });
        }

        // Pagination: jika allData maka perPage null
        if (is_null($this->perPage)) {
            return $query->get();
        }

        return $query
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
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

        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')
            ->where('tahun', $this->currentTahun)
            ->get();

        foreach ($pertanyaan as $item) {
            $headings[] = $item->teks_pertanyaan;
        }

        return $headings;
    }

    public function map($item): array
    {
        static $rowNumber = 1;

        $data = [
            $rowNumber++,
            $this->currentTahun,
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->alamat ?? '-',
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')
            ->where('tahun', $this->currentTahun)
            ->get();

        foreach ($pertanyaan as $q) {
            $jawab = $item->jawaban
                ->where('id_pertanyaan', $q->id_pertanyaan)
                ->first();

            $data[] = $jawab ? $jawab->jawaban : '-';
        }

        return $data;
    }
}
