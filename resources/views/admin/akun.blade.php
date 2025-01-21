@extends('layouts.app')

@section('content')
    <div class="container mt-5">
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
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="umum">Umum</option>
                        <option value="sekolah">Sekolah</option>
                        <option value="khusus">Khusus</option>
                        <option value="perguruan tinggi">Perguruan Tinggi</option>
                    </select>
                </div>

                <!-- Subjenis input fields -->
                <div class="mb-3" id="subjenis-fields" style="display: none;">
                    <label for="subjenis" class="form-label">Subjenis Perpustakaan</label>
                    <select name="subjenis" id="subjenis" class="form-select" required>
                        <!-- Opsi akan diisi secara dinamis oleh JavaScript -->
                    </select>                      
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Buat Akun</button>
        </form>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const fields = document.getElementById('pustakawan-fields');
            const subjenisFields = document.getElementById('subjenis-fields');
            if (this.value === 'pustakawan') {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
                subjenisFields.style.display = 'none'; // Hide subjenis if not pustakawan
            }
        });

        document.getElementById('jenis').addEventListener('change', function() {
    const selectedJenis = this.value;
    const subjenisFields = document.getElementById('subjenis-fields');
    const subjenisSelect = document.getElementById('subjenis');

    // Clear existing options
    subjenisSelect.innerHTML = '';
    
    // Hide subjenis fields by default
    subjenisFields.style.display = 'none';

    // Only show subjenis if 'Umum' or 'Sekolah' is selected
    if (selectedJenis === 'umum' || selectedJenis === 'sekolah' || selectedJenis === 'perguruan tinggi' || selectedJenis === 'khusus') {
        subjenisFields.style.display = 'block';

        // Fetch subjenis data via AJAX based on jenis selected
        fetch(`/getSubjenis/${selectedJenis}`)
    .then(response => response.json())
    .then(data => {
        if (data.subjenis.length > 0) {
            // Populate the subjenis dropdown with the data
            data.subjenis.forEach(subjenis => {
                const option = document.createElement('option');
                option.value = subjenis; // Pastikan value sesuai dengan data subjenis
                option.textContent = subjenis; // Tampilkan teks subjenis
                subjenisSelect.appendChild(option);
            });
        } else {
            // Jika tidak ada subjenis, tampilkan opsi default
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Tidak ada subjenis';
            subjenisSelect.appendChild(option);
        }
    })
    .catch(error => console.error('Error fetching subjenis:', error));
    }
});

    </script>
@endsection
