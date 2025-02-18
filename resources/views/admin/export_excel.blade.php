<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Perpustakaan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-decoration: underline;
            margin-top: 20px;
        }

        .section-header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .info-table td {
            background-color: #f9f9f9;
            font-size: 14px;
        }

        .info-table th {
            background-color: #f4f4f4;
            font-size: 16px;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Informasi Perpustakaan -->
        <div class="section-header">Informasi Perpustakaan</div>
        <table class="info-table">
            <tr>
                <th colspan="2"><strong>Informasi Perpustakaan</strong></th>
            </tr>
            <tr>
                <td>Nama Perpustakaan</td>
                <td>{{ $perpustakaan->nama_perpustakaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>NPP (Nomor Pokok Perpustakaan)</td>
                <td>{{ $perpustakaan->npp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Perpustakaan</td>
                <td>{{ $perpustakaan->jenis->jenis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Subjenis Perpustakaan</td>
                <td>{{ $perpustakaan->jenis->subjenis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>{{ $perpustakaan->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kota</td>
                <td>{{ $perpustakaan->kelurahan->kecamatan->kota->nama_kota ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>{{ $perpustakaan->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelurahan</td>
                <td>{{ $perpustakaan->kelurahan->nama_kelurahan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kontak</td>
                <td>{{ $perpustakaan->kontak ?? '-' }}</td>
            </tr>
        </table>

        <!-- Tabel Monografi -->
        <div class="section-title">Monografi</div>
        <table>
            <thead>
                <tr>
                    <th>UPLM</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monografi as $pertanyaan)
                    <tr>
                        <td>{{ $pertanyaan->kategori ?? '-' }}</td>
                        <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                        <td>
                            @php
                                $jawaban = $pertanyaan->jawaban->first();
                            @endphp
                            {{ $jawaban ? $jawaban->jawaban : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="footer">
        <p>&copy; 2025 Perpustakaan Nasional. All rights reserved.</p>
    </div>

</body>
</html>
