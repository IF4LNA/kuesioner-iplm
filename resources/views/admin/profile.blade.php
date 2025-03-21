@extends('layouts.app')

@section('content')
<style>
    /* Di bagian <style> */
    body {
        font-family: 'Roboto', sans-serif; /* Gunakan font Roboto seperti Google */
        background-color: #f8f9fa; /* Warna background yang ringan */
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Shadow ringan seperti Google */
    }

    .card-header {
        background-color: #fff; /* Warna background header card */
        border-bottom: 1px solid #e0e0e0; /* Garis bawah header */
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    h1 {
        font-size: 24px;
        font-weight: 500;
        color: #202124; /* Warna teks seperti Google */
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #5f6368; /* Warna teks label seperti Google */
    }

    .form-control {
        border: 1px solid #dadce0; /* Border seperti Google */
        border-radius: 4px;
        padding: 10px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #1a73e8; /* Warna border saat focus seperti Google */
        box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2); /* Shadow saat focus */
    }

    .btn-primary {
        background-color: #1a73e8; /* Warna tombol seperti Google */
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 4px;
    }

    .btn-primary:hover {
        background-color: #1557b5; /* Warna tombol saat hover */
    }

    .alert {
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #e8f0fe; /* Warna background alert sukses */
        border-color: #c3dafe;
        color: #1a73e8;
    }

    .alert-warning {
        background-color: #fff3cd; /* Warna background alert warning */
        border-color: #ffeeba;
        color: #856404;
    }

    /* Foto Profil */
    .profile-photo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }

    .profile-photo {
        border: 2px solid #ddd; /* Border untuk foto profil */
        padding: 5px;
        background-color: #fff;
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    .profile-photo-edit {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        border-radius: 50%;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-photo-container:hover .profile-photo-edit {
        opacity: 1;
    }

    .profile-photo-upload {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <!-- Header Card -->
            <div class="card-header">
                <h1 class="mb-0 text-center">Profil Admin</h1>
            </div>

            <!-- Body Card -->
            <div class="card-body">
                <!-- Notifikasi Sukses -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Notifikasi Warning -->
                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Foto Profil -->
                {{-- <div class="text-center mb-4">
                    <div class="profile-photo-container">
                        @if ($user->adminProfile && $user->adminProfile->foto)
                            <img src="{{ asset('storage/' . $user->adminProfile->foto) }}" alt="Foto Profil" class="profile-photo" id="profilePhoto">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Foto Profil Default" class="profile-photo" id="profilePhoto">
                        @endif
                        <div class="profile-photo-edit">
                            <i class="fas fa-edit"></i>
                        </div>
                        <input type="file" class="profile-photo-upload" id="foto" name="foto" accept="image/*">
                    </div>
                </div> --}}

                <!-- Form Profil Admin -->
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Admin -->
                    <div class="mb-4">
                        <label for="nama_admin" class="form-label fw-bold">Nama Admin</label>
                        <input type="text" class="form-control" id="nama_admin" name="nama_admin" value="{{ $user->adminProfile->nama_admin ?? '' }}" required>
                    </div>

                    <!-- NIP -->
                    <div class="mb-4">
                        <label for="nip" class="form-label fw-bold">NIP</label>
                        <input type="number" class="form-control" id="nip" name="nip" value="{{ $user->adminProfile->nip ?? '' }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-bold">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->adminProfile->alamat ?? '' }}">
                    </div>

                    <!-- Kontak -->
                    <div class="mb-4">
                        <label for="kontak" class="form-label fw-bold">Kontak</label>
                        <input type="text" class="form-control" id="kontak" name="kontak" value="{{ $user->adminProfile->kontak ?? '' }}">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript untuk menangani pratinjau foto
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePhoto').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection