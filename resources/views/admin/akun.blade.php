@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h3>Buat Akun Baru</h3>
                @if (session('success'))
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
                                <option value="">-- Pilih Jenis --</option>
                                <option value="umum">Umum</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="perguruan tinggi">Perguruan Tinggi</option>
                                <option value="khusus">Khusus</option>
                            </select>
                        </div>

                        <!-- Field subjenis hanya muncul untuk jenis tertentu -->
                        <div class="mb-3" id="subjenis-fields" style="display: none;">
                            <label for="subjenis" class="form-label">Subjenis Perpustakaan</label>
                            <select name="subjenis" id="subjenis" class="form-select">
                                <!-- Opsi akan diisi secara dinamis oleh JavaScript -->
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Akun</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Tampilkan/matikan field pustakawan berdasarkan pilihan role
        document.getElementById('role').addEventListener('change', function() {
            const fields = document.getElementById('pustakawan-fields');
            const subjenisFields = document.getElementById('subjenis-fields');
            if (this.value === 'pustakawan') {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
                subjenisFields.style.display = 'none'; // Sembunyikan subjenis jika bukan pustakawan
            }
        });

        // Menampilkan field subjenis hanya untuk jenis 'umum' atau 'sekolah'
        document.getElementById('jenis').addEventListener('change', function() {
    const selectedJenis = this.value;
    const subjenisFields = document.getElementById('subjenis-fields');
    const subjenisSelect = document.getElementById('subjenis');

    subjenisSelect.innerHTML = ''; // Hapus opsi yang sudah ada
    subjenisFields.style.display = 'none';

    // Jika jenis dipilih, cek apakah memiliki subjenis
    if (selectedJenis) {
        fetch(`/getSubjenis/${selectedJenis}`)
            .then(response => response.json())
            .then(data => {
                console.log('Subjenis Data:', data);
                
                // Tampilkan field subjenis hanya jika ada data subjenis
                if (data.hasSubjenis) {
                    subjenisFields.style.display = 'block';
                    
                    // Isi opsi subjenis jika ada
                    if (data.subjenis && data.subjenis.length > 0) {
                        data.subjenis.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub;
                            option.textContent = sub;
                            subjenisSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Tidak ada subjenis';
                        subjenisSelect.appendChild(option);
                    }
                } else {
                    subjenisFields.style.display = 'none';
                }
            })
            .catch(error => console.error('Error fetching subjenis:', error));
    }
});
    </script>
@endsection
