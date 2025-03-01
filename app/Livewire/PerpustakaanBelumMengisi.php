<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Perpustakaan;
use App\Models\JenisPerpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;

class PerpustakaanBelumMengisi extends Component
{
    use WithPagination;

    public $selectedYear;

    protected $paginationTheme = 'bootstrap';

    public function mount($selectedYear)
    {
        $this->selectedYear = $selectedYear;
    }

    public function render()
    {
        $selectedYear = $this->selectedYear ?? Jawaban::max('tahun');
    
        // Hitung total pertanyaan yang tersedia untuk tahun tersebut
        $totalPertanyaan = Pertanyaan::where('tahun', $selectedYear)->count();
    
        // Ambil perpustakaan yang BELUM mengisi semua pertanyaan
        $perpustakaanBelumMengisi = Perpustakaan::where(function ($query) use ($selectedYear, $totalPertanyaan) {
            $query->whereDoesntHave('jawaban', function ($subQuery) use ($selectedYear) {
                $subQuery->where('tahun', $selectedYear);
            })->orWhereHas('jawaban', function ($subQuery) use ($selectedYear) {
                $subQuery->where('tahun', $selectedYear);
            }, '<', $totalPertanyaan);
        })
        ->with(['kelurahan.kecamatan.kota', 'jenis']) // Eager Loading
        ->orderBy('nama_perpustakaan')
        ->paginate(10);
    
        return view('livewire.perpustakaan-belum-mengisi', [
            'perpustakaanBelumMengisi' => $perpustakaanBelumMengisi,
            'selectedYear' => $selectedYear
        ]);
    }
}

