<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Halaman awal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 100px;
        }

        .navbar {
            border-bottom: 1px solid #ccc;
            background-color: white;
        }

        .navbar-brand img {
            height: 70px;
            width: auto;
            padding-left: 50px;
        }

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
            width: 50%;
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

        /* Responsif untuk tampilan mobile */
        @media (max-width: 992px) {
            .navbar-collapse {
                display: flex;
                flex-direction: column;
                /* Menyusun item secara vertikal */
                align-items: flex-start;
                /* Menyusun item ke kiri dengan sedikit jarak */
                width: 100%;
                /* Memastikan navbar mengisi lebar penuh */
            }

            .navbar-brand img {
                height: 70px;
                width: auto;
                padding-left: 10px;
                /* Atur padding-left hanya di layar besar */
            }

            .navbar-nav {
                margin-top: 10px;
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .navbar-nav .nav-item {
                text-align: left;
                /* Menyelaraskan teks ke kiri */
                width: 100%;
                /* Membuat setiap item menu mengisi lebar penuh */
                margin-left: 20px;
                /* Memberikan sedikit jarak kiri */
            }

            .navbar-nav .nav-link {
                text-align: left;
                padding-left: 0;
                padding-right: 0;
                width: 50%;
            }

            .btn-size {
                width: 70%;
                margin-bottom: 100px;
            }

            .btn-utama {
                width: 100%;
                /* Tombol login mengisi lebar penuh */
                font-size: 14px;
                margin-top: 10px;
            }
            .navbar-toggler {
                border: none;
                /* Menghilangkan border jika ada */
            }
        }

        /* Responsif untuk tampilan mobile kecil */
        @media (max-width: 576px) {
            .navbar-brand img {
                height: 60px;
                /* Menyesuaikan ukuran logo agar pas di tampilan mobile */
                width: auto;
                /* Menjaga proporsi logo agar tidak pecah */
            }

            .btn-utama {
                width: 50%;
                font-size: 14px;
            }

            .judul-konten {
                padding-top: 40px;
            }

            .paragraf {
                padding-top: 20px;
            }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
