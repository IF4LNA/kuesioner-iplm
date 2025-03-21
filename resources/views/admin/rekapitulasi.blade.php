@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Card untuk Form Filter Tahun -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Filter Rekapitulasi Laporan</h5>
                <!-- Form untuk memilih tahun -->
                <form action="{{ route('rekapitulasi') }}" method="GET" class="mb-3">
                    <div class="form-group">
                        <label for="tahun">Pilih Tahun:</label>
                        <select name="tahun" id="tahun" class="form-control w-25 d-inline">
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                        <button id="toggleFilterButton" class="btn btn-light">
                            <i class="fas fa-filter"></i> Tampilkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card untuk Tombol Export -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Export Data</h5>
                <a href="{{ route('export.rekapitulasi', ['tahun' => $tahunTerpilih]) }}" class="btn btn-success mb-3">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <a href="{{ route('export.rekapitulasi.pdf', ['tahun' => $tahunTerpilih]) }}" class="btn btn-danger mb-3">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>

                <a href="{{ route('admin.rekaperpus') }}" class="btn btn-primary mb-3">
                    Monografi Perpustakaan <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Card untuk Tabel Rekapitulasi -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Rekapitulasi Laporan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <!-- Header Jenis Perpustakaan -->
                            <tr>
                                <th rowspan="2">Uplm</th>
                                <th rowspan="2">Pertanyaan</th>
                                @foreach ($jenisList as $jenis => $subjenisCollection)
                                    <th colspan="{{ $subjenisCollection->count() }}" class="text-center">{{ $jenis }}</th>
                                @endforeach
                            </tr>

                            <!-- Header Subjenis Perpustakaan -->
                            <tr>
                                @foreach ($jenisList as $subjenisCollection)
                                    @foreach ($subjenisCollection as $subjenis)
                                        <th>{{ $subjenis->subjenis }}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris Baru: "UPLM 1 | Jumlah Kelembagaan Perpustakaan" -->
                            <tr>
                                <td>UPLM 1</td>
                                <td>Jumlah Kelembagaan Perpustakaan</td>
                                @foreach ($jenisList as $jenis => $subjenisCollection)
                                    @foreach ($subjenisCollection as $subjenis)
                                        <td class="text-center">
                                            {{ $jumlahPerpustakaan[$jenis][$subjenis->subjenis] ?? 0 }}
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>

                            @foreach ($pertanyaanByKategori as $kategori => $pertanyaanList)
                                <tr>
                                    <td rowspan="{{ $pertanyaanList->count() }}">{{ $kategori }}</td>
                                    @foreach ($pertanyaanList as $pertanyaan)
                                        <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                                        @foreach ($jenisList as $jenis => $subjenisCollection)
                                            @foreach ($subjenisCollection as $subjenis)
                                                <td class="text-center">
                                                    @php
                                                        $rekap = $rekapArray[$jenis][$subjenis->subjenis][
                                                            $pertanyaan->id_pertanyaan
                                                        ] ?? ['total_angka' => 0, 'total_responden' => 0];
                                                        echo $rekap['total_angka'] > 0
                                                            ? $rekap['total_angka']
                                                            : $rekap['total_responden'];
                                                    @endphp
                                                </td>
                                            @endforeach
                                        @endforeach
                                </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 