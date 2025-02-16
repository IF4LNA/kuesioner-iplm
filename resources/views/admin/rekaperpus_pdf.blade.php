<!DOCTYPE html>
<html>
<head>
    <title>Monografi Perpustakaan</title>
</head>
<body>
    <h2>Monografi Perpustakaan</h2>
    <p>Tahun: {{ $selectedTahun }}</p>

    <table border="1">
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                    <td>{{ $pertanyaan->jawaban->first()->jawaban ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
