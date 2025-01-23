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
                    <tr>
                        <td rowspan="{{ $pertanyaanList->count() }}">{{ $kategori }}</td>
                        @foreach ($pertanyaanList as $pertanyaan)
                            <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                            @foreach ($subjenisList as $subjenis)
                                <td class="text-center">
                                    {{ $rekapArray[$subjenis][$pertanyaan->id_pertanyaan] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>         
        </table>
    </div>
@endsection
