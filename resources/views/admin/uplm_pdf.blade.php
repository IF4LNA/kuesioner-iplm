<!DOCTYPE html>
<html>
<head>
    <title>Export PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Paksa distribusi kolom */
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            font-size: 12px;
            word-wrap: break-word;
        }
        /* Atur lebar khusus untuk kolom Nomor */
        th:first-child, td:first-child {
            width: 5%; /* Sesuaikan dengan kebutuhan */
            text-align: center;
        }
    </style>
       
</head>
<body>
    <h2>Data UPLM 1</h2>
    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_perpustakaan'] }}</td>
                    <td>{{ $item['npp'] }}</td>
                    <td>{{ $item['jenis_perpustakaan'] }}</td>
                    <td>{{ $item['subjenis'] }}</td>
                    <td>{{ $item['alamat'] }}</td>
                    <td>{{ $item['kontak'] }}</td>
                    <td>{{ $item['kelurahan'] }}</td>
                    <td>{{ $item['kecamatan'] }}</td>
                    <td>{{ $item['kota'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>