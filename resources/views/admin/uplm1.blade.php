@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="p-1">UPLM 1 Pemerataan Layanan Perpustakaan</h3>

        <!-- Form Filter -->
        <div class="mb-4">
            <form action="{{ route('uplm', $id) }}" method="GET">
                <div class="row">
                    <div class="col-md-4 position-relative">
                        <!-- Button for Dropdown -->
                        <button class="btn btn-outline-primary btn-md" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter"></i> Filter Jenis Perpustakaan
                        </button>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li>
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
                                    <option value="khusus" {{ request()->jenis == 'khusus' ? 'selected' : '' }}>Khusus
                                    </option>
                                    <option value="perguruan_tinggi"
                                        {{ request()->jenis == 'perguruan_tinggi' ? 'selected' : '' }}>Perguruan Tinggi
                                    </option>
                                </select>
                            </li>
                            <li class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Terapkan
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered" style="width: 120%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Nama Perpustakaan</th>
                        <th>NPP</th>
                        <th>Jenis Perpustakaan</th>
                        <th>Sub Jenis Perpustakaan</th>
                        <th>Alamat</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
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
                            <td>{{ $item->jenis->jenis ?? '-' }}</td>
                            <td>{{ $item->jenis->subjenis ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
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
                            <td colspan="9" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
