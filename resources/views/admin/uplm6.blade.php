<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
            border-right: 1px solid #ddd;
            overflow-y: overlay;
            /* Scrollbar tidak memakan ruang */
            padding-right: 0;
        }

        .sidebar ul {
            padding-left: 15px;
        }

        /* jarak fitur sidebar */
        .sidebar .nav-item {
            margin-bottom: 20px;
        }

        .sidebar .nav-item a {
            color: rgb(155, 155, 155);
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            position: relative;
            padding: 10px 15px;
            border-radius: 5px;
            width: fit-content;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar .nav-item a i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Hover effect */
        .sidebar .nav-item a:hover {
            color: #007bff;
        }

        /* Active state */
        .sidebar .nav-item a.active {
            color: #007bff;
        }

        /* Collapse submenu */
        .sidebar .collapse {
            display: none;
        }

        .sidebar .collapse.show {
            display: block;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Navbar */
        .navbar-custom {
            background-color: #f8f9fa;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .search-container {
            flex-grow: 1;
            max-width: 400px;
            margin-right: 10px;
        }

        .navbar-custom .welcome-message {
            margin-left: auto;
            white-space: nowrap;
        }

        /* Adjusting content for navbar */
        .content {
            margin-top: 70px;
            /* Give space for the navbar */
        }

        .sidebar .nav-item a i.toggle-icon {
            padding-left: 10px;
            /* Menambah jarak antara teks dan ikon */
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="container">
            <div class="mb-4 text-center">
                <!-- Logo -->
                <img src="{{ asset('images/disarpus.png') }}" alt="Logo" class="img-fluid" style="height: 70px;">
            </div>

            <!-- Navigation Menu -->
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fas fa-home-alt"></i> Dashboard
                    </a>
                </li>
                <!-- UPLM Dropdown -->
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#uplmSubmenu"
                        data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="uplmSubmenu">
                        <span><i class="fas fa-chart-bar"></i> UPLM</span>
                        <i class="fas fa-chevron-right toggle-icon"></i>
                    </a>
                    <ul class="collapse list-unstyled" id="uplmSubmenu">
                        @for ($i = 1; $i <= 7; $i++)
                            <li class="nav-item">
                                <a class="nav-link ms-3 {{ request()->is('uplm/' . $i) ? 'active' : '' }}"
                                    href="{{ route('uplm.show', $i) }}">
                                    UPLM {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </li>
                <!-- Buat Akun -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.create') ? 'active' : '' }}"
                        href="{{ route('user.create') }}">
                        <i class="fas fa-user-plus"></i> Buat Akun
                    </a>
                </li>
                <!-- Rekapitulasi -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('recap') ? 'active' : '' }}" href="{{ route('recap') }}">
                        <i class="fas fa-clipboard-list"></i> Rekapitulasi
                    </a>
                </li>
                <!-- Notifikasi -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}"
                        href="{{ route('notifications') }}">
                        <i class="fas fa-bell"></i> Notifikasi
                    </a>
                </li>
                <!-- Pengaturan -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}"
                        href="{{ route('settings') }}">
                        <i class="fas fa-cogs"></i> Pengaturan
                    </a>
                </li>
                <!-- Logout -->
                <li class="nav-item mt-5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>

        </div>
    </div>

    <!-- Navbar -->
    <div class="navbar-custom">
        <div class="d-flex">
            <div class="search-container">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
            </div>
            <div class="welcome-message">
                <h5>{{ Auth::user()->username }}!</h5>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Selamat datang di halaman uplm 6!</h2>
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleLink = document.querySelector('[href="#uplmSubmenu"]');
            const toggleIcon = toggleLink.querySelector('.toggle-icon');
            const submenu = document.querySelector('#uplmSubmenu');
            
            // Cek status submenu di sessionStorage
            if (sessionStorage.getItem('uplmSubmenu') === 'open') {
                submenu.classList.add('show'); // Pastikan submenu terbuka jika statusnya 'open'
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-down');
            } else {
                submenu.classList.remove('show'); // Pastikan submenu tertutup jika statusnya 'closed'
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-right');
            }
    
            // Menambahkan event listener untuk ketika submenu muncul
            submenu.addEventListener('show.bs.collapse', function() {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-down');
                // Simpan status 'open' saat submenu terbuka
                sessionStorage.setItem('uplmSubmenu', 'open');
            });
    
            // Menambahkan event listener untuk ketika submenu tersembunyi
            submenu.addEventListener('hide.bs.collapse', function() {
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-right');
                // Simpan status 'closed' saat submenu tertutup
                sessionStorage.setItem('uplmSubmenu', 'closed');
            });
        });
    </script>
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
