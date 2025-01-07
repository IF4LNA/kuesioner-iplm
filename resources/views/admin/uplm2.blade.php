@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="p-3">UPLM 2 Ketercukupan Koleksi Perpustakaan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Tombol Export -->
        <div>
            <a href="#" class="btn btn-success me-2">Export Excel</a>
            <a href="#" class="btn btn-danger">Export PDF</a>
        </div>
    </div>

    <div class="mt-4">
        <!-- Tambahkan class table-bordered -->
        <table class="table table-striped table-bordered" style="width: 150%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Nama Perpustakaan</th>
                    <th>NPP</th>
                    <th>Jenis Perpustakaan</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Jumlah Judul Koleksi Tercetak</th>
                    <th>Jumlah Judul Koleksi Digital</th>
                    <th>Jumlah Eksemplar Koleksi Tercetak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data Dummy -->
                <tr>
                    <td>1</td>
                    <td>2025</td>
                    <td>Perpustakaan Umum</td>
                    <td>123456</td>
                    <td>Umum</td>
                    <td>Jl. Mawar No. 10</td>
                    <td>Kelurahan Mawar</td>
                    <td>Kecamatan Melati</td>
                    <td>500</td>
                    <td>200</td>
                    <td>1000</td>
                    <td>
                        <!-- Tombol Aksi yang Terformat -->
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="#" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <!-- Data Dummy 2 -->
                <tr>
                    <td>2</td>
                    <td>2024</td>
                    <td>Perpustakaan Kota</td>
                    <td>654321</td>
                    <td>Perkotaan</td>
                    <td>Jl. Kenanga No. 5</td>
                    <td>Kelurahan Kenanga</td>
                    <td>Kecamatan Cempaka</td>
                    <td>400</td>
                    <td>300</td>
                    <td>800</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="#" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <!-- Data Dummy 3 -->
                <tr>
                    <td>3</td>
                    <td>2023</td>
                    <td>Perpustakaan Desa</td>
                    <td>112233</td>
                    <td>Desa</td>
                    <td>Jl. Melati No. 8</td>
                    <td>Kelurahan Melati</td>
                    <td>Kecamatan Bunga</td>
                    <td>300</td>
                    <td>150</td>
                    <td>600</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="#" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <!-- Data Dummy 4 -->
                <tr>
                    <td>4</td>
                    <td>2022</td>
                    <td>Perpustakaan Universitas</td>
                    <td>334455</td>
                    <td>Universitas</td>
                    <td>Jl. Cendana No. 20</td>
                    <td>Kelurahan Cendana</td>
                    <td>Kecamatan Mutiara</td>
                    <td>600</td>
                    <td>500</td>
                    <td>1200</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="#" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <!-- Data Dummy 5 -->
                <tr>
                    <td>5</td>
                    <td>2021</td>
                    <td>Perpustakaan Sekolah</td>
                    <td>998877</td>
                    <td>Sekolah</td>
                    <td>Jl. Raya No. 15</td>
                    <td>Kelurahan Raya</td>
                    <td>Kecamatan Sejahtera</td>
                    <td>700</td>
                    <td>350</td>
                    <td>1400</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="#" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
