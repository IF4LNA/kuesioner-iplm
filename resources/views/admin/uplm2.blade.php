@extends('layouts.app')

@section('content')
    <style>
        /* Atur margin dan padding untuk container */
        .entries-go-to-container {
            margin-top: 1rem;
            /* Jarak dari atas */
            margin-bottom: 1rem;
            /* Jarak dari bawah */
            margin-left: 1rem;
            /* Jarak dari kiri */
            margin-right: 1rem;
            /* Jarak dari kanan */
            padding: 0.5rem;
            /* Padding dalam container */
            background-color: #f8f9fa;
            /* Warna latar belakang */
            border-radius: 0.25rem;
            /* Sudut melengkung */
            border: 1px solid #dee2e6;
            /* Garis tepi */
        }

        /* Atur jarak antara elemen */
        .entries-go-to-container .form-control-sm,
        .entries-go-to-container .btn-sm {
            margin: 0 0.25rem;
            /* Jarak antara elemen */
        }

        /* Atur lebar input "Go to Page" */
        .entries-go-to-container input[type="number"] {
            width: 80px;
            /* Lebar input */
        }
    </style>
    </style>
    <div class="container mt-4">
        <h3 class="p-1">UPLM 2 Ketercukupan Koleksi Perpustakaan</h3>

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
                                    <option value="{{ $subjenis }}"
                                        {{ request()->subjenis == $subjenis ? 'selected' : '' }}>
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
                    <a href="{{ route('uplm.exportExcel', ['id' => 2, 'jenis' => request()->jenis, 'subjenis' => request()->subjenis, 'tahun' => request()->tahun]) }}"
                        class="btn btn-success shadow-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('uplm.exportPdf', ['id' => 2, 'kategori' => 2, 'jenis' => request()->jenis, 'subjenis' => request()->subjenis, 'tahun' => request()->tahun]) }}"
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
            <!-- Container untuk Show Entries dan Go to Page -->
            <!-- Container untuk Show Entries dan Go to Page -->
            <div class="d-flex justify-content-between align-items-center entries-go-to-container">
                <!-- Show Entries -->
                <form action="{{ route('uplm', $id) }}" method="GET" class="d-flex align-items-center gap-2">
                    <label for="perPage" class="mb-0">Show</label>
                    <select name="perPage" id="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" {{ request()->perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request()->perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request()->perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request()->perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <label for="perPage" class="mb-0">entries</label>

                    <!-- Input tersembunyi untuk parameter lainnya -->
                    {{-- <input type="hidden" name="search" value="{{ request()->search }}">
        <input type="hidden" name="jenis" value="{{ request()->jenis }}">
        <input type="hidden" name="subjenis" value="{{ request()->subjenis }}">
        <input type="hidden" name="tahun" value="{{ request()->tahun }}">
        <input type="hidden" name="sortField" value="{{ request()->sortField }}">
        <input type="hidden" name="sortOrder" value="{{ request()->sortOrder }}"> --}}
                </form>

                <!-- Go to Page -->
                <form action="{{ route('uplm', $id) }}" method="GET" class="d-flex align-items-center gap-2">
                    <label for="goToPage" class="mb-0">Go to page</label>
                    <input type="number" name="page" id="goToPage" class="form-control form-control-sm"
                        style="width: 80px;" min="1" max="{{ $data->lastPage() }}"
                        value="{{ request()->page ?? 1 }}">
                    <button type="submit" class="btn btn-primary btn-sm">Go</button>

                    <!-- Input tersembunyi untuk parameter lainnya -->
                    {{-- <input type="hidden" name="search" value="{{ request()->search }}">
        <input type="hidden" name="jenis" value="{{ request()->jenis }}">
        <input type="hidden" name="subjenis" value="{{ request()->subjenis }}">
        <input type="hidden" name="tahun" value="{{ request()->tahun }}">
        <input type="hidden" name="sortField" value="{{ request()->sortField }}">
        <input type="hidden" name="sortOrder" value="{{ request()->sortOrder }}">
        <input type="hidden" name="perPage" value="{{ request()->perPage }}"> --}}
                </form>
            </div>

            <div class="card-body">
                <form action="{{ route('uplm', $id) }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama perpustakaan, NPP, atau alamat..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <!-- Tombol Reset -->
                        <a href="{{ route('uplm', $id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </form>
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
                                    <a href="{{ route('uplm', ['id' => $id, 'sortField' => 'nama_perpustakaan', 'sortOrder' => request('sortOrder') === 'asc' ? 'desc' : 'asc', 'search' => request()->search, 'jenis' => request()->jenis, 'subjenis' => request()->subjenis, 'tahun' => request()->tahun]) }}"
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
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} dari {{ $data->total() }}
                            data
                        </div>
                        <div>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk validasi Go to Page -->
    <script>
        document.getElementById('goToPage').addEventListener('change', function() {
            const maxPage = {{ $data->lastPage() }};
            const inputValue = parseInt(this.value);

            if (inputValue < 1) {
                this.value = 1;
            } else if (inputValue > maxPage) {
                this.value = maxPage;
            }
        });
    </script>

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
