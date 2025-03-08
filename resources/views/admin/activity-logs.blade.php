@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h3 class="mb-4">Aktivitas</h3>

                <style>
                    body {
                        font-family: 'Poppins', sans-serif;
                        font-size: 12px;
                        line-height: 1.6;
                        color: #333;
                    }

                    h3 {
                        font-size: 25px;
                        font-weight: bold;
                    }
                    .table th,
                    .table td {
                        font-size: 12px;
                        padding: 8px;
                        /* Menambah ruang antar sel */
                        vertical-align: middle;
                        /* Membuat konten sel lebih rapi */
                    }
                    .pagination {
                        display: flex;
                        justify-content: center;
                        margin-top: 20px;
                    }

                    .pagination .page-item {
                        margin: 0 5px;
                    }

                    .pagination .page-item.active .page-link {
                        background-color: #007bff;
                        border-color: #007bff;
                        color: white;
                    }

                    .pagination .page-link {
                        color: #007bff;
                        border: 1px solid #ddd;
                        padding: 8px 12px;
                        border-radius: 4px;
                        transition: all 0.3s ease;
                    }

                    .pagination .page-link:hover {
                        background-color: #007bff;
                        color: white;
                        border-color: #007bff;
                    }
                </style>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table">
                            <tr>
                                <th>#</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activityLogs as $log)
                                <tr>
                                    <td>{{ $loop->iteration + ($activityLogs->currentPage() - 1) * $activityLogs->perPage() }}
                                    </td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at }}</td>
                                    <td>{{ $log->user->username }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada aktivitas ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Informasi jumlah data -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan <strong>{{ $activityLogs->firstItem() }}</strong> sampai
                        <strong>{{ $activityLogs->lastItem() }}</strong> dari
                        <strong>{{ $activityLogs->total() }}</strong> data
                    </div>
                    <div>
                        {{ $activityLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
