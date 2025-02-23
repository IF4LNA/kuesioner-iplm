<div>
    @if ($perpustakaanBelumMengisi->isEmpty())
        <div class="alert alert-success text-center">
            <strong>Semua Perpustakaan Sudah Mengisi Kuesioner tahun {{ $selectedYear }}</strong>
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Perpustakaan</th>
                    <th>Jenis & Subjenis</th>
                    <th>Lokasi</th>
                    <th>Kontak</th>
                    <th>Status Pengisian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perpustakaanBelumMengisi as $perpustakaan)
                <tr>
                    <td>{{ $perpustakaan->nama_perpustakaan }}</td>
                    <td>{{ $perpustakaan->jenis->jenis ?? '-' }}, {{ $perpustakaan->jenis->subjenis ?? '-' }}</td>
                    <td>
                        {{ $perpustakaan->alamat ?? '-' }},
                        {{ $perpustakaan->kelurahan->nama_kelurahan ?? '-' }},
                        {{ $perpustakaan->kelurahan->kecamatan->nama_kecamatan ?? '-' }},
                        {{ $perpustakaan->kelurahan->kecamatan->kota->nama_kota ?? '-' }}
                    </td>
                    <td>{{ $perpustakaan->kontak ?? '-' }}</td>
                    <td><span class="badge bg-danger">Belum Mengisi</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $perpustakaanBelumMengisi->links() }}
        </div>
    @endif
</div>
