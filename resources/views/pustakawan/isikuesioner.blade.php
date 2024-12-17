<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .logout-btn {
            border: none;
            background: none;
            font-size: 1.5rem;
            color: #dc3545;
        }

        .logout-btn:hover {
            color: #bb2d3b;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Kuesioner</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Selamat datang, {{ Auth::user()->username }}!</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Konten halaman -->
    <div class="container mt-5">
        <h3>Pilih Tahun untuk Menampilkan Pertanyaan</h3>

        <!-- Form Dropdown untuk Tahun -->
        <form method="GET" action="{{ route('pustakawan.isikuesioner') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <select name="tahun" class="form-select" required>
                        <option value="" disabled selected>Pilih Tahun</option>
                        @foreach ($tahunList as $tahunOption)
                            <option value="{{ $tahunOption }}" {{ isset($tahun) && $tahun == $tahunOption ? 'selected' : '' }}>
                                {{ $tahunOption }}  
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Tampilkan Pertanyaan</button>
                </div>
            </div>
        </form>

        <!-- Menampilkan Pertanyaan -->
@if ($pertanyaans->count() > 0)
<form action="{{ route('kuesioner.submit') }}" method="POST">
    @csrf
    <input type="hidden" name="tahun" value="{{ $tahun }}">
    <ul class="list-group">
        @foreach ($pertanyaans as $pertanyaan)
            <li class="list-group-item">
                <strong>{{ $loop->iteration }}. {{ $pertanyaan->teks_pertanyaan }}</strong>
                <div class="mt-2">
                    <input type="text" name="jawaban[{{ $pertanyaan->id_pertanyaan }}]" class="form-control" placeholder="Masukkan jawaban" required>
                </div>
            </li>
        @endforeach
    </ul>
    <button type="submit" class="btn btn-success mt-3">Submit Jawaban</button>
</form>
@elseif (isset($tahun))
<p class="text-danger">Tidak ada pertanyaan untuk tahun {{ $tahun }}.</p>
@endif

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
