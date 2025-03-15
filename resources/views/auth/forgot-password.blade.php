<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #007bff, #00a8ff);
            color: white;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-right: none;
            border-radius: 5px 0 0 5px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff, #00a8ff);
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #007bff);
        }
        .alert {
            border-radius: 5px;
        }
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
            padding: 1rem;
        }
        .card-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .card-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow-lg">
                    <div class="card-header text-center py-3">
                        <h3 class="card-title fw-bold mb-0">Lupa Password</h3>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-center mb-4">Masukkan email Anda untuk menerima link reset password.</p>
                        
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email">
                                </div>
                                @error('email')
                                    <div class="text-danger mt-2">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Kirim Link Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <small class="text-muted">Sudah ingat password? <a href="{{ route('login') }}" class="text-primary">Login disini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>