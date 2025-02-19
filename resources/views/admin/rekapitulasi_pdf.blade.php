<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi UPLM {{ $tahunTerpilih }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; vertical-align: middle; }
        th { background-color: #f2f2f2; }
        td { word-wrap: break-word; word-break: break-word; }
        h2 { text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Rekapitulasi UPLM Kota Bandung Tahun {{ $tahunTerpilih }}</h2>
    <table>
        <thead>
            <tr>
                <th rowspan="2">UPLM</th>
                <th rowspan="2">Pertanyaan</th>
                @foreach ($jenisList as $jenis => $subjenisCollection)
                    <th colspan="{{ $subjenisCollection->count() }}">{{ $jenis }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($jenisList as $subjenisCollection)
                    @foreach ($subjenisCollection as $subjenis)
                        <th>{{ $subjenis->subjenis }}</th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            <!-- Baris untuk "Jumlah Kelembagaan Perpustakaan" -->
            <tr>
                <td rowspan="1">UPLM 1</td>
                <td style="width: 300px; text-align: left; word-wrap: break-word; white-space: normal;">
                    Jumlah Kelembagaan Perpustakaan</td>
                @foreach ($jenisList as $jenis => $subjenisCollection)
                    @foreach ($subjenisCollection as $subjenis)
                        <td>{{ $jumlahPerpustakaan[$jenis][$subjenis->subjenis] ?? 0 }}</td>
                    @endforeach
                @endforeach
            </tr>

            <!-- Looping kategori & pertanyaan -->
            @foreach ($pertanyaanByKategori as $kategori => $pertanyaanList)
                @php $rowspan = $pertanyaanList->count(); @endphp
                @foreach ($pertanyaanList as $index => $pertanyaan)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $rowspan }}">{{ $kategori }}</td>
                        @endif
                        <!-- Kolom pertanyaan dengan teks rata kiri dan wrap -->
                        <td style="width: 300px; text-align: left; word-wrap: break-word; white-space: normal;">
                            {{ $pertanyaan->teks_pertanyaan }}
                        </td>
                        <!-- Looping data rekap -->
                        @foreach ($jenisList as $jenis => $subjenisCollection)
                            @foreach ($subjenisCollection as $subjenis)
                                <td style="text-align: center; white-space: nowrap;">
                                    @php
                                        $rekap = $rekapArray[$jenis][$subjenis->subjenis][$pertanyaan->id_pertanyaan] ?? ['total_angka' => 0, 'total_responden' => 0];
                                    @endphp
                                    {{ $rekap['total_angka'] > 0 ? $rekap['total_angka'] : $rekap['total_responden'] }}
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            @endforeach

        </tbody>
    </table>
</body>
</html>
