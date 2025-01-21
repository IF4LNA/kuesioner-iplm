<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
            overflow-y: auto;
            transition: transform 0.3s ease;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .sidebar.hidden {
            transform: translateX(-250px);
        }

        .sidebar::-webkit-scrollbar {
            width: 0;
        }

        .sidebar:hover {
            scrollbar-color: #888 #f0f0f0;
        }

        .sidebar:hover::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar:hover::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        .sidebar:hover::-webkit-scrollbar-track {
            background-color: #f0f0f0;
        }

        .sidebar ul {
            padding-left: 15px;
        }

        .sidebar .nav-item {
            margin-bottom: 28px;
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

        .sidebar .nav-item a:hover {
            color: #007bff;
        }

        .sidebar .nav-item a.active {
            color: #007bff;
        }

        .sidebar .nav-item a .toggle-icon {
            margin-left: 18px;
            /* Atur margin sesuai keinginan Anda */
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Saat sidebar tersembunyi, konten akan mengisi lebar penuh */
        .content.shifted {
            margin-left: 0;
            width: 100%;
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
            width: calc(100% - 250px);
            /* Set width to fill remaining space */
            transition: left 0.3s ease, width 0.3s ease;
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

        .content {
            margin-top: 70px;
        }

        /* Media Query for Mobile */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                transform: translateX(-250px);
                /* Menyembunyikan sidebar */
            }

            .sidebar.hidden {
                transform: translateX(0);
                /* Menampilkan sidebar jika hidden class ditambahkan */
            }

            .content {
                margin-left: 0;
            }

            .navbar-custom {
                left: 0;
                width: 100%;
                /* Navbar akan mengisi lebar penuh jika sidebar tersembunyi */
            }

            /* Menampilkan tombol toggle */
            #toggleSidebar {
                display: block;
                /* Pastikan tombol tampil */
                position: absolute;
                top: 20px;
                left: 15px;
            }
        }


        @media (max-width: 576px) {
            .navbar-custom .welcome-message {
                font-size: 14px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="container">
            <div class="mb-4 text-center">
                <!-- Logo -->
                <img src="{{ asset('images/disarpus.png') }}" alt="Logo" class="img-fluid" style="height: 70px;">
            </div>

            <!-- Navigation Menu -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fas fa-home-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#uplmSubmenu"
                        data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="uplmSubmenu">
                        <span><i class="fas fa-chart-bar"></i> UPLM</span>
                        <i class="fas fa-chevron-right toggle-icon"></i>
                    </a>
                    <ul class="collapse list-unstyled" id="uplmSubmenu">
                        @for ($i = 1; $i <= 7; $i++)
                            <li class="nav-item">
                                <a class="nav-link ms-3 {{ request()->is('uplm/' . $i) || request()->is('uplm/' . $i . '/filter') ? 'active' : '' }}"
                                   href="{{ route('uplm', $i) }}">
                                    UPLM {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>                                        
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.create') ? 'active' : '' }}"
                        href="{{ route('user.create') }}">
                        <i class="fas fa-user-plus"></i> Buat Akun
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('questions.create') ? 'active' : '' }}" href="{{ route('questions.create') }}">
                        <i class="fas fa-question-circle"></i> Buat Pertanyaan
                    </a>
                </li>                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('recap') ? 'active' : '' }}" href="{{ route('recap') }}">
                        <i class="fas fa-clipboard-list"></i> Rekapitulasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}"
                        href="{{ route('notifications') }}">
                        <i class="fas fa-bell"></i> Notifikasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}"
                        href="{{ route('settings') }}">
                        <i class="fas fa-cogs"></i> Pengaturan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->url() == route('admin.activity-logs') ? 'active' : '' }}" href="{{ route('admin.activity-logs') }}">
                        <i class="fas fa-clipboard-list"></i> Activity Logs
                    </a>
                </li>

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
            <!-- Sidebar toggle button -->
            <button class="btn btn-link text-dark" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="search-container">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
            </div>

            <div class="welcome-message">
                <h5>{{ Auth::user()->username }}</h5>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="content" class="content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('#toggleSidebar');
            const sidebar = document.querySelector('#sidebar');
            const content = document.querySelector('#content');
            const navbar = document.querySelector('.navbar-custom');

            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                content.classList.toggle('shifted');

                // Menangani posisi navbar saat sidebar muncul atau tersembunyi
                if (sidebar.classList.contains('hidden')) {
                    navbar.style.left = '0'; // Navbar tetap di kiri saat sidebar tersembunyi
                    navbar.style.width = '100%'; // Navbar penuh saat sidebar tersembunyi
                } else {
                    navbar.style.left = '250px'; // Navbar bergerak ke kanan saat sidebar terlihat
                    navbar.style.width = 'calc(100% - 250px)'; // Sesuaikan lebar navbar
                }

                // Update lebar konten untuk memastikan responsif
                if (sidebar.classList.contains('hidden')) {
                    content.style.width = '100%'; // Konten mengisi lebar penuh saat sidebar tersembunyi
                } else {
                    content.style.width = 'calc(100% - 250px)'; // Konten disesuaikan saat sidebar terlihat
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toggleLink = document.querySelector('[href="#uplmSubmenu"]');
            const toggleIcon = toggleLink.querySelector('.toggle-icon');
            const submenu = document.querySelector('#uplmSubmenu');

            // Restore submenu state from sessionStorage
            if (sessionStorage.getItem('uplmSubmenu') === 'open') {
                submenu.classList.add('show');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-down');
            } else {
                submenu.classList.remove('show');
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-right');
            }

            // Handle submenu state changes
            submenu.addEventListener('show.bs.collapse', function() {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-down');
                sessionStorage.setItem('uplmSubmenu', 'open');
            });

            submenu.addEventListener('hide.bs.collapse', function() {
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-right');
                sessionStorage.setItem('uplmSubmenu', 'closed');
            });
        });
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
