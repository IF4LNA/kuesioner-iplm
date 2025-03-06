@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="p-1">UPLM 3 Ketercukupan Tenaga Perpustakaan</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card untuk Filter dan Export -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Filter dan Export Data</h5>
                <button id="toggleFilterButton" class="btn btn-light">
                    <i class="fas fa-filter"></i> Tampilkan Filter
                </button>
            </div>

            <div class="card-body bg-light" id="filterContainer" style="display: none;">
                <form action="{{ route('uplm', $id) }}" method="GET">
                    <div class="row mb-3">
                        <!-- Filter Jenis -->
                        <div class="col-md-4">
                            <select name="jenis" class="form-select shadow-sm" aria-label="Pilih Jenis">
                                <option value="">Pilih Jenis</option>
                                @foreach ($jenisList as $jenis)
                                    <option value="{{ $jenis }}" {{ request()->jenis == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
            
                        <!-- Filter Subjenis -->
                        <div class="col-md-4">
                            <select name="subjenis" class="form-select shadow-sm" aria-label="Pilih Subjenis">
                                <option value="">Pilih Subjenis</option>
                                @foreach ($subjenisList as $subjenis)
                                    <option value="{{ $subjenis }}" {{ request()->subjenis == $subjenis ? 'selected' : '' }}>
                                        {{ $subjenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
            
                        <!-- Filter Tahun -->
                        <div class="col-md-4">
                            <select name="tahun" class="form-select shadow-sm" aria-label="Pilih Tahun">
                                <option value="">Pilih Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request()->tahun == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            
                    <!-- Tombol Filter dan Reset -->
                    <div class="row">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('uplm', $id) }}" class="btn btn-outline-secondary shadow-sm">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tombol Export -->
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('uplm.exportExcel', ['id' => 3, 'jenis' => request()->jenis, 'subjenis' => request()->subjenis, 'tahun' => request()->tahun]) }}"
                        class="btn btn-success shadow-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('uplm.exportPdf', ['id' => 3, 'kategori' => 3, 'jenis' => request()->jenis, 'subjenis' => request()->subjenis, 'tahun' => request()->tahun]) }}"
                        class="btn btn-danger shadow-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Card untuk Tabel Data -->
        <div class="card shadow-lg border-0">
            <div class="card-header">
                <h5 class="mb-0">Data Perpustakaan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width: 150%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 5%;">
                                    <a href="{{ route('uplm', ['id' => $id, 'sortField' => 'created_at', 'sortOrder' => request('sortOrder') === 'asc' ? 'desc' : 'asc']) }}"
                                        style="color: black; text-decoration: none; display: flex; align-items: center;">
                                        Tahun
                                        <span style="margin-left: 5px;">
                                            @if (request('sortField') === 'created_at')
                                                <i
                                                    class="fas fa-sort-{{ request('sortOrder') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('uplm', ['id' => $id, 'sortField' => 'nama_perpustakaan', 'sortOrder' => request('sortOrder') === 'asc' ? 'desc' : 'asc']) }}"
                                        style="color: black; text-decoration: none; display: flex; align-items: center;">
                                        Nama Perpustakaan
                                        <span style="margin-left: 5px;">
                                            @if (request('sortField') === 'nama_perpustakaan')
                                                <i
                                                    class="fas fa-sort-{{ request('sortOrder') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </span>
                                    </a>
                                </th>
                                <th>NPP</th>
                                <th>Jenis Perpustakaan</th>
                                <th>Sub Jenis Perpustakaan</th>
                                <th>Alamat</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                @foreach ($pertanyaan as $pertanyaanItem)
                                    <th>{{ $pertanyaanItem->teks_pertanyaan }}</th>
                                @endforeach
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->created_at->format('Y') }}</td>
                                    <td>{{ $item->nama_perpustakaan ?? '-' }}</td>
                                    <td>{{ $item->npp ?? '-' }}</td>
                                    <td>{{ $item->jenis->jenis ?? '-' }}</td>
                                    <td>{{ $item->jenis->subjenis ?? '-' }}</td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    @foreach ($pertanyaan as $pertanyaanItem)
                                        <td>
                                            @php
                                                $jawaban = $item->jawaban->firstWhere(
                                                    'id_pertanyaan',
                                                    $pertanyaanItem->id_pertanyaan,
                                                );
                                            @endphp
                                            {{ $jawaban ? $jawaban->jawaban : '-' }}
                                            @if ($jawaban)
                                                <a href="{{ route('uplm.jawaban.edit', ['id' => $id, 'jawaban' => $jawaban->id_jawaban]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('uplm.jawaban.delete', ['id' => $id, 'jawaban' => $jawaban->id_jawaban]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleFilterButton').addEventListener('click', function() {
            const filterContainer = document.getElementById('filterContainer');
            const isHidden = filterContainer.style.display === 'none';
            filterContainer.style.display = isHidden ? 'block' : 'none';
            this.innerHTML = isHidden ? '<i class="fas fa-times"></i> Sembunyikan Filter' :
                '<i class="fas fa-filter"></i> Tampilkan Filter';
        });
    </script>
@endsection
