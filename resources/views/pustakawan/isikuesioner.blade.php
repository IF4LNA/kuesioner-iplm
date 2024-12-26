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

        body {
    background-color: #f4f4f4; /* Warna latar halaman */
    font-family: Arial, sans-serif;
}

.question-container {
    padding: 20px;
    background-color: #545454; /* Warna background kontainer */
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.question-box {
    display: flex;
    align-items: center;
    background-color: #ffffff; /* Warna background kotak */
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.question-left {
    flex: 0 0 100px; /* Menentukan lebar kolom gambar */
    display: flex;
    justify-content: center;
    align-items: center;
}

.question-icon {
    width: 80px; /* Ukuran gambar */
    height: 80px;
    object-fit: cover;
    border-radius: 50%; /* Membuat gambar berbentuk lingkaran */
    border: 2px solid #ddd;
}

.question-right {
    flex: 1;
    padding-left: 20px;
}

.question-text {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

input.form-control {
    border: 2px solid #dcdcdc;
    border-radius: 5px;
    padding: 10px;
}

input.form-control:focus {
    border-color: #4caf50; /* Warna fokus input */
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}

button.btn-success {
    background-color: #4caf50;
    border-color: #4caf50;
    font-size: 1rem;
    border-radius: 5px;
    padding: 10px 20px;
}

button.btn-success:hover {
    background-color: #45a049;
    border-color: #45a049;
}

/* Warna teks berdasarkan warna latar belakang kotak */
/* Warna dan teks untuk pertanyaan dengan latar belakang cream */
.question-box:nth-child(odd) {
    background-color: #E6D9C6; /* Cream */
}

.question-box:nth-child(odd) .question-text {
    color: #555555; /* Teks untuk background cream */
}

/* Warna dan teks untuk pertanyaan dengan latar belakang biru */
.question-box:nth-child(even) {
    background-color: #174166; /* Biru */
}

.question-box:nth-child(even) .question-text {
    color: #E4D9CD; /* Teks untuk background biru */
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

    <div class="question-container">
        @foreach ($pertanyaans as $pertanyaan)
        <div class="question-box">
            <div class="question-left">
                <img src="https://via.placeholder.com/100" alt="Icon Pertanyaan" class="question-icon">
            </div>
            <div class="question-right">
                <h5 class="question-text">{{ $loop->iteration }}. {{ $pertanyaan->teks_pertanyaan }}</h5>
                <input type="text" name="jawaban[{{ $pertanyaan->id_pertanyaan }}]" class="form-control" placeholder="Masukkan jawaban" required>
            </div>
        </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-success mt-3">Submit Jawaban</button>
</form>
@elseif (isset($tahun))
<p class="text-danger">Tidak ada pertanyaan untuk tahun {{ $tahun }}.</p>
@endif

        

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
