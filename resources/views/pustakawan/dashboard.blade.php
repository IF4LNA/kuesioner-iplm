<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for Navbar -->
    <style>

        body {
            background-color: #F6EEE1;
        }
        /* Navbar custom styles */
        .navbar-custom {
            background-color: #003366; /* Warna biru tua */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: #ffffff; /* Warna teks putih */
        }

        /* Warna teks navbar saat hover menjadi kuning */
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #FFD700; /* Warna kuning saat hover */
        }

        /* Mengubah warna ikon hamburger menjadi putih */
        .navbar-toggler-icon {
            filter: invert(1); /* Membalikkan warna ikon menjadi putih */
        }

        /* Mengubah posisi tombol navbar-toggler */
        .navbar-toggler {
            margin-left: auto; /* Pindahkan tombol ke kanan */
        }

        /* Geser navlist sedikit ke kanan */
        .navbar-nav {
            margin-left: 45px; /* Geser ke kanan dengan margin */
        }

        /* Sesuaikan margin pada ukuran layar kecil */
        @media (max-width: 991px) {
            .navbar-nav {
                margin-left: 10px; /* Hilangkan margin pada layar lebih kecil */
            }
        }

        /* Custom style untuk dropdown */
        .navbar-nav .dropdown-menu {
            background-color: #174166; /* Warna latar belakang dropdown */
            border: none; /* Hilangkan border default */
            box-shadow: none; /* Hilangkan bayangan default */
            transition: opacity 0.3s ease-in-out; /* Animasi transisi */
        }

        .navbar-nav .dropdown-item {
            color: #ffffff; /* Warna teks item dropdown */
        }

        .navbar-nav .dropdown-item:hover {
            background-color: #002244; /* Warna latar belakang item dropdown saat hover */
            color: #ffffff; /* Warna teks tetap putih saat hover */
        }

        /* Mengubah posisi dropdown agar lebih halus saat terbuka */
        .dropdown-menu.show {
            opacity: 1;
        }

        /* Custom style untuk konten */
        .welcome-box {
            background-color: #858380; /* Warna abu-abu */
            color: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 8px; /* Membuat sudut kotak lebih melengkung */
            display: flex;
            align-items: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan untuk kesan 3D */
        }

        /* Style untuk ikon pustakawan */
        .welcome-box .icon {
            font-size: 2rem; /* Ukuran ikon */
            margin-right: 15px; /* Jarak antara ikon dan teks */
            color: #FFEE1B; /* Warna ikon biru */
        }
    </style>
</head>

<body>

    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('images/disarpus.png') }}" alt="logo Disarpus" width="70px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- Profil Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Profil
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                {{-- <li><a class="dropdown-item" href="#">Isi Profil</a></li> --}}
                                <li><a class="dropdown-item" href="{{ route('home') }}">Logout</a></li>
                            </ul>
                        </li>
                        <!-- Isi Kuesioner di samping Profil -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('form.data') }}">Isi Kuesioner</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Container -->
        <div class="container mt-5">
            <!-- Welcome Message tanpa kotak alert -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="welcome-box">
                        <i class="fas fa-user-tie icon"></i> <!-- Ikon pustakawan -->
                        <h4 class="alert-heading">Selamat datang, {{ Auth::user()->username }}!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
