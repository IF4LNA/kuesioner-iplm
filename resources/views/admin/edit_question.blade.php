@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Pertanyaan</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('questions.update', $question->id_pertanyaan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="teks_pertanyaan" class="form-label">Teks Pertanyaan</label>
            <input type="text" name="teks_pertanyaan" id="teks_pertanyaan" class="form-control @error('teks_pertanyaan') is-invalid @enderror" value="{{ old('teks_pertanyaan', $question->teks_pertanyaan) }}" required>
            @error('teks_pertanyaan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                <option value="" disabled>Pilih Kategori</option>
                @foreach(['UPLM 1', 'UPLM 2', 'UPLM 3', 'UPLM 4', 'UPLM 5', 'UPLM 6', 'UPLM 7'] as $kategori)
                    <option value="{{ $kategori }}" {{ old('kategori', $question->kategori) === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
            </select>
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $question->tahun) }}" required>
            @error('tahun')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('questions.create') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
