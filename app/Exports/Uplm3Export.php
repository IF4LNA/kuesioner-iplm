<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;

class Uplm3Export implements FromCollection, WithHeadings, WithMapping
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
        
        // Set tahun default di constructor
        $this->currentTahun = $tahun ?: Pertanyaan::where('kategori', 'UPLM 3')->max('tahun');
    }

    public function collection()
{
    $query = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan']);

    // Filter berdasarkan jenis dan subjenis
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
            'Alamat',
            'Kelurahan',
            'Kecamatan',
        ];

        // Ambil pertanyaan khusus untuk tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')
            ->where('tahun', $this->currentTahun)
            ->get();

        foreach ($pertanyaan as $pertanyaanItem) {
            $headings[] = $pertanyaanItem->teks_pertanyaan;
        }

        return $headings;
    }

    public function map($item): array
    {
        static $rowNumber = 1; // Variabel static untuk nomor urut
        
        $data = [
            $rowNumber++, // Nomor urut yang increment
            $this->currentTahun, // Menggunakan tahun yang sudah ditentukan
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->alamat ?? '-',
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        // Ambil jawaban hanya untuk pertanyaan di tahun tertentu
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')
            ->where('tahun', $this->currentTahun)
            ->get();

        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban
                ->where('id_pertanyaan', $pertanyaanItem->id_pertanyaan)
                ->first();

            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }
}
