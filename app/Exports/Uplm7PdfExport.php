<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Barryvdh\DomPDF\Facade\Pdf;

class Uplm7PdfExport implements FromCollection, WithHeadings, WithMapping
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;
    protected $page;
    protected $perPage;

    public function __construct($jenis = null, $subjenis = null, $tahun = null, $page = 1, $perPage = 10)
    {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->tahun = $tahun;
        $this->page = $page;
        $this->perPage = $perPage;
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

        if (!$this->tahun) {
            $this->tahun = Pertanyaan::where('kategori', 'UPLM 7')->max('tahun');
        }

        // Hitung total data yang tersedia
        $totalData = $query->count();

        // Jika perPage lebih besar dari total data, gunakan total data sebagai batas
        $limit = min($this->perPage, $totalData);

        // Paginasi sesuai halaman dan jumlah data yang ditampilkan
        return $query->skip(($this->page - 1) * $this->perPage)
            ->take($limit)
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

        // Gunakan tahun terbaru jika tidak ada tahun yang dikirim
        if (!$this->tahun) {
            $this->tahun = Pertanyaan::where('kategori', 'UPLM 7')->max('tahun');
        }

        // Ambil pertanyaan khusus untuk tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')
            ->where('tahun', $this->tahun)
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
            $this->tahun,
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->alamat ?? '-',
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        // Gunakan tahun terbaru jika tidak ada tahun yang dikirim
        if (!$this->tahun) {
            $this->tahun = Pertanyaan::where('kategori', 'UPLM 7')->max('tahun');
        }

        // Ambil jawaban hanya untuk pertanyaan di tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')
            ->where('tahun', $this->tahun)
            ->get();

        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban
                ->where('id_pertanyaan', $pertanyaanItem->id_pertanyaan)
                ->where('pertanyaan.tahun', $this->tahun) // Pastikan hanya tahun yang sesuai
                ->first();

            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }

    public function downloadPdf()
    {
        $data = $this->collection();
        $headings = $this->headings();

        // Ambil pertanyaan UPLM 7 dan filter berdasarkan tahun
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->get();

        // Teruskan tahun ke view PDF
        $tahun = $this->tahun;

        $pdf = Pdf::loadView('admin.uplm7_pdf', compact('data', 'headings', 'pertanyaan', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('uplm7-report.pdf');
    }
}
