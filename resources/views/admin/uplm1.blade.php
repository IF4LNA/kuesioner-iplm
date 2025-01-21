@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="p-1">UPLM 2 Ketercukupan Koleksi Perpustakaan</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Toggle -->
    <div class="d-flex justify-content-end mb-3">
        <button id="toggleFilterButton" class="btn btn-secondary">
            Tampilkan Filter
        </button>
    </div>

    <!-- Filter Container -->
    <div id="filterContainer" style="display: none;">
        <!-- Filter Jenis dan Subjenis -->
        <form action="{{ route('uplm', $id) }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select name="jenis" class="form-select" aria-label="Pilih Jenis">
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenisList as $jenis)
                            <option value="{{ $jenis }}" {{ request()->jenis == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="subjenis" class="form-select" aria-label="Pilih Subjenis">
                        <option value="">Pilih Subjenis</option>
                        @foreach ($subjenisList as $subjenis)
                            <option value="{{ $subjenis }}" {{ request()->subjenis == $subjenis ? 'selected' : '' }}>{{ $subjenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Form Filter Tahun untuk Pertanyaan -->
        <div class="mb-4">
            <form action="{{ route('uplm', $id) }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <select name="tahun" id="tahun" class="form-select form-select-md" aria-label="Pilih Tahun">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request()->tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary btn-md ms-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive mt-3">
        <table id="dataTable" class="table table-striped table-bordered" style="width: 150%">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-sortable="true">Tahun <i class="fas fa-sort"></i></th>
                    <th data-sortable="true">Nama Perpustakaan <i class="fas fa-sort"></i></th>
                    <th>NPP</th>
                    <th data-sortable="true">Jenis Perpustakaan <i class="fas fa-sort"></i></th>
                    <th>Sub Jenis Perpustakaan</th>
                    <th data-sortable="true">Alamat <i class="fas fa-sort"></i></th>
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
                                    $jawaban = $item->jawaban->firstWhere('id_pertanyaan', $pertanyaanItem->id_pertanyaan);
                                @endphp
                                {{ $jawaban ? $jawaban->jawaban : '-' }}
                                @if ($jawaban)
                                    <a href="{{ route('uplm.jawaban.edit', ['id' => $id, 'jawaban' => $jawaban->id_jawaban]) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('uplm.jawaban.delete', ['id' => $id, 'jawaban' => $jawaban->id_jawaban]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?')">
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

<script>
    document.getElementById('toggleFilterButton').addEventListener('click', function() {
        const filterContainer = document.getElementById('filterContainer');
        const isHidden = filterContainer.style.display === 'none';
        filterContainer.style.display = isHidden ? 'block' : 'none';
        this.textContent = isHidden ? 'Sembunyikan Filter' : 'Tampilkan Filter';
    });

    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('dataTable');
        const headers = table.querySelectorAll('th[data-sortable="true"]');
        const tbody = table.querySelector('tbody');

        headers.forEach((header, index) => {
            const icon = header.querySelector('i');
            header.style.cursor = 'pointer';

            header.addEventListener('click', () => {
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const isAscending = header.classList.contains('asc');
                const direction = isAscending ? -1 : 1;

                // Remove existing sort classes
                headers.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    h.querySelector('i').style.visibility = 'hidden'; // Sembunyikan ikon pada kolom lainnya
                });

                // Toggle sort direction
                header.classList.toggle('asc', !isAscending);
                header.classList.toggle('desc', isAscending);
                icon.style.visibility = 'visible'; // Menampilkan ikon

                // Sort rows based on the column clicked
                rows.sort((rowA, rowB) => {
                    let cellA = rowA.children[index].textContent.trim().toLowerCase();
                    let cellB = rowB.children[index].textContent.trim().toLowerCase();

                    // Sorting berdasarkan kolom Tahun (numerik)
                    if (index === 1) { // Kolom Tahun
                        cellA = parseInt(cellA);
                        cellB = parseInt(cellB);
                        return (cellA - cellB) * direction;
                    }

                    // Sorting berdasarkan kolom Nama Perpustakaan (alfabetik)
                    if (index === 2) { // Kolom Nama Perpustakaan
                        return cellA.localeCompare(cellB) * direction;
                    }

                    return cellA.localeCompare(cellB) * direction;
                });

                // Append sorted rows to tbody
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
</script>

@endsection
