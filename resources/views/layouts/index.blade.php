<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Halaman awal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 130px;
        }

        .navbar {
            border-bottom: 1px solid #ccc;
            background-color: white;
        }

        .navbar-brand img {
            height: 70px;
            width: auto;
        }

        /* Menghilangkan garis bawah default dan menambahkan efek hover dengan animasi */
        .navbar-nav .nav-link {
            color: black;
            text-decoration: none;
            position: relative;
            /* Menambahkan posisi relative untuk menempatkan garis */
            overflow: hidden;
            /* Menyembunyikan garis sebelum muncul */
            transition: color 0.3s ease;
            /* Transisi untuk perubahan warna */
        }

        /* Membuat garis bawah di elemen pseudo */
        .navbar-nav .nav-link::after {
            content: '';
            /* Membuat elemen pseudo untuk garis bawah */
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: blue;
            transform: scaleX(0);
            /* Menyembunyikan garis */
            transform-origin: center;
            /* Menyusun garis dari tengah */
            transition: transform 0.3s ease-out;
            /* Transisi untuk animasi sliding */
        }

        /* Ketika hover, garis bawah akan muncul dengan animasi dari tengah */
        .navbar-nav .nav-link:hover::after {
            transform: scaleX(1);
            /* Menampilkan garis secara horizontal */
            transform-origin: center;
            /* Menyusun garis dari tengah */
        }

        /* Menambahkan efek perubahan warna teks saat hover */
        .navbar-nav .nav-link:hover {
            color: blue !important;
        }


        .navbar-nav .nav-link.active {
            color: blue !important;
        }

        .navbar .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .judul-konten {
            padding-top: 80px;
        }

        .paragraf {
            padding-top: 30px
        }

        .btn-size {
            margin-top: 30px;
            padding: 15px 30px;
            font-size: 18px;
            width: 30%;
            border-radius: 10px;
        }

        .btn-utama {
            border: 2px solid blue;
            background-color: transparent;
            color: blue;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-utama:hover {
            background-color: blue;
            color: white;
        }
    </style>
</head>

<body>

    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/disarpus.png') }}" style="margin-left: 10px" alt="Logo">
            </a>

            {{-- toogle button mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- navbar-list --}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" id="homeLink">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tentang') }}" id="tentangLink">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bantuan') }}" id="bantuanLink">Bantuan</a>
                    </li>
                </ul>
                <form action="{{ route('login') }}" method="get">
                    <button type="submit" class="btn btn-utama ms-3" style="margin-right: 50px">Login</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- konten --}}
    <div class="container mt-4">
        @yield('konten')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p>&copy; 2024 Dinas Arsip dan Perpustakaan Kota Bandung. Semua hak cipta dilindungi.</p>
            <p>Hubungi kami: <a href="mailto:info@disarpusbandung.go.id"
                    class="text-white">info@disarpusbandung.go.id</a></p>
            <p>
                <a href="#" class="text-white">Kebijakan Privasi</a> |
                <a href="#" class="text-white">Syarat dan Ketentuan</a>
            </p>
        </div>
    </footer>

    <!-- Script untuk mengatur kelas active pada Home saat scroll -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk menambahkan kelas aktif pada elemen navbar
        function setActiveNav() {
            var homeLink = document.getElementById('homeLink');
            var tentangLink = document.getElementById('tentangLink');
            var bantuanLink = document.getElementById('bantuanLink');

            // Periksa URL saat ini dan atur kelas active
            if (window.location.pathname === "/home" || window.location.pathname === "/") {
                homeLink.classList.add("active");
                tentangLink.classList.remove("active");
                bantuanLink.classList.remove("active");
            } else if (window.location.pathname === "/tentang") {
                homeLink.classList.remove("active");
                tentangLink.classList.add("active");
                bantuanLink.classList.remove("active");
            } else if (window.location.pathname === "/bantuan") {
                homeLink.classList.remove("active");
                tentangLink.classList.remove("active");
                bantuanLink.classList.add("active");
            }
        }

        // Jalankan fungsi setActiveNav saat halaman selesai dimuat
        window.onload = setActiveNav;

        // Menangani scroll event untuk mengubah kelas aktif
        window.addEventListener('scroll', function() {
            // Tidak menghapus kelas 'active' saat scroll, cukup untuk hover tetap aktif
            setActiveNav(); // Menambahkan kembali kelas aktif berdasarkan URL
        });
    </script>
</body>

</html>
