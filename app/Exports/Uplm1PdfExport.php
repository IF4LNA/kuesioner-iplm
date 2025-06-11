<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Barryvdh\DomPDF\Facade\Pdf;

class Uplm1PdfExport implements FromCollection, WithHeadings, WithMapping
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
    $this->page = $page;
    $this->perPage = $perPage;
    
    // Pastikan tahun selalu memiliki nilai
    $this->tahun = $tahun ?? $this->getLatestYear();
}

protected function getLatestYear()
{
    // Pastikan mengembalikan tahun default jika query null
    return Pertanyaan::where('kategori', 'UPLM 1')->max('tahun') ?? date('Y');
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

    // Jika perPage null (ekspor semua data), kembalikan semua data tanpa paginasi
    if (is_null($this->perPage)) {
        return $query->get();
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
            'Nama Pengelola',
            'Kontak',
            'Alamat',
            'Email',
            'Kelurahan',
            'Kecamatan',
        ];

        // Gunakan tahun terbaru jika tidak ada tahun yang dikirim
        if (empty($this->tahun)) {
            $this->tahun = $this->getLatestYear();
        }

        // Ambil pertanyaan khusus untuk tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')
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
            $this->tahun, // Gunakan tahun yang dipilih di filter
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->nama_pengelola,
            $item->kontak,
            $item->alamat ?? '-',
            $item->user->email,
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        // Ambil semua pertanyaan UPLM 1 untuk tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')
            ->where('tahun', $this->tahun)
            ->get();

        // Loop melalui setiap pertanyaan dan cari jawaban yang sesuai
        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban
                ->where('id_pertanyaan', $pertanyaanItem->id_pertanyaan)
                ->where('pertanyaan.tahun', $this->tahun)
                ->first();

            // Tambahkan jawaban atau nilai default jika jawaban tidak ditemukan
            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }

    public function downloadPdf()
    {
        $data = $this->collection();
        $headings = $this->headings();

        // Ambil pertanyaan UPLM 1 dan filter berdasarkan tahun
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->get();

        // Teruskan tahun ke view PDF
        $tahun = $this->tahun;

        $pdf = Pdf::loadView('admin.uplm1_pdf', compact('data', 'headings', 'pertanyaan', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('uplm1-report.pdf');
    }
}