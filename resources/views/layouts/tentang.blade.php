@extends('layouts.index')

@section('konten')

<!-- Bagian Tentang -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Gambar ilustrasi -->
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="{{ asset('images/literasi.jpg') }}" class="img-fluid rounded shadow-sm" alt="Literasi Masyarakat">
            </div>
            <!-- Konten teks -->
            <div class="col-md-7">
                <h2 class="fw-bold text-primary mb-3">Tentang Indeks Pembangunan Literasi Masyarakat (IPLM)</h2>
                <p class="text-secondary">
                    Indeks Pembangunan Literasi Masyarakat (IPLM) merupakan alat ukur yang digunakan untuk menilai perkembangan literasi di Kota Bandung. Survei ini bertujuan untuk mengumpulkan data yang mendalam tentang akses, kualitas, dan sebaran literasi masyarakat di berbagai aspek, mulai dari literasi dasar hingga literasi digital.
                </p>
                <p class="text-secondary">
                    Melalui data ini, kami berupaya merancang kebijakan yang lebih efektif dalam meningkatkan kualitas literasi di Kota Bandung. Dengan informasi yang terkumpul, kami dapat mengidentifikasi tantangan dan peluang yang ada, serta menciptakan program-program yang relevan dan tepat sasaran.
                </p>
            </div>
        </div>

        <!-- Card metodologi -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm p-4">
                    <div class="card-body">
                        <h3 class="card-title fw-semibold text-dark mb-3">
                            <i class="bi bi-bar-chart-fill text-primary me-2"></i> Metodologi
                        </h3>
                        <p class="text-secondary">
                            Untuk mendapatkan data yang valid dan dapat diandalkan, kami menggunakan metodologi survei yang melibatkan berbagai metode pengumpulan data, termasuk wawancara, kuesioner online, dan pengamatan langsung. Responden dipilih secara acak dari berbagai lapisan masyarakat di Kota Bandung, mencakup semua kelompok usia dan latar belakang sosial ekonomi.
                        </p>
                        <p class="text-secondary">
                            Data yang dikumpulkan akan dianalisis secara menyeluruh untuk memberikan gambaran yang jelas mengenai tingkat literasi di berbagai aspek. Hasil analisis ini akan digunakan untuk merumuskan kebijakan yang mendukung peningkatan literasi, dengan fokus pada peningkatan akses terhadap sumber daya pendidikan, pelatihan keterampilan digital, dan peningkatan kesadaran masyarakat akan pentingnya literasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
