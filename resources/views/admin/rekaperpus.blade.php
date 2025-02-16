@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Monografi Perpustakaan</h2>

    <form action="{{ route('admin.rekaperpus') }}" method="GET" class="mb-3">
        <label for="perpustakaan_id">Pilih Perpustakaan:</label>
        <select name="perpustakaan_id" class="form-control w-50">
            <option value="">-- Pilih Perpustakaan --</option>
            @foreach ($perpustakaans as $perpustakaan)
                <option value="{{ $perpustakaan->id_perpustakaan }}" {{ $selectedPerpustakaan == $perpustakaan->id_perpustakaan ? 'selected' : '' }}>
                    {{ $perpustakaan->nama_perpustakaan }} ({{ $perpustakaan->jenis->jenis ?? '-' }} - {{ $perpustakaan->jenis->subjenis ?? '-' }})
                </option>
            @endforeach
        </select>

        <label for="tahun">Pilih Tahun:</label>
        <select name="tahun" class="form-control w-50">
            <option value="">-- Pilih Tahun --</option>
            @foreach ($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ $selectedTahun == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
    </form>

    @if ($monografi->isNotEmpty())
        <a href="{{ route('admin.rekaperpus.export.excel', ['perpustakaan_id' => $selectedPerpustakaan, 'tahun' => $selectedTahun]) }}" class="btn btn-success mb-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.rekaperpus.export.pdf', ['perpustakaan_id' => $selectedPerpustakaan, 'tahun' => $selectedTahun]) }}" class="btn btn-danger mb-2">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monografi as $index => $pertanyaan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                        <td>{{ $pertanyaan->jawaban->first()->jawaban ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
