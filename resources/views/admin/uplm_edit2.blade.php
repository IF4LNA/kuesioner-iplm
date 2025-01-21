@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Perpustakaan</h3>
    <form action="{{ route('uplm.update', ['id' => $id, 'perpustakaan' => $perpustakaan->id_perpustakaan]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_perpustakaan" class="form-label">Nama Perpustakaan</label>
            <input type="text" class="form-control" id="nama_perpustakaan" name="nama_perpustakaan" value="{{ $perpustakaan->nama_perpustakaan }}" required>
        </div>
        <div class="mb-3">
            <label for="npp" class="form-label">NPP</label>
            <input type="text" class="form-control" id="npp" name="npp" value="{{ $perpustakaan->npp }}">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $perpustakaan->alamat }}" required>
        </div>
        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Perpustakaan</label>
            <select name="jenis" class="form-select" required>
                <option value="">Pilih Jenis</option>
                @foreach ($jenisList as $jenis)
                    <option value="{{ $jenis }}" {{ $perpustakaan->jenis->jenis == $jenis ? 'selected' : '' }}>
                        {{ $jenis }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="subjenis" class="form-label">Subjenis Perpustakaan</label>
            <select name="subjenis" class="form-select">
                <option value="">Pilih Subjenis</option>
                @foreach ($subjenisList as $subjenis)
                    <option value="{{ $subjenis }}" {{ $perpustakaan->jenis->subjenis == $subjenis ? 'selected' : '' }}>
                        {{ $subjenis }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
