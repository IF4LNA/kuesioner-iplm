<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- icon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Kustomisasi tinggi minimum */
        .bg-primary-custom {
            min-height: 150px;
            /* Default */
        }

        .form-section {
            min-height: 300px;
        }

        @media (min-width: 768px) {

            .bg-primary-custom,
            .form-section {
                min-height: 100%;
                /* Tinggi penuh pada layar besar */
            }
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row shadow-lg rounded-lg overflow-hidden mx-2 mx-md-0">
            <!-- Left Section -->
            <div
                class="col-12 col-md-6 bg-primary bg-primary-custom d-flex align-items-center justify-content-center p-4">
                <img src="{{ asset('images/disarpus.png') }}" alt="Login Image" class="img-fluid"
                    style="width: 150px; height: auto;">
            </div>
            <!-- Right Section -->
            <div class="col-12 col-md-6 bg-white p-4 p-md-5 form-section d-flex align-items-center">
                <div class="w-100">
                    <h2 class="text-center fw-bold mb-4">Login</h2>
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <!-- Form Input Username -->
                        <div class="mb-3">
                            <label for="username"
                                class="form-label @error('username') text-danger @enderror">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    placeholder="Masukan nama" required
                                    class="form-control @error('username') is-invalid @enderror">
                            </div>
                        </div>

                        <!-- Form Input Password -->
                        <div class="mb-3">
                            <label for="password"
                                class="form-label @error('password') text-danger @enderror">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" value="{{ old('password') }}"
                                    placeholder="Masukan password" required
                                    class="form-control @error('password') is-invalid @enderror">
                            </div>
                            @error('password')
                                <div class="text-danger mt-2">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
