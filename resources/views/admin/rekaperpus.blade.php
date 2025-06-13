@extends('layouts.app')

@section('content')
    <!-- cdn -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-selection__placeholder {
            color: #1b1a1a !important;
        }
    </style>
    <div class="container mt-4">
        <!-- Card untuk Form Filter -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-header bg-white text-black">
                <h5 class="card-title mb-0">Filter Monografi Perpustakaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.rekaperpus') }}" method="GET" class="mb-3">
                    <div class="row">
                        <!-- Dropdown Perpustakaan -->
                        <div class="col-md-6 mb-3">
                            <label for="perpustakaan_id" class="form-label">Pilih Perpustakaan:</label>
                            <select name="perpustakaan_id" id="perpustakaan_id" class="form-control border-light">
                                <option value="">-- Pilih Perpustakaan --</option>
                                @foreach ($perpustakaans as $p)
                                    <option value="{{ $p->id_perpustakaan }}" 
                                        {{ $selectedPerpustakaan == $p->id_perpustakaan ? 'selected' : '' }}>
                                        {{ $p->nama_perpustakaan }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>

                        <!-- Dropdown Tahun -->
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control border-secondary">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($tahunList as $t)
                                    <option value="{{ $t }}" {{ $selectedTahun == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($monografi->isNotEmpty())
            <!-- Card untuk Tombol Export -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Export Data</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.rekaperpus.export.excel', ['perpustakaan_id' => $selectedPerpustakaan, 'tahun' => $selectedTahun]) }}"
                        class="btn btn-success mb-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.rekaperpus.export.pdf', ['perpustakaan_id' => $selectedPerpustakaan, 'tahun' => $selectedTahun]) }}"
                        class="btn btn-danger mb-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            <!-- Card untuk Tabel Data Perpustakaan -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Pengelola Perpustakaan</th>
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
                                @if ($perpustakaan)
                                    <tr>
                                        @php
                                            $data = [
                                                $perpustakaan->nama_pengelola,
                                                $perpustakaan->nama_perpustakaan,
                                                $perpustakaan->npp ?? '-',
                                                $perpustakaan->jenis->jenis ?? '-',
                                                $perpustakaan->jenis->subjenis ?? '-',
                                                $perpustakaan->kelurahan->kecamatan->kota->nama_kota ?? '-',
                                                $perpustakaan->kelurahan->kecamatan->nama_kecamatan ?? '-',
                                                $perpustakaan->kelurahan->nama_kelurahan ?? '-',
                                                $perpustakaan->alamat ?? '-',
                                                $perpustakaan->kontak ?? '-'
                                            ];
                                        @endphp
                                        @foreach ($data as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                        <td>
                                            <img src="{{ $perpustakaan->foto ? Storage::url($perpustakaan->foto) : asset('storage/fotos/default.png') }}" 
                                                class="img-thumbnail" width="100" height="100">
                                        </td>
                                    </tr>
                                @endif
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card untuk Tabel Monografi -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-white ">
                    <h5 class="card-title mb-0">Profil Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
    let $perpustakaanSelect = $('#perpustakaan_id');

    $perpustakaanSelect.select2({
        placeholder: "-- Pilih Perpustakaan --",
        allowClear: true,
        language: {
            loadingMore: () => "Sedang memuat data...",
            searching: () => "Mencari perpustakaan...",
        },
        ajax: {
            url: "{{ route('perpustakaans.search') }}",
            dataType: 'json',
            delay: 250,
            data: params => ({
                search: params.term,
                page: params.page || 1,
            }),
            processResults: (data, params) => ({
                results: data.results,
                pagination: { more: data.pagination.more },
            }),
            cache: true,
                    complete: function() {
                        $('#perpustakaan_id').next('.select2-container').find(
                            '.select2-selection__placeholder').text('-- Pilih Perpustakaan --');
                    }
                },
            });
        });
    </script>
@endsection
