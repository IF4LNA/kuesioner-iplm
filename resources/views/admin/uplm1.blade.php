@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>UPLM 1 Pemerataan Layanan Perpustakaan</h3>

    <!-- Tambahkan tombol untuk laporan -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="" class="btn btn-success">Export to Excel</a>
            <a href="" class="btn btn-danger">Export to PDF</a> 
        </div>
    </div>

    <!-- Tambahkan margin pada tabel -->    
    <div style="margin-top: 1rem;" class="table-responsive">
        <table class="table table-striped" style="width: 150%;">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2025</td>
                    <td>Perpustakaan SMK Telkom Bandung</td>
                    <td>237623746</td>
                    <td>SMK</td>
                    <td>Jl, Kartanagara, Bandung Kulon</td>
                    <td>Babakan Kulon</td>
                    <td>Babakan Kulon</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="" class="btn btn-primary btn-sm">Edit</a>

                        <!-- Tombol Hapus -->
                        <form action="" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection