    @extends('layouts.index') 

    @section('konten')
    <div class="row px-4 py-4"> <!-- Menambahkan padding di sekitar konten -->
        <!-- Bagian Teks di Kiri (Tentang) -->
        <div class="col-md-6">
            <h1 class="judul-konten mb-3">Dinas Arsip dan Perpustakaan Kota Bandung</h1>
            <p class="paragraf mb-4">
                Bergabunglah dalam upaya peningkatan literasi masyarakat untuk masa depan Kota Bandung yang lebih cerdas dan berkelanjutan.
            </p>

            <div class="d-grid gap-2">
                <form action="{{ route('login') }}" method="GET">
                    <button class="btn btn-primary btn-size">Login</button>
                </form>
            </div>
        </div>
        
        <!-- Bagian Gambar di Kanan -->
        <div class="col-md-6 position-relative">
            <!-- Gambar di belakang -->
            <img src="{{ asset('images/peta.png') }}" 
                class="img-fluid img-back" 
                alt="gambar latar" 
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; opacity: 0.5;">
        
            <!-- Gambar utama -->
            <img src="{{ asset('images/img1_home.png') }}" 
        class="img-fluid img-front" 
        alt="gambar utama" 
        style="position: relative; z-index: 2; width: 500px; height: auto;">

        </div>
    </div>

    <hr class="my-5"> <!-- Pembatas antara bagian Tentang dan Bantuan -->

    <!-- Tentang Section -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="{{ asset('images/literasi.jpg') }}" class="img-fluid rounded shadow-sm" alt="Literasi Masyarakat">
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold text-primary mb-3">Tentang Indeks Pembangunan Literasi Masyarakat (IPLM)</h2>
                <p class="text-secondary">
                    IPLM digunakan untuk menilai perkembangan literasi di Kota Bandung. Survei ini mengumpulkan data tentang akses, kualitas, dan sebaran literasi dari literasi dasar hingga digital.
                </p>
                <p class="text-secondary">
                    Informasi ini membantu perumusan kebijakan literasi yang lebih efektif dan tepat sasaran.
                </p>
            </div>
        </div>

        <!-- Metodologi -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm p-4">
                    <div class="card-body">
                        <h3 class="card-title fw-semibold text-dark mb-3">
                            <i class="bi bi-bar-chart-fill text-primary me-2"></i> Metodologi
                        </h3>
                        <p class="text-secondary">
                            Survei dilakukan melalui wawancara, kuesioner online, dan pengamatan langsung. Responden dipilih acak dari berbagai lapisan masyarakat Kota Bandung.
                        </p>
                        <p class="text-secondary">
                            Data dianalisis untuk merumuskan kebijakan yang mendukung peningkatan akses, pelatihan digital, dan kesadaran literasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr class="my-5">

<!-- Bantuan Section -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <h2 class="fw-bold text-center mb-4">
                    <i class="bi bi-question-circle-fill text-primary me-2"></i> Bantuan
                </h2>

                <!-- Panduan Pengisian -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-journal-check me-2"></i> Panduan Pengisian
                        </h4>
                        <p class="text-secondary">
                            Ikuti panduan langkah demi langkah. Pilih kategori pertanyaan yang sesuai, isi data dengan akurat, dan baca instruksi sebelum lanjut.
                        </p>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i> FAQ (Pertanyaan yang Sering Diajukan)
                        </h4>
                        <ul class="list-unstyled text-secondary">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Bagaimana cara mengisi kuesioner?</strong> Ikuti panduan yang tersedia.
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Tidak bisa mengakses kuesioner?</strong> Pastikan koneksi stabil dan perangkat mendukung.
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Mengisi data yang salah?</strong> Periksa dan edit kembali sebelum dikirim.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Dukungan Teknis -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">
                            <i class="bi bi-tools me-2"></i> Dukungan Teknis
                        </h4>
                        <p class="text-secondary">
                            Jika mengalami kendala teknis seperti login atau pengisian, hubungi tim kami melalui formulir kontak atau nomor yang tersedia.
                        </p>
                        <button class="btn btn-primary">Hubungi Tim Dukungan</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
