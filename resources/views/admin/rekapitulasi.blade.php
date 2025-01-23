@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Rekapitulasi Laporan</h2>
        <table class="table table-bordered" style="width: 120%">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Uplm</th>
                    <th colspan="3" class="text-center">Perpustakaan Umum</th>
                    <th colspan="7" class="text-center">Perpustakaan Sekolah</th>
                    <th colspan="3" class="text-center">Perguruan Tinggi</th>
                    <th colspan="2" class="text-center">Khusus</th>
                </tr>
                <tr>
                    <th>Uplm</th>
                    <th>Pertanyaan</th>
                    <!-- Menggunakan data subjenis untuk menggantikan header kolom -->
                    @foreach ($subjenisList as $subjenis)
                        <th>{{ $subjenis }}</th>
                    @endforeach
                </tr>                
            </thead>
            <tbody>
                @foreach ($pertanyaanByKategori as $kategori => $pertanyaanList)
                    <!-- Menampilkan kategori hanya sekali -->
                    <tr>
                        <td rowspan="{{ $pertanyaanList->count() }}">{{ $kategori }}</td> <!-- Menampilkan kategori dan membuatnya rowspan sesuai jumlah pertanyaan -->
                        <td>{{ $pertanyaanList->first()->teks_pertanyaan }}</td> <!-- Pertanyaan pertama dari kategori ini -->
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <!-- Menampilkan pertanyaan selanjutnya dalam kategori yang sama -->
                    @foreach ($pertanyaanList->skip(1) as $item) <!-- Skip pertama untuk kategori pertama -->
                        <tr>
                            <td>{{ $item->teks_pertanyaan }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>                        
        </table>
    </div>
@endsection
