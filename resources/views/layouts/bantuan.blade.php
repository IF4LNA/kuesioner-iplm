@extends('layouts.index')

@section('konten')

<!-- Halaman Bantuan -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <!-- Judul -->
                <h2 class="fw-bold text-center mb-4">
                    <i class="bi bi-question-circle-fill text-primary me-2"></i> Bantuan
                </h2>

                <!-- Card: Panduan Pengisian -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-journal-check me-2"></i> Panduan Pengisian
                        </h4>
                        <p class="text-secondary">
                            Untuk memastikan bahwa Anda mengisi kuesioner dengan benar, kami menyediakan panduan langkah demi langkah.
                            Mulailah dengan memilih kategori pertanyaan yang sesuai dengan situasi Anda dan pastikan seluruh data yang dimasukkan akurat.
                            Bacalah setiap instruksi dengan teliti sebelum melanjutkan ke bagian berikutnya.
                        </p>
                    </div>
                </div>

                <!-- Card: FAQ -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i> FAQ (Pertanyaan yang Sering Diajukan)
                        </h4>
                        <ul class="list-unstyled text-secondary">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Bagaimana cara mengisi kuesioner?</strong> Ikuti langkah-langkah panduan yang telah disediakan untuk mengisi kuesioner dengan mudah.
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Tidak bisa mengakses kuesioner?</strong> Pastikan koneksi internet stabil dan perangkat Anda mendukung pengisian online.
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Mengisi data yang salah?</strong> Anda bisa mengedit sebelum mengirim. Pastikan semua informasi telah diperiksa kembali.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card: Dukungan Teknis -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-headset me-2"></i> Dukungan Teknis
                        </h4>
                        <p class="text-secondary">
                            Jika Anda mengalami kendala teknis seperti masalah login atau pengisian kuesioner, silakan hubungi tim dukungan kami melalui formulir kontak atau nomor yang tertera.
                            Kami siap membantu Anda secepat mungkin.
                        </p>
                        <a href="tel:+6281234567890" class="btn btn-outline-primary">
                            <i class="bi bi-telephone-fill me-2"></i> Hubungi Tim Dukungan
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
