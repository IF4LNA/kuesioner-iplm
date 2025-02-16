<?php

namespace App\Exports;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Perpustakaan;
use Maatwebsite\Excel\Concerns\FromArray;

class RekapPerpusExport implements FromArray
{
    protected $id_perpustakaan;
    protected $tahun;

    public function __construct($id_perpustakaan, $tahun)
    {
        $this->id_perpustakaan = $id_perpustakaan;
        $this->tahun = $tahun;
    }

    public function array(): array
    {
        $perpustakaan = Perpustakaan::find($this->id_perpustakaan);
        $pertanyaan = Pertanyaan::where('tahun', $this->tahun)->get();
        $jawaban = Jawaban::where('id_perpustakaan', $this->id_perpustakaan)->where('tahun', $this->tahun)->get()->keyBy('id_pertanyaan');

        $data = [];
        foreach ($pertanyaan as $p) {
            $data[] = [$p->teks_pertanyaan, $jawaban[$p->id_pertanyaan]->jawaban ?? '-'];
        }

        return $data;
    }
}
