<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling */
        .navbar-custom {
            background-color: #2c3e50;
            padding: 10px 20px;
        }

        .navbar-custom .navbar-brand img {
            width: 45px;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: #ecf0f1;
            font-size: 15px;
            padding: 10px 15px;
            transition: all 0.3s ease-in-out;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #7f8c8d;
            /* Warna kuning saat hover */
            text-decoration: underline;
            /* Garis bawah */
            text-underline-offset: 4px;
            /* Jarak garis bawah dari teks */
        }

        .navbar-custom .navbar-nav .nav-link.active {
            color: #ffffff;
            font-weight: bold;
            text-decoration: underline;
            /* Garis bawah */
            text-underline-offset: 4px;
            /* Jarak garis bawah dari teks */
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        /* Dropdown Styling */
        .navbar-nav .dropdown-menu {
            background-color: #1c2833;
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-nav .dropdown-item {
            color: white;
            font-size: 14px;
            padding: 10px;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: #7f8c8d;
            color: black;
        }


        /* Button Styling */
        .btn-custom {
            background-color: #7f8c8d;
            color: black;
            border-radius: 20px;
            font-size: 14px;
            padding: 8px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #cacaca;
            color: black;
        }

        body {
            background-color: #f4f6f6;
            font-family: Arial, sans-serif;
        }

        .form-control {
            transition: all 0.3s ease-in-out;
            /* Animasi halus */
            border: 2px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1rem;
            background-color: #f9fafb;
        }

        .form-control:focus {
            transform: scale(1.02);
            /* Membesar 2% saat difokus */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            /* Shadow untuk efek kedalaman */
            border-color: #7f8c8d;
            /* Warna border saat difokus */
            background-color: #ffffff;
            /* Warna background saat difokus */
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
            background-color: #d5d5d5;
            border-radius: 10px;
            padding: 35px;
            margin-bottom: 35px;
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
        .question-right {
            flex: 1;
            padding-left: 20px;
        }

        .question-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        input.form-control {
            border: 2px solid #ffffff;
            border-radius: 5px;
            padding: 10px;
        }

        input.form-control:focus {
            border-color: #ebe4e4;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        button.btn-primary {
            padding: 10px 20px;
            border: none;
            transition: all 0.3s ease-in-out;
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
            background-color: #4b647c;
        }

        .question-box:nth-child(odd) .question-text {
            color: #ecf0f1;
        }

        .question-box:nth-child(even) {
            background-color: #e6e6e6;
        }

        .question-box:nth-child(even) .question-text {
            color: #4a4a4a;
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
                padding: 10px 20px;
                border: none;
                transition: all 0.3s ease-in-out;
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

            button.btn-primary {
                font-size: 1rem;
                padding: 10px 20px;
                border: none;
                transition: all 0.3s ease-in-out;
                /* Menambahkan jarak bawah pada tombol */
            }

            .question-text {
                font-size: 1.2rem;
            }

            input.form-control {
                font-size: 0.9rem;
                padding: 8px;
            }

            /* Menambahkan efek hover pada dropdown */
            .form-select option:hover {
                background-color: #f0f0f0;
                /* Ubah warna latar belakang saat hover */
                color: #333;
                /* Ubah warna teks saat hover */
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pustakawan.dashboard') }}">
                <img src="{{ asset('images/disarpus.png') }}" alt="logo Disarpus">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pustakawan.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('monografi.index') }}">
                            <i class="fas fa-book"></i> Monografi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-custom nav-link px-3" href="{{ route('form.data') }}">
                            <i class="fas fa-edit"></i> Isi Kuesioner
                        </a>
                    </li>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('monografi.index') }}"><i
                                        class="fas fa-user"></i> Profil Saya</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('home') }}">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a></li>
                        </ul>
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
                        <select name="tahun" class="form-select selectpicker" id="tahunSelect" required
                            data-live-search="true">
                            <option value="" disabled selected>Pilih Tahun</option>
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
                            <div class="question-right">
                                <h5 class="question-text">{{ $loop->iteration }}. {{ $pertanyaan->teks_pertanyaan }}
                                </h5>
                                <input type="text" name="jawaban[{{ $pertanyaan->id_pertanyaan }}]"
                                    class="form-control" placeholder="Masukkan jawaban"
                                    value="{{ $jawaban[$pertanyaan->id_pertanyaan] ?? '' }}"
                                    {{ !$editable ? 'disabled' : '' }}>
                                <!-- Tambahkan disabled jika tidak bisa diedit -->
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($editable)
                    <button type="submit" class="btn btn-primary mt-3 mb-3 w-100">Submit Jawaban</button>
                @endif
            </form>

            @if (!$editable)
                <p class="text-warning mt-3">Hanya tahun {{ now()->year }} yang dapat diisi atau diubah.</p>
            @endif

            </form>
        @elseif (isset($tahun))
            <p class="text-danger">Tidak ada pertanyaan untuk tahun {{ $tahun }}.</p>
        @endif

        <script>
            $(document).ready(function() {
                $('.selectpicker').selectpicker();
            });
        </script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
