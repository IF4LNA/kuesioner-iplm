<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapPerpusExport implements FromView, WithStyles
{
    protected $perpustakaan;
    protected $selectedTahun;

    public function __construct($perpustakaan, $selectedTahun)
    {
        $this->perpustakaan = $perpustakaan;
        $this->selectedTahun = $selectedTahun;
    }

    public function view(): View
    {
        $monografi = \App\Models\Pertanyaan::where('tahun', $this->selectedTahun)
            ->with(['jawaban' => function ($query) {
                $query->where('id_perpustakaan', $this->perpustakaan->id_perpustakaan);
            }])->get();

        return view('admin.export_excel', [
            'perpustakaan' => $this->perpustakaan,
            'monografi' => $monografi,
            'selectedTahun' => $this->selectedTahun
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Set the header bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Adjust column widths based on content
        $sheet->getColumnDimension('A')->setWidth(20); // Kategori
        $sheet->getColumnDimension('B')->setWidth(30); // Pertanyaan
        $sheet->getColumnDimension('C')->setWidth(50); // Jawaban

        // Set text alignment to left for all columns
        $sheet->getStyle('A:C')->getAlignment()->setHorizontal('left');

        return [
            1 => ['font' => ['bold' => true]], // Header bold
        ];
    }
}


