@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>UPLM 2</h3>

    <!-- Tombol untuk Export ke Excel dan PDF -->
    <div class="mb-3">
        <a href="" class="btn btn-success">Export Excel</a>
        <a href="" class="btn btn-danger">Export PDF</a>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered" style="width: 120%">
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
                                <!-- Tampilkan jawaban untuk pertanyaan ini jika ada -->
                                @php
                                    $jawaban = $item->jawaban->where('id_pertanyaan', $pertanyaanItem->id)->first();
                                @endphp
                                <!-- Tampilkan jawaban jika ada -->
                                {{ $jawaban->jawaban ?? '-' }} 
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
            </tbody>
        </table>
    </div>
</div>
@endsection
