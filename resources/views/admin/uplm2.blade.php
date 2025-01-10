@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="p-3">UPLM 2 Ketercukupan Koleksi Perpustakaan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Tombol Export -->
        <div>
            <a href="#" class="btn btn-success me-2">Export Excel</a>
            <a href="#" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered" style="width: 150%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tahun</th>
                    <th>Nama Perpustakaan</th>
                    <th>NPP</th>
                    <th>Jenis Perpustakaan</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    @foreach ($pertanyaan as $pertanyaanItem)
                        <th>{{ $pertanyaanItem->teks_pertanyaan }}</th> <!-- Kolom untuk setiap pertanyaan -->
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
                        <td>{{ $item->jenis ?? '-' }}</td>
                        <td>{{ $item->alamat ?? '-' }}</td>
                        <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                        @foreach ($pertanyaan as $pertanyaanItem)
                            <td>
                                @php
                                    // Ambil jawaban yang sesuai dengan id_pertanyaan dan id_perpustakaan saat ini
                                    $jawaban = $item->jawaban->firstWhere('id_pertanyaan', $pertanyaanItem->id_pertanyaan);
                                @endphp
                                {{ $jawaban ? $jawaban->jawaban : '-' }}
                            </td>
                        @endforeach
                        <td>
                            <!-- Tombol untuk Edit, Delete -->
                            <a href="" class="btn btn-warning btn-sm">Edit</a>
                            <form action="" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
        </table>
    </div>
</div>
@endsection
