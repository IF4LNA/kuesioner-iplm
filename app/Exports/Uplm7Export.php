<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Perpustakaan;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Log;

class Uplm7Export implements FromCollection, WithHeadings, WithMapping
{
    protected $jenis;
    protected $subjenis;
    protected $tahun;
    protected $page;
    protected $perPage;
    protected $currentTahun;
    protected $sortField;
    protected $sortOrder;

    public function __construct(
        $jenis = null, 
        $subjenis = null, 
        $tahun = null, 
        $page = 1, 
        $perPage = 10,
        $sortField = 'nama_perpustakaan',
        $sortOrder = 'asc'
    ) {
        $this->jenis = $jenis;
        $this->subjenis = $subjenis;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->sortField = $sortField;
        $this->sortOrder = $sortOrder;
        $this->currentTahun = $tahun ?: Pertanyaan::where('kategori', 'UPLM 7')->max('tahun') ?? date('Y');
        
        Log::info('Export UPLM7 initialized with parameters:', [
            'tahun' => $this->currentTahun,
            'sortField' => $this->sortField,
            'sortOrder' => $this->sortOrder
        ]);
    }

    public function collection()
    {
        $query = Perpustakaan::with([
            'user', 
            'kelurahan.kecamatan', 
            'jenis', 
            'jawaban' => function($query) {
                $query->whereHas('pertanyaan', function($q) {
                    $q->where('kategori', 'UPLM 7')
                      ->where('tahun', $this->currentTahun);
                });
            },
            'jawaban.pertanyaan'
        ]);

        // Apply jenis/subjenis filters
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

        // Validate and apply sorting
        $validSortFields = ['nama_perpustakaan', 'npp', 'created_at'];
        $sortField = in_array($this->sortField, $validSortFields) ? $this->sortField : 'nama_perpustakaan';
        $sortOrder = $this->sortOrder === 'desc' ? 'desc' : 'asc';

        // For all data export
        if (is_null($this->perPage)) {
            return $query->orderBy($sortField, $sortOrder)->get();
        }

        // Paginated export
        return $query->orderBy($sortField, $sortOrder)
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

        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')
            ->where('tahun', $this->currentTahun)
            ->orderBy('id_pertanyaan')
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

        $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')
            ->where('tahun', $this->currentTahun)
            ->orderBy('id_pertanyaan')
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