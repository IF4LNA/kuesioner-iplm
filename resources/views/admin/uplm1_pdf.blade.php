<!DOCTYPE html>
<html>

<head>
    <title>UPLM 1 Report</title>
    <style>
        body {
            font-size: 10px;
            /* Ukuran teks utama */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px;
            /* Perkecil padding agar lebih rapat */
            text-align: left;
            font-size: 9px;
            /* Ukuran teks di tabel */
        }

        h2 {
            font-size: 12px;
            /* Ukuran judul */
        }
    </style>
</head>

<body>
    <h2>UPLM 1 Pemerataan Layanan Perpustakaan</h2>
    <table>
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tahun }}</td>
                    <td>{{ $item->nama_perpustakaan ?? '-' }}</td>
                    <td>{{ $item->npp ?? '-' }}</td>
                    <td>{{ $item->jenis->jenis ?? '-' }}</td>
                    <td>{{ $item->jenis->subjenis ?? '-' }}</td>
                    <td>{{ $item->nama_pengelola ?? '-' }}</td>
                    <td>{{ $item->kontak ?? '-' }}</td>
                    <td>{{ $item->alamat ?? '-' }}</td>
                    <td>{{ $item->user->email }}</td> 
                    <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                    <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                    @foreach ($pertanyaan as $pertanyaanItem)
                        @php
                            $jawaban = $item->jawaban->firstWhere('id_pertanyaan', $pertanyaanItem->id_pertanyaan);
                        @endphp
                        <td>{{ $jawaban ? $jawaban->jawaban : '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
