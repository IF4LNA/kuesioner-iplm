<!DOCTYPE html>
<html>

<head>
    <title>Monografi Perpustakaan</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        .kop-surat {
            text-align: center;
            position: relative;
            padding-top: 10px;
        }

        .kop-surat img {
            position: absolute;
            left: 10px;
            top: 0;
            width: 80px;
            height: 80px;
        }

        .kop-text {
            display: inline-block;
        }

        .kop-text h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .kop-text p {
            font-size: 12px;
            margin: 0;
        }

        .garis {
            border-bottom: 2px solid black;
            margin-top: 25px;
            width: 100%;
            display: block;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .table td {
            padding: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .info-title {
            font-weight: bold;
            width: 20%;
        }
        
        .library-photo {
            width: 400px;
            height: auto;
            margin-top: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('images/disarpus.png') }}" alt="Logo">
        <div class="kop-text">
            <h2>DINAS ARSIP DAN PERPUSTAKAAN KOTA BANDUNG</h2>
            <p>Alamat: Jl. Seram No.2, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115</p>
            <p>Telepon: (022) 4231921</p>
        </div>
    </div>
    <div class="garis"></div>

    <div class="header">
        <h2>Monografi Perpustakaan</h2>
        <p>Tahun: {{ $selectedTahun }}</p>
    </div>

    <!-- Informasi Perpustakaan -->
    <table class="info-table">
        <tr>
            <td class="info-title">Nama Perpustakaan:</td>
            <td>{{ $perpustakaan->nama_perpustakaan }}</td>
        </tr>
        <tr>
            <td class="info-title">NPP:</td>
            <td>{{ $perpustakaan->npp }}</td>
        </tr>
        <tr>
            <td class="info-title">Jenis & Subjenis:</td>
            <td>{{ $perpustakaan->jenis->jenis ?? '-' }} - {{ $perpustakaan->jenis->subjenis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-title">Alamat:</td>
            <td>
                {{ $perpustakaan->alamat ?? '-' }},
                {{ $perpustakaan->kelurahan->nama_kelurahan ?? '-' }},
                {{ $perpustakaan->kelurahan->kecamatan->nama_kecamatan ?? '-' }},
                {{ $perpustakaan->kelurahan->kecamatan->kota->nama_kota ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="info-title">Kontak:</td>
            <td>{{ $perpustakaan->kontak ?? '-' }}</td>
        </tr>
        @if ($perpustakaan->foto)
            <tr>
                <td class="info-title">Foto Perpustakaan:</td>
                <td>
                    <img src="{{ public_path('storage/' . $perpustakaan->foto) }}" 
                         alt="Foto Perpustakaan" 
                         class="library-photo">
                </td>
            </tr>
        @endif
    </table>

    <!-- Data Monografi -->
    <h3>Data Monografi</h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monografi as $index => $pertanyaan)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                    <td>{{ $pertanyaan->jawaban->first()->jawaban ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>