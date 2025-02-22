@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Dropdown Pilih Tahun -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
        <label for="tahun">Pilih Tahun:</label>
        <select name="tahun" id="tahun" class="form-select w-auto d-inline-block">
            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>

    <!-- Statistik -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-warning text-center p-3">
                <i class="fas fa-book fa-2x"></i>
                <h3>{{ $totalPerpustakaan }}</h3>
                <p>Total Perpustakaan Terdaftar</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary text-center p-3">
                <i class="fas fa-file-alt fa-2x"></i>
                <h3>{{ $totalKuesionerSelesai }}</h3>
                <p>Kuesioner Sudah Diisi ({{ $selectedYear }})</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success text-center p-3">
                <i class="fas fa-chart-line fa-2x"></i>
                <h3>{{ number_format($progresKuesioner, 2) }}%</h3>
                <p>Progres Pengisian Kuesioner</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger text-center p-3">
                <i class="fas fa-times-circle fa-2x"></i>
                <h3>{{ $totalBelumMengisi }}</h3>
                <p>Total Perpustakaan Belum Mengisi</p>
            </div>
        </div>
    </div>
</div>
@endsection
