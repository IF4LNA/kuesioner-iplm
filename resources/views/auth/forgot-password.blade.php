<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-lg p-4">
                <div class="card-body">
                    <h3 class="text-center fw-bold">Lupa Password</h3>
                    <p class="text-center">Masukkan email Anda untuk menerima link reset password.</p>
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
                            <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>