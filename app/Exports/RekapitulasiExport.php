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

        $pertanyaans = Pertanyaan::where('tahun', $this->tahun)->get();

        // Ambil rekapitulasi data
        $rekapData = Jawaban::join('perpustakaans', 'jawabans.id_perpustakaan', '=', 'perpustakaans.id_perpustakaan')
            ->join('jenis_perpustakaans', 'perpustakaans.id_jenis', '=', 'jenis_perpustakaans.id_jenis')
            ->selectRaw('
                jenis_perpustakaans.jenis, 
                jenis_perpustakaans.subjenis, 
                jawabans.id_pertanyaan, 

                SUM(CASE 
                    WHEN jawabans.jawaban REGEXP \'^[1-9][0-9]*$\' THEN jawabans.jawaban 
                    ELSE 0 
                END) as total_angka,

                COUNT(CASE 
                    WHEN jawabans.jawaban REGEXP \'^0[0-9]+$\' THEN 1 -- Jawaban diawali dengan 0
                    WHEN jawabans.jawaban REGEXP \'^[A-Za-z ]+$\' THEN 1 -- Hanya huruf
                    WHEN jawabans.jawaban REGEXP \'[^0-9A-Za-z]\' THEN 1 -- Mengandung simbol
                    WHEN jawabans.jawaban REGEXP \'[0-9]\' AND jawabans.jawaban REGEXP \'[^0-9]\' THEN 1 -- Kombinasi angka & simbol
                    ELSE NULL 
                END) as total_responden
            ')
            ->whereIn('jawabans.id_pertanyaan', $pertanyaans->pluck('id_pertanyaan'))
            ->where('jawabans.tahun', $this->tahun) // Filter berdasarkan tahun
            ->groupBy('jenis_perpustakaans.jenis', 'jenis_perpustakaans.subjenis', 'jawabans.id_pertanyaan')
            ->get()
            ->groupBy(['id_pertanyaan', 'jenis', 'subjenis']);

        // Susun data jawaban ke dalam tabel
        foreach ($pertanyaans as $pertanyaan) {
            $row = [
                'UPLM ' . $pertanyaan->kategori,
                $pertanyaan->teks_pertanyaan,
            ];

            foreach (JenisPerpustakaan::select('jenis', 'subjenis')->get() as $jp) {
                $key = [$pertanyaan->id_pertanyaan, $jp->jenis, $jp->subjenis];

                // Tambahkan pengecekan apakah key tersedia
                $totalAngka = isset($rekapData[$key[0]][$key[1]][$key[2]]) 
                    ? $rekapData[$key[0]][$key[1]][$key[2]]->first()->total_angka 
                    : 0;

                $totalResponden = isset($rekapData[$key[0]][$key[1]][$key[2]]) 
                    ? $rekapData[$key[0]][$key[1]][$key[2]]->first()->total_responden 
                    : 0;

                // Jika totalAngka > 0, maka tampilkan angka. Jika tidak, tampilkan jumlah responden.
                $row[] = ($totalAngka > 0) ? $totalAngka : $totalResponden;
            }

            $data[] = $row;
        }

        return $data;
    }
}
