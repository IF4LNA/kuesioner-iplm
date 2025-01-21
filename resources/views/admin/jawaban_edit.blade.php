@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Jawaban</h3>
    <form action="{{ route('uplm.jawaban.update', ['id' => $id, 'jawaban' => $jawaban->id_jawaban]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="jawaban" class="form-label">Jawaban</label>
            <input type="text" class="form-control" id="jawaban" name="jawaban" value="{{ $jawaban->jawaban }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
