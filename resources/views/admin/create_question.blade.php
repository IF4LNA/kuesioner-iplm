@extends('layouts.app')

@section('title', 'Buat Pertanyaan')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Pertanyaan</h1>

    <!-- Tombol untuk menyembunyikan/menampilkan form -->
    <button id="toggleFormButton" class="btn btn-secondary mb-3">Sembunyikan Form</button>

    <!-- Form untuk membuat pertanyaan -->
    <div id="formContainer">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="teks_pertanyaan" class="form-label">Teks Pertanyaan</label>
                <input type="text" name="teks_pertanyaan" id="teks_pertanyaan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <hr class="my-4">

    <!-- Tabel untuk menampilkan pertanyaan yang sudah dibuat -->
    <h2 class="mb-3">Daftar Pertanyaan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Teks Pertanyaan</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->id_pertanyaan }}</td>
                    <td>{{ $question->teks_pertanyaan }}</td>
                    <td>{{ $question->kategori }}</td>
                    <td>{{ $question->tahun }}</td>
                    <td>
                        <!-- Tambahkan aksi seperti edit atau hapus jika diperlukan -->
                        <form action="{{ route('questions.destroy', $question->id_pertanyaan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleFormButton = document.getElementById('toggleFormButton');
        const formContainer = document.getElementById('formContainer');

        toggleFormButton.addEventListener('click', () => {
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
                toggleFormButton.textContent = 'Sembunyikan Form';
            } else {
                formContainer.style.display = 'none';
                toggleFormButton.textContent = 'Tampilkan Form';
            }
        });
    });
</script>
@endsection
