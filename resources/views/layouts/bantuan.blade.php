@extends('layouts.index')

@section('konten')

<!-- Bagian Bantuan -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Bantuan</h2>

            <!-- Panduan Pengisian -->
            <h3>Panduan Pengisian</h3>
            <p>
                Untuk memastikan bahwa Anda mengisi kuesioner dengan benar, kami menyediakan panduan langkah demi langkah. Anda dapat memulai dengan memilih kategori pertanyaan yang relevan dengan situasi Anda, dan memastikan semua data yang dimasukkan akurat. Pastikan Anda membaca setiap instruksi dengan teliti sebelum melanjutkan ke bagian berikutnya.
            </p>

            <!-- FAQ -->
            <h3>FAQ (Pertanyaan yang Sering Diajukan)</h3>
            <ul>
                <li><strong>Bagaimana cara mengisi kuesioner?</strong> Anda dapat mengikuti langkah-langkah panduan yang telah disediakan untuk mengisi kuesioner dengan mudah.</li>
                <li><strong>Apa yang harus saya lakukan jika saya tidak bisa mengakses kuesioner?</strong> Pastikan Anda memiliki koneksi internet yang stabil dan menggunakan perangkat yang mendukung pengisian kuesioner online.</li>
                <li><strong>Apa yang terjadi jika saya mengisi data yang salah?</strong> Anda dapat mengedit data yang telah Anda masukkan sebelum mengirimkan kuesioner, pastikan untuk memeriksa kembali semua informasi yang Anda isi.</li>
            </ul>

            <!-- Dukungan Teknis -->
            <h3>Dukungan Teknis</h3>
            <p>
                Apabila Anda mengalami kendala teknis, seperti masalah dalam login atau pengisian kuesioner, silakan hubungi tim dukungan kami melalui formulir kontak atau nomor yang tertera pada halaman ini. Kami siap membantu Anda mengatasi masalah teknis secepat mungkin.
            </p>
            {{-- <a href="tel:+6281234567890" class="btn btn-primary">Hubungi Tim Dukungan</a> --}}
        </div>
    </div>
</div>

@endsection
