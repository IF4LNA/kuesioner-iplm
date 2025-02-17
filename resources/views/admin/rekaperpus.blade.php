@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Monografi Perpustakaan</h2>

    <form action="{{ route('admin.rekaperpus') }}" method="GET" class="mb-3">
        <label for="perpustakaan_id">Pilih Perpustakaan:</label>
        <select name="perpustakaan_id" id="perpustakaan_id" class="form-control w-50">
            <option value="">-- Pilih Perpustakaan --</option>
            @foreach ($perpustakaans as $p)
                <option value="{{ $p->id_perpustakaan }}" {{ $selectedPerpustakaan == $p->id_perpustakaan ? 'selected' : '' }}>
                    {{ $p->nama_perpustakaan }}
                </option>
            @endforeach
        </select>
    
        <label for="tahun">Pilih Tahun:</label>
        <select name="tahun" id="tahun" class="form-control w-50">
            <option value="">-- Pilih Tahun --</option>
            @foreach ($tahunList as $t)
                <option value="{{ $t }}" {{ $selectedTahun == $t ? 'selected' : '' }}>{{ $t }}</option>
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

    <!-- Tabel Data Perpustakaan -->
    <h4>Data Perpustakaan</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama Perpustakaan</th>
                <th>NPP</th>
                <th>Jenis</th>
                <th>Subjenis</th>
                <th>Kota</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @if($perpustakaan)
                <tr>
                    <td>{{ $perpustakaan->nama_perpustakaan }}</td>
                    <td>{{ $perpustakaan->npp ?? '-' }}</td>
                    <td>{{ $perpustakaan->jenis->jenis ?? '-' }}</td>
                    <td>{{ $perpustakaan->jenis->subjenis ?? '-' }}</td>
                    <td>{{ $perpustakaan->kelurahan->kecamatan->kota->nama_kota ?? '-' }}</td>
                    <td>{{ $perpustakaan->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                    <td>{{ $perpustakaan->kelurahan->nama_kelurahan ?? '-' }}</td>
                    <td>{{ $perpustakaan->alamat ?? '-' }}</td>
                    <td>{{ $perpustakaan->kontak ?? '-' }}</td>
                    <td>
                        @if($perpustakaan->foto)
                        <img src="{{ Storage::url($perpustakaan->foto) }}" class="img-thumbnail" width="100" height="100">
                        @else
                            <img src="{{ asset('storage/fotos/default.png') }}" class="img-thumbnail" width="100" height="100">
                        @endif
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tabel Monografi -->
    <h4>Monografi Perpustakaan</h4>
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
