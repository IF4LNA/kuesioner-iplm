@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="p-1">UPLM 3 Ketercukupan Tenaga Perpustakaan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Filter -->
        <div class="mb-3">
            <form action="{{ route('uplm', $id) }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <select name="jenis" id="jenis" class="form-select form-select-md"
                            aria-label="Pilih Jenis Perpustakaan">
                            <option value="">Pilih Jenis Perpustakaan</option>
                            <option value="umum" {{ request()->jenis == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="sd" {{ request()->jenis == 'sd' ? 'selected' : '' }}>SD</option>
                            <option value="smp" {{ request()->jenis == 'smp' ? 'selected' : '' }}>SMP</option>
                            <option value="mts" {{ request()->jenis == 'mts' ? 'selected' : '' }}>MTS</option>
                            <option value="sma" {{ request()->jenis == 'sma' ? 'selected' : '' }}>SMA</option>
                            <option value="smk" {{ request()->jenis == 'smk' ? 'selected' : '' }}>SMK</option>
                            <option value="ma" {{ request()->jenis == 'ma' ? 'selected' : '' }}>MA</option>
                            <option value="khusus" {{ request()->jenis == 'khusus' ? 'selected' : '' }}>Khusus</option>
                            <option value="perguruan_tinggi"
                                {{ request()->jenis == 'perguruan_tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary btn-md ms-1">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered" style="width: 150%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Nama Perpustakaan</th>
                        <th>NPP</th>
                        <th>Jenis Perpustakaan</th>
                        <th>Alamat</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        @foreach ($pertanyaan as $pertanyaanItem)
                            <th>{{ $pertanyaanItem->teks_pertanyaan }}</th> <!-- Kolom untuk setiap pertanyaan -->
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->created_at->format('Y') }}</td>
                            <td>{{ $item->nama_perpustakaan ?? '-' }}</td>
                            <td>{{ $item->npp ?? '-' }}</td>
                            <td>{{ $item->jenis ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                            @foreach ($pertanyaan as $pertanyaanItem)
                                <td>
                                    @php
                                        // Ambil jawaban yang sesuai dengan id_pertanyaan dan id_perpustakaan saat ini
                                        $jawaban = $item->jawaban->firstWhere(
                                            'id_pertanyaan',
                                            $pertanyaanItem->id_pertanyaan,
                                        );
                                    @endphp
                                    {{ $jawaban ? $jawaban->jawaban : '-' }}
                                </td>
                            @endforeach
                            <td>
                                <!-- Tombol untuk Edit, Delete -->
                                <a href="" class="btn btn-warning btn-sm">Edit</a>
                                <form action="" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
            </table>
        </div>
    </div>
@endsection
