<?php

namespace App\Exports;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\JenisPerpustakaan;
use App\Models\Perpustakaan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapitulasiExport implements FromArray, WithHeadings, WithStyles
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        // Ambil pertanyaan berdasarkan tahun
        $pertanyaanList = Pertanyaan::where('tahun', $this->tahun)->pluck('teks_pertanyaan');

        // Buat header
        $header = ['Jenis Perpustakaan', 'Subjenis Perpustakaan', 'Jumlah Perpustakaan'];
        foreach ($pertanyaanList as $pertanyaan) {
            $header[] = $pertanyaan . ' (Total Angka)';
            $header[] = $pertanyaan . ' (Total Responden)';
        }

        return $header;
    }

    public function array(): array
    {
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, jawabans.id_pertanyaan, 
                        SUM(CASE 
                            WHEN jawabans.jawaban REGEXP \'^[0-9]+$\' THEN jawabans.jawaban 
                            ELSE 0 
                        END) as total_angka,
                        COUNT(CASE 
                            WHEN jawabans.jawaban REGEXP \'^[^0-9]+$\' THEN 1  
                            ELSE NULL 
                        END) as total_responden')
            ->whereIn('jawabans.id_pertanyaan', Pertanyaan::where('tahun', $this->tahun)->pluck('id_pertanyaan'))
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan')
            ->get();

        $perpustakaanData = Perpustakaan::join('jawabans', 'perpustakaans.id_perpustakaan', '=', 'jawabans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, COUNT(DISTINCT perpustakaans.id_perpustakaan) as total_perpustakaan')
            ->where('jawabans.tahun', $this->tahun)
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis')
            ->get();

        // Susun data menjadi array
        $rekapArray = [];
        foreach ($rekapData as $data) {
            $rekapArray[$data->jenis][$data->subjenis][$data->id_pertanyaan] = [
                'total_angka' => $data->total_angka,
                'total_responden' => $data->total_responden
            ];
        }

        $jumlahPerpustakaan = [];
        foreach ($perpustakaanData as $data) {
            $jumlahPerpustakaan[$data->jenis][$data->subjenis] = $data->total_perpustakaan;
        }

        $pertanyaanList = Pertanyaan::where('tahun', $this->tahun)->pluck('id_pertanyaan');

        // Format data dalam bentuk array untuk Excel
        $exportData = [];
        foreach ($rekapArray as $jenis => $subjenisData) {
            foreach ($subjenisData as $subjenis => $data) {
                $row = [
                    $jenis,
                    $subjenis,
                    $jumlahPerpustakaan[$jenis][$subjenis] ?? 0
                ];

                foreach ($pertanyaanList as $pertanyaanId) {
                    $row[] = $data[$pertanyaanId]['total_angka'] ?? 0;
                    $row[] = $data[$pertanyaanId]['total_responden'] ?? 0;
                }

                $exportData[] = $row;
            }
        }

        return $exportData;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
