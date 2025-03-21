<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\JenisPerpustakaan;
use App\Models\Perpustakaan;

class RekapitulasiExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        $head1 = ['UPLM', 'Pertanyaan'];
        $jenisPerpustakaans = JenisPerpustakaan::select('jenis', 'subjenis')->get()->groupBy('jenis');
        $head2 = ['', ''];

        foreach ($jenisPerpustakaans as $jenis => $subjenisList) {
            foreach ($subjenisList as $sub) {
                $head1[] = $jenis;
                $head2[] = $sub->subjenis;
            }
        }

        return [$head1, $head2];
    }

    public function array(): array
    {
        $data = [];

        // Ambil ID perpustakaan yang sudah mengisi jawaban di tahun tertentu
        $perpustakaanYangMengisi = Jawaban::where('tahun', $this->tahun)
            ->distinct()
            ->pluck('id_perpustakaan')
            ->toArray();

        // Ambil data jumlah perpustakaan per jenis & subjenis yang sudah mengisi
        $perpustakaanData = Perpustakaan::whereIn('id_perpustakaan', $perpustakaanYangMengisi)
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('jenis_perpustakaans.jenis, jenis_perpustakaans.subjenis, COUNT(DISTINCT perpustakaans.id_perpustakaan) as total_perpustakaan')
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis')
            ->get()
            ->keyBy(fn($item) => $item->jenis . '-' . $item->subjenis);

        // Baris jumlah perpustakaan
        $rowJumlah = ['UPLM 1', 'Jumlah Kelembagaan Perpustakaan'];

        foreach (JenisPerpustakaan::select('jenis', 'subjenis')->get() as $jp) {
            $key = $jp->jenis . '-' . $jp->subjenis;
            $rowJumlah[] = $perpustakaanData[$key]->total_perpustakaan ?? 0;
        }

        $data[] = $rowJumlah;

        // Ambil pertanyaan berdasarkan tahun yang dipilih
        $pertanyaans = Pertanyaan::where('tahun', $this->tahun)->get();

        // Ambil rekapitulasi data berdasarkan tipe jawaban
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->join('pertanyaans', 'jawabans.id_pertanyaan', '=', 'pertanyaans.id_pertanyaan')
            ->selectRaw('
                jenis_perpustakaans.jenis, 
                jenis_perpustakaans.subjenis, 
                jawabans.id_pertanyaan, 
                pertanyaans.tipe_jawaban,

                SUM(CASE 
                    WHEN pertanyaans.tipe_jawaban = \'number\' THEN CAST(jawabans.jawaban AS UNSIGNED)
                    ELSE 0
                END) as total_angka,

                COUNT(CASE 
                    WHEN pertanyaans.tipe_jawaban IN (\'text\', \'radio\') THEN 1
                    ELSE NULL
                END) as total_responden
            ')
            ->whereIn('jawabans.id_pertanyaan', $pertanyaans->pluck('id_pertanyaan'))
            ->where('jawabans.tahun', $this->tahun) // Filter berdasarkan tahun
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan', 'pertanyaans.tipe_jawaban')
            ->get()
            ->groupBy(['id_pertanyaan', 'jenis', 'subjenis']);

        // Susun data jawaban ke dalam tabel
        foreach ($pertanyaans as $pertanyaan) {
            $row = [
                $pertanyaan->kategori,
                $pertanyaan->teks_pertanyaan,
            ];

            foreach (JenisPerpustakaan::select('jenis', 'subjenis')->get() as $jp) {
                $key = [$pertanyaan->id_pertanyaan, $jp->jenis, $jp->subjenis];

                // Ambil data rekapitulasi
                $totalAngka = isset($rekapData[$key[0]][$key[1]][$key[2]]) 
                    ? $rekapData[$key[0]][$key[1]][$key[2]]->first()->total_angka 
                    : 0;

                $totalResponden = isset($rekapData[$key[0]][$key[1]][$key[2]]) 
                    ? $rekapData[$key[0]][$key[1]][$key[2]]->first()->total_responden 
                    : 0;

                // Jika tipe jawaban adalah 'number', tampilkan total_angka. Jika tidak, tampilkan total_responden.
                $row[] = ($pertanyaan->tipe_jawaban === 'number') ? $totalAngka : $totalResponden;
            }

            $data[] = $row;
        }

        return $data;
    }
}