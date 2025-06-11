<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        .login-container {
            max-width: 1000px;
        }

        .bg-primary-custom {
            background: rgb(37, 100, 218);
            min-height: 150px;
        }

        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
        }

        .btn-primary {
            background-color: rgb(37, 100, 218);
            border: none;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1b5b9b;
            transform: translateY(-2px);
        }

        .forgot-password-link {
            color: #2c3e50;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #3498db;
        }

        @media (max-width: 768px) {
            .bg-primary-custom {
                min-height: 120px !important;
                padding: 1.5rem !important;
            }

            .form-section {
                padding: 2rem !important;
            }

            .login-container {
                margin: 1rem !important;
            }
        }

        .input-group-text,
        .form-control {
            transition: all 0.3s ease !important;
        }

        .input-group:focus-within .input-group-text {
            background-color: #e8f0fe !important;
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container login-container">
        <div class="row shadow-lg rounded-4 overflow-hidden mx-2 mx-md-0 bg-white">
            <!-- Left Section -->
            <div
                class="col-12 col-md-6 bg-primary bg-primary-custom d-flex align-items-center justify-content-center p-4">
                <img src="{{ asset('images/disarpus.png') }}" alt="Login Image" class="img-fluid"
                    style="width: 150px; height: auto;">
            </div>

            <!-- Right Section -->
            <div class="col-12 col-md-6 p-4 p-md-5 form-section">
                <h2 class="text-center fw-bold mb-4">Selamat Datang</h2>
                <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda</p>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- Username Input -->
                    <div class="mb-4">
                        <label for="username" class="form-label fw-medium">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-user text-secondary"></i>
                            </span>
                            <input type="text" id="username" name="username"
                                class="form-control rounded-end border-start-0 py-2" placeholder="Masukkan username"
                                value="{{ old('username') }}">
                        </div>
                        @error('username')
                            <div class="alert alert-danger mt-2 p-2 small d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-lock text-secondary"></i>
                            </span>
                            <input type="password" id="password" name="password"
                                class="form-control rounded-end border-start-0 py-2" placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="alert alert-danger mt-2 p-2 small d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary fw-medium">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-center">
                        <a href="{{ route('password.request') }}"
                            class="forgot-password-link text-decoration-none small">
                            Lupa Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
