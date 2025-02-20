<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Barryvdh\DomPDF\Facade\Pdf;

class Uplm2PdfExport implements FromCollection, WithHeadings, WithMapping
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
            $query->whereHas('jawaban', function ($q) {
                $q->whereHas('pertanyaan', function ($qPertanyaan) {
                    $qPertanyaan->where('tahun', $this->tahun)->where('kategori', 'UPLM 2');
                });
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

        // Ambil pertanyaan khusus untuk UPLM 2 dan filter berdasarkan tahun
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->get();

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

        // Ambil pertanyaan UPLM 2 dan filter berdasarkan tahun
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->get();

        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban->firstWhere('id_pertanyaan', $pertanyaanItem->id);
            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }

    public function downloadPdf()
    {
        $data = $this->collection();
        $headings = $this->headings();

        // Ambil pertanyaan UPLM 2 dan filter berdasarkan tahun
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->get();

        $pdf = Pdf::loadView('admin.uplm2_pdf', compact('data', 'headings', 'pertanyaan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('uplm2-report.pdf');
    }
}
