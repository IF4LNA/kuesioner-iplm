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
        /* Tampilan navbar */
        .navbar {
            background-color: #1F3C63;
            position: sticky;
            top: 0;
            z-index: 1000;
            /* Pastikan navbar tetap di atas konten lainnya */
            width: 100%;
            /* Agar navbar memenuhi lebar layar */
        }

        .navbar-brand {
            color: #fff !important;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-link {
            color: #f8f9fa !important;
        }

        .logout-btn {
            font-size: 1.2rem;
            color: #f8f9fa;
            background: none;
            border: none;
        }

        .logout-btn:hover {
            color: #ffc107;
        }

        /* Tampilan utama */
        body {
            background-color: #f9fafb;
            font-family: 'Arial', sans-serif;
        }

        h3 {
            font-weight: bold;
            color: #333;
        }

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
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .question-container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .question-box {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .question-left {
            flex: 0 0 auto;
            width: 80px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .question-icon {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
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
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        button.btn-primary {
            margin-bottom: 20px;
            /* Menambahkan jarak bawah pada tombol */
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

        .question-box:nth-child(odd) {
            background-color: #E6D9C6;
        }

        .question-box:nth-child(odd) .question-text {
            color: #555555;
        }

        .question-box:nth-child(even) {
            background-color: #174166;
        }

        .question-box:nth-child(even) .question-text {
            color: #E4D9CD;
        }

        @media (max-width: 768px) {
            .question-box {
                flex-direction: column;
                align-items: flex-start;
            }

            .question-left {
                width: 100%;
                margin-bottom: 15px;
                text-align: center;
            }

            .question-right {
                padding-left: 0;
            }

            button.btn-primary {
                margin-bottom: 20px;
                /* Menambahkan jarak bawah pada tombol */
            }

            button.btn-success {
                width: 100%;
            }

            .btn-primary {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            h3 {
                font-size: 1.5rem;
            }

            .question-text {
                font-size: 1rem;
            }

            input.form-control {
                font-size: 0.9rem;
                padding: 8px;
            }

            /* Menambahkan efek hover pada dropdown */
.form-select option:hover {
    background-color: #f0f0f0; /* Ubah warna latar belakang saat hover */
    color: #333; /* Ubah warna teks saat hover */
}

        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kuesioner</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Selamat datang, {{ Auth::user()->username }}!</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="logout-btn" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten halaman -->
    <div class="container mt-5">
        {{-- <h3>Pilih Tahun untuk Menampilkan Pertanyaan</h3> --}}

        <!-- Form Dropdown untuk Tahun -->
        <form method="GET" action="{{ route('pustakawan.isikuesioner') }}" class="mb-4 p-4 shadow-sm rounded"
            style="background-color: #ffffff;">
            <h5 class="mb-3">Pilih Tahun untuk Menampilkan Pertanyaan</h5>
            <div class="row align-items-center">
                <!-- Dropdown Tahun -->
                <div class="col-md-8 mb-3 mb-md-0">
                    <div class="form-floating">
                        <select name="tahun" class="form-select selectpicker" id="tahunSelect" required data-live-search="true">
                            <option value="" disabled sele  cted>Pilih Tahun</option>
                            @foreach ($tahunList as $tahunOption)
                                <option
                                    value="{{ $tahunOption }}"{{ isset($tahun) && $tahun == $tahunOption ? 'selected' : '' }}>
                                    {{ $tahunOption }}
                                </option>
                            @endforeach
                        </select>
                        <label for="tahunSelect" class="text-muted">Tahun</label>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100 px-4">
                        <i class="fas fa-search me-2"></i> Tampilkan Pertanyaan
                    </button>
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
                                <h5 class="question-text">{{ $loop->iteration }}. {{ $pertanyaan->teks_pertanyaan }}
                                </h5>
                                <input type="text" name="jawaban[{{ $pertanyaan->id_pertanyaan }}]"
                                    class="form-control" placeholder="Masukkan jawaban" required>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button inside Form -->
                <button type="submit" class="btn btn-primary mt-3 w-100">Submit Jawaban</button>
            </form>
        @elseif (isset($tahun))
            <p class="text-danger">Tidak ada pertanyaan untuk tahun {{ $tahun }}.</p>
        @endif

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.selectpicker').selectpicker();
            });
        </script>
        
</body>

</html>
