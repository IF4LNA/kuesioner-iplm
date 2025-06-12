<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Log;

class Uplm1Export implements FromCollection, WithHeadings, WithMapping
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
        
        // Set tahun dengan prioritas: parameter > tahun terbaru dari database > tahun sekarang
        $this->tahun = $tahun ?? Pertanyaan::where('kategori', 'UPLM 1')->max('tahun') ?? date('Y');
        
        Log::info('Export UPLM1 initialized with tahun: ' . $this->tahun);
    }

    public function collection()
    {
        $query = Perpustakaan::with([
            'user',
            'jenis',
            'kelurahan.kecamatan',
            'jawaban' => function($query) {
                $query->whereHas('pertanyaan', function($q) {
                    $q->where('kategori', 'UPLM 1')
                      ->where('tahun', $this->tahun);
                });
            },
            'jawaban.pertanyaan'
        ]);

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

        // Untuk ekspor semua data
        if (is_null($this->perPage)) {
            return $query->orderBy('nama_perpustakaan')->get();
        }

        // Paginasi untuk preview
        return $query->orderBy('nama_perpustakaan')
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
            'Nama Pengelola',
            'Kontak',
            'Alamat',
            'Email',
            'Kelurahan',
            'Kecamatan',
        ];

        // Ambil pertanyaan untuk tahun yang sudah ditentukan
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')
            ->where('tahun', $this->tahun)
            ->orderBy('id_pertanyaan')
            ->get();

        foreach ($pertanyaan as $pertanyaanItem) {
            $headings[] = $pertanyaanItem->teks_pertanyaan;
        }

        return $headings;
    }

    public function map($item): array
    {
        static $rowNumber = 1;

        $data = [
            $rowNumber++,
            $this->tahun, // Gunakan tahun yang sudah ditentukan
            $item->nama_perpustakaan ?? '-',
            $item->npp ?? '-',
            $item->jenis->jenis ?? '-',
            $item->jenis->subjenis ?? '-',
            $item->nama_pengelola ?? '-',
            $item->kontak ?? '-',
            $item->alamat ?? '-',
            $item->user->email ?? '-',
            $item->kelurahan->nama_kelurahan ?? '-',
            $item->kelurahan->kecamatan->nama_kecamatan ?? '-',
        ];

        // Ambil pertanyaan untuk tahun yang sudah ditentukan
        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')
            ->where('tahun', $this->tahun)
            ->orderBy('id_pertanyaan')
            ->get();

        // Mapping jawaban
        foreach ($pertanyaan as $pertanyaanItem) {
            $jawaban = $item->jawaban
                ->where('id_pertanyaan', $pertanyaanItem->id_pertanyaan)
                ->first();

            $data[] = $jawaban ? $jawaban->jawaban : '-';
        }

        return $data;
    }
}