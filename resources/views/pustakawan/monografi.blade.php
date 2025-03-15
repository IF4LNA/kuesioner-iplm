<!DOCTYPE html>
<html lang="id">

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
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .navbar-custom .navbar-nav .nav-link.active {
            color: #ffffff;
            font-weight: bold;
            text-decoration: underline;
            text-underline-offset: 4px;
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

        /* Card Styling */
        .card-custom {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-custom .card-header {
            background-color: #2E3B55;
            color: white;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }

        .card-custom .card-body {
            background-color: #F8F9FA;
            border-radius: 0 0 10px 10px;
        }

        .card-custom img {
            border: 3px solid #c7c7c7;
            border-radius: 5px;
            width: 120px;
            height: auto;
        }

        .img-thumbnail {
            max-width: 150px;
            height: auto;
        }

        /* Responsive Table */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>

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
                        <a class="nav-link {{ request()->is('monografi*') ? 'active' : '' }}"
                            href="{{ route('monografi.index') }}">
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
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil Saya</a></li>
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

    <div class="container mt-4">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @else
            <!-- Card untuk Judul dan Dropdown Tahun -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-body">
                    <h2>Data Monografi Perpustakaan</h2>
                    <form method="GET" action="{{ route('monografi.index') }}">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                                @foreach ($tahunList as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <a href="{{ route('pustakawan.monografi.export.pdf', ['tahun' => $tahunTerpilih]) }}"
                        class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            <!-- Card untuk Data Perpustakaan -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-dark text-white">
                    Informasi Perpustakaan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Perpustakaan</th>
                                <td>{{ $perpustakaan->nama_perpustakaan }}</td>
                            </tr>
                            <tr>
                                <th>NPP</th>
                                <td>{{ $perpustakaan->npp }}</td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>{{ $perpustakaan->jenis->jenis }} - {{ $perpustakaan->jenis->subjenis }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $perpustakaan->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan</th>
                                <td>{{ $perpustakaan->kelurahan->nama_kelurahan }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td>{{ $perpustakaan->kelurahan->kecamatan->nama_kecamatan }}</td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td>{{ $perpustakaan->kelurahan->kecamatan->kota->nama_kota }}</td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td>{{ $perpustakaan->kontak }}</td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td><img src="{{ asset('storage/' . $perpustakaan->foto) }}" class="img-thumbnail img-fluid"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card untuk Pertanyaan & Jawaban -->
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-dark text-white">
                    Jawaban Monografi Tahun {{ $tahunTerpilih }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            @foreach ($pertanyaans as $pertanyaan)
                                <tr>
                                    <th>{{ $pertanyaan->teks_pertanyaan }}</th>
                                    <td>{{ $jawabans[$pertanyaan->id_pertanyaan] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>