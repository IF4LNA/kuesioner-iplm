@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Buat Akun Baru</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.store-account') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="pustakawan">Pustakawan</option>
            </select>
        </div>
        <div id="pustakawan-fields" style="display: none;">
            <div class="mb-3">
                <label for="nama_perpustakaan" class="form-label">Nama Perpustakaan</label>
                <input type="text" name="nama_perpustakaan" id="nama_perpustakaan" class="form-control">
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Perpustakaan</label>
                <select name="jenis" id="jenis" class="form-select">
                    <option value="umum">Umum</option>
                    <option value="sd">SD</option>
                    <option value="smp">SMP</option>
                    <option value="mts">MTS</option>
                    <option value="sma">SMA</option>
                    <option value="smk">SMK</option>
                    <option value="ma">MA</option>
                    <option value="khusus">Khusus</option>
                    <option value="perguruan_tinggi">Perguruan Tinggi</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Buat Akun</button>
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function () {
        const fields = document.getElementById('pustakawan-fields');
        if (this.value === 'pustakawan') {
            fields.style.display = 'block';
        } else {
            fields.style.display = 'none';
        }
    });
</script>
@endsection
