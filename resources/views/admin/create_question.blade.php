@extends('layouts.app')

@section('title', 'Buat Pertanyaan')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Pertanyaan</h1>

    <!-- Notifikasi Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <!-- Tombol untuk menyembunyikan/menampilkan form -->
    <button id="toggleFormButton" class="btn btn-secondary mb-3">Sembunyikan Form</button>

    <!-- Form untuk membuat pertanyaan -->
    <div id="formContainer">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="teks_pertanyaan" class="form-label">Teks Pertanyaan</label>
                <input type="text" name="teks_pertanyaan" id="teks_pertanyaan" class="form-control @error('teks_pertanyaan') is-invalid @enderror" value="{{ old('teks_pertanyaan') }}" required>
                @error('teks_pertanyaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach(['UPLM 1', 'UPLM 2', 'UPLM 3', 'UPLM 4', 'UPLM 5', 'UPLM 6', 'UPLM 7'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}" required>
                @error('tahun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#copyQuestionModal">
                Copy Pertanyaan
            </button>            
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
            @foreach ($questions as $index => $question)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- Menampilkan nomor urut, bukan ID asli -->
                <td>{{ $question->teks_pertanyaan }}</td>
                <td>{{ $question->kategori }}</td>
                <td>{{ $question->tahun }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('questions.edit', $question->id_pertanyaan) }}" class="btn btn-warning btn-sm me-1"> 
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('questions.destroy', $question->id_pertanyaan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>                
            </tr>
        @endforeach        
        </tbody>
    </table>
</div>

<!-- Modal Copy Pertanyaan -->
<div class="modal fade" id="copyQuestionModal" tabindex="-1" aria-labelledby="copyQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyQuestionModalLabel">Copy Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="copyQuestionForm" action="{{ route('questions.copy') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_sumber" class="form-label">Pilih Tahun Sumber</label>
                        <select id="tahun_sumber" name="tahun_sumber" class="form-control" required>
                            <option value="" disabled selected>Pilih Tahun</option>
                            @foreach ($questions->pluck('tahun')->unique() as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Pertanyaan</label>
                        <div id="questionList">
                            <p class="text-muted">Pilih tahun sumber terlebih dahulu.</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_tujuan" class="form-label">Pilih Tahun Tujuan</label>
                        <input type="number" id="tahun_tujuan" name="tahun_tujuan" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Copy</button>
                </form>
            </div>
        </div>
    </div>
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
<script>
    document.getElementById('tahun_sumber').addEventListener('change', function() {
        const tahun = this.value;
        fetch(`/questions/get-by-year/${tahun}`)
            .then(response => response.json())
            .then(data => {
                const questionList = document.getElementById('questionList');
                questionList.innerHTML = '';
    
                if (data.length === 0) {
                    questionList.innerHTML = '<p class="text-danger">Tidak ada pertanyaan untuk tahun ini.</p>';
                    return;
                }
    
                // Checkbox "Pilih Semua"
                const selectAll = document.createElement('input');
                selectAll.type = 'checkbox';
                selectAll.id = 'selectAllQuestions';
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                        checkbox.checked = selectAll.checked;
                    });
                });
    
                const labelSelectAll = document.createElement('label');
                labelSelectAll.innerText = ' Pilih Semua';
                labelSelectAll.setAttribute('for', 'selectAllQuestions');
    
                questionList.appendChild(selectAll);
                questionList.appendChild(labelSelectAll);
                questionList.appendChild(document.createElement('br'));
    
                // Checkbox untuk tiap pertanyaan
                data.forEach(question => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'selected_questions[]';
                    checkbox.value = question.id_pertanyaan;
                    checkbox.classList.add('question-checkbox');
    
                    const label = document.createElement('label');
                    label.innerText = ` ${question.teks_pertanyaan}`;
                    label.setAttribute('for', `question-${question.id_pertanyaan}`);
    
                    questionList.appendChild(checkbox);
                    questionList.appendChild(label);
                    questionList.appendChild(document.createElement('br'));
                });
            });
    });
    </script>    
@endsection
