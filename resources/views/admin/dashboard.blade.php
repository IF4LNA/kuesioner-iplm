@extends('layouts.app')

@section('content')
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
            <div class="row g-4">
                <!-- Total Perpustakaan Terdaftar -->
                <div class="col-md-3">
                    <div class="card text-white bg-warning text-center p-4">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ $totalPerpustakaan }}</h2>
                        <p class="mb-0">Total Perpustakaan Terdaftar</p>
                    </div>
                </div>

                <!-- Kuesioner Sudah Diisi -->
                <div class="col-md-3">
                    <div class="card text-white bg-primary text-center p-4">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ $totalKuesionerSelesai }}</h2>
                        <p class="mb-0">Kuesioner Sudah Diisi ({{ $selectedYear }})</p>
                    </div>
                </div>

                <!-- Progres Pengisian Kuesioner -->
                <div class="col-md-3">
                    <div class="card text-white bg-success text-center p-4">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <h2 class="mb-2">{{ number_format($progresKuesioner, 2) }}%</h2>
                        <p class="mb-0">Progres Pengisian Kuesioner</p>
                    </div>
                </div>

                <!-- Total Perpustakaan Belum Mengisi -->
                <div class="col-md-3">
                    <div class="card text-white bg-danger text-center p-4">
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