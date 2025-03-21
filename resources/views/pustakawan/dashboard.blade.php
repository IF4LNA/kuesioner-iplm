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
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .card-custom .card-header {
            background-color: #2E3B55;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .card-custom .card-body {
            background-color: #f8f9fa;
            border-radius: 0 0 10px 10px;
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
                        <a class="nav-link {{ request()->is('pustakawan/dashboard') ? 'active' : '' }}"
                            href="{{ route('pustakawan.dashboard') }}">
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
                            <li><a class="dropdown-item" href="{{ route('monografi.index') }}"><i
                                        class="fas fa-book"></i> Monografi</a></li>
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg rounded-3 mb-4 border-0" style="background-color: #f8f9fa">
                    <div class="card-body text-center">
                        <!-- Welcome Box -->
                        <i class="fas fa-user-tie icon fa-2x mb-2" style="color: #2E3B55"></i>
                        <h5 style="color: #2E3B55">Selamat datang, {{ Auth::user()->username }}!</h5>

                        <!-- Garis Pemisah -->
                        <hr class="my-4">

                        <!-- Quick Links -->
                        <div class="row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <a href="{{ route('monografi.exportPDF', ['tahun' => now()->year]) }}"
                                    class="btn btn-danger w-100">
                                    <i class="fas fa-file-pdf"></i> Ekspor PDF Monografi
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('form.data') }}" class="btn w-100 text-white"
                                    style="background-color: #2E3B55">
                                    <i class="fas fa-edit"></i> Isi Kuesioner
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cepat -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-check-circle"></i> Pertanyaan Dijawab</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-center">{{ $pertanyaanDijawab }}</h3>
                                <p class="text-center text-muted">Total pertanyaan yang sudah dijawab.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-times-circle"></i> Pertanyaan Belum Dijawab
                                </h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-center">{{ $pertanyaanBelumDijawab }}</h3>
                                <p class="text-center text-muted">Total pertanyaan yang belum dijawab.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-list-alt"></i> Total Pertanyaan</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-center">{{ $totalPertanyaan }}</h3>
                                <p class="text-center text-muted">Total pertanyaan tersedia.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @forelse($aktivitasTerbaru as $tahun => $jawaban)
                                        <li class="list-group-item">
                                            Pertanyaan tahun {{ $tahun }} telah dijawab pada
                                            {{ $jawaban->created_at->format('d F Y') }}.
                                        </li>
                                    @empty
                                        <li class="list-group-item">Tidak ada aktivitas terbaru.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Statistik Jawaban per
                                    Bulan</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart.js Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('barChart').getContext('2d');
                    const barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets: [{
                                label: 'Jumlah Jawaban',
                                data: @json($chartData), // Gunakan data dari controller
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>

                <!-- Bootstrap JS -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
