<?php

namespace App\Exports;

use App\Models\Perpustakaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class Uplm3PdfController implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Perpustakaan::all();
    }
}
