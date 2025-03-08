@extends('layouts.app')

@section('content')
<style>
    /* Gaya dasar untuk kartu */
    .fixed-size-card {
        width: 280px; /* Ukuran tetap untuk lebar kartu */
        height: 200px; /* Ukuran tetap untuk tinggi kartu */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
        margin: 10px auto; /* Pusatkan kartu di dalam kolom */
        overflow: hidden; /* Handle konten yang melebihi ukuran kartu */
    }

    /* Breakpoint untuk layar kecil (mobile) */
    @media (max-width: 767.98px) {
        .fixed-size-card {
            width: 280px; /* Tetap sama di mobile */
            height: 200px; /* Tetap sama di mobile */
        }
    }

    /* Breakpoint untuk layar sedang (tablet) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .fixed-size-card {
            width: 280px; /* Tetap sama di tablet */
            height: 200px; /* Tetap sama di tablet */
        }
    }

    /* Breakpoint untuk layar besar (desktop) */
    @media (min-width: 992px) {
        .fixed-size-card {
            width: 280px; /* Tetap sama di desktop */
            height: 200px; /* Tetap sama di desktop */
        }
    }
</style>
<div class="container mt-4">
    <!-- Dropdown Pilih Tahun -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-body">
            <h2 class="mb-4">Dashboard</h2>
            <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-3">
                <label for="tahun" class="mb-0">Pilih Tahun:</label>
                <select name="tahun" id="tahun" class="form-select w-auto">
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                <button id="toggleFilterButton" class="btn btn-light">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-body">
            <div class="row g-4 justify-content-center"> <!-- Pusatkan kartu -->
                <!-- Total Perpustakaan Terdaftar -->
                <div class="col-md-3 col-12 d-flex justify-content-center">
                    <div class="card text-white bg-warning text-center fixed-size-card">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ $totalPerpustakaan }}</h2>
                        <p class="mb-0">Total Perpustakaan Terdaftar</p>
                    </div>
                </div>

                <!-- Kuesioner Sudah Diisi -->
                <div class="col-md-3 col-12 d-flex justify-content-center">
                    <div class="card text-white bg-primary text-center fixed-size-card">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ $totalKuesionerSelesai }}</h2>
                        <p class="mb-0">Kuesioner Sudah Diisi ({{ $selectedYear }})</p>
                    </div>
                </div>

                <!-- Progres Pengisian Kuesioner -->
                <div class="col-md-3 col-12 d-flex justify-content-center">
                    <div class="card text-white bg-success text-center fixed-size-card">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ number_format($progresKuesioner, 2) }}%</h2>
                        <p class="mb-0">Progres Pengisian Kuesioner</p>
                    </div>
                </div>

                <!-- Total Perpustakaan Belum Mengisi -->
                <div class="col-md-3 col-12 d-flex justify-content-center">
                    <div class="card text-white bg-danger text-center fixed-size-card">
                        <i class="fas fa-times-circle fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ $totalBelumMengisi }}</h2>
                        <p class="mb-0">Total Perpustakaan Belum Mengisi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Perpustakaan Belum Mengisi -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-body">
            <h4 class="mb-4">Daftar Perpustakaan Belum Mengisi ({{ $selectedYear }})</h4>
            @livewire('perpustakaan-belum-mengisi', ['selectedYear' => $selectedYear])
        </div>
    </div>
</div>
@endsection