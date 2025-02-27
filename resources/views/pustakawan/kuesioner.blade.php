<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengisian Data Diri Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d1e0e5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .form-box {
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .container {
            margin-top: 50px;
            /* Menambahkan jarak atas */
            margin-bottom: 40px;
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        .custom-file-label i {
            margin-right: 10px;
            color: #007bff;
            /* Menambahkan warna biru pada ikon */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <form action="{{ route('pustakawan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-box">
                <h2>Form Data Responden</h2>
        
                <!-- Nama Perpustakaan -->
                <div class="mb-3">
                    <label for="nama_perpustakaan" class="form-label">Nama Perpustakaan:</label>
                    <input type="text" id="nama_perpustakaan" name="nama_perpustakaan" class="form-control"
                        value="{{ $namaPerpustakaan }}" readonly>
                </div>
        
                <!-- Jenis Perpustakaan -->
                <div class="mb-3">
                    <label for="jenis_perpustakaan" class="form-label">Jenis Perpustakaan:</label>
                    <input type="text" id="jenis_perpustakaan" name="jenis_perpustakaan" class="form-control"
                        value="{{ $jenisPerpustakaan }}" readonly>
                </div>
        
                <!-- Kota -->
                <div class="mb-3">
                    <label for="kota" class="form-label">Kota:</label>
                    <select id="kota" name="kota" class="form-select" required>
                        <option value="">Pilih Kota</option>
                        @foreach ($kotas as $kota)
                            <option value="{{ $kota->id }}" {{ $selectedKota == $kota->id ? 'selected' : '' }}>
                                {{ $kota->nama_kota }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Kecamatan -->
                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan:</label>
                    <select id="kecamatan" name="kecamatan" class="form-select" required>
                        <option value="">Pilih Kecamatan</option>
                        @if ($selectedKota)
                            @foreach (App\Models\Kecamatan::where('id_kota', $selectedKota)->get() as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ $selectedKecamatan == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama_kecamatan }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
        
                <!-- Desa/Kelurahan -->
                <div class="mb-3">
                    <label for="desa_kelurahan" class="form-label">Desa/Kelurahan:</label>
                    <select id="desa_kelurahan" name="desa_kelurahan" class="form-select" required>
                        <option value="">Pilih Desa/Kelurahan</option>
                        @if ($selectedKecamatan)
                            @foreach (App\Models\Kelurahan::where('id_kecamatan', $selectedKecamatan)->get() as $kelurahan)
                                <option value="{{ $kelurahan->id }}" {{ $selectedKelurahan == $kelurahan->id ? 'selected' : '' }}>
                                    {{ $kelurahan->nama_kelurahan }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
        
                <!-- Detail Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Detail alamat:</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $alamatPustakawan }}" required>
                </div>
        
                <!-- NPP -->
                <div class="mb-3">
                    <label for="npp" class="form-label">NPP:</label>
                    <input type="text" id="npp" name="npp" class="form-control" value="{{ $nppPustakawan }}" required>
                </div>
        
                <!-- No Telepon -->
                <div class="mb-3">
                    <label for="kontak" class="form-label">No Telepon:</label>
                    <input type="text" id="kontak" name="kontak" class="form-control" value="{{ $kontakPustakawan }}" required>
                </div>
        
                <!-- Upload Foto -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Foto Perpustakaan:</label>
        
                    @if (!empty($fotoPustakawan))
                        <div class="mb-3">
                            <img id="preview" src="{{ asset('storage/' . $fotoPustakawan) }}" 
                                alt="Foto Perpustakaan" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
        
                    <input type="hidden" id="foto_lama" name="foto_lama" value="{{ $fotoPustakawan ?? '' }}">
        
                    <div class="custom-file">
                        <input type="file" id="foto" name="foto" class="custom-file-input" accept="image/*">
                        <label for="foto" class="custom-file-label">
                            <i class="fas fa-upload"></i> Pilih File
                        </label>
                    </div>
                </div>
        
                <!-- Button Next -->
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>        
    </div>
    
    {{-- // Preview Gambar Diperbarui --}}
    <script src="{{ asset('js/script.js') }}"></script>
    
    <script>
        // Menambahkan event listener agar label berubah ketika memilih file
        document.addEventListener("DOMContentLoaded", function() {
            // Menambahkan event listener agar label berubah ketika memilih file
            document.getElementById("foto").addEventListener("change", function() {
                var fileName = this.files[0] ? this.files[0].name : "Pilih file";
                var label = this.nextElementSibling;
                label.innerHTML = '<i class="fas fa-upload"></i> ' + fileName;
            });

            // Mengambil data kecamatan berdasarkan kota
            document.getElementById("kota").addEventListener("change", function() {
                let kotaId = this.value;
                let kecamatanSelect = document.getElementById("kecamatan");
                let kelurahanSelect = document.getElementById("desa_kelurahan");

                // Reset dropdown kecamatan dan kelurahan jika kota tidak dipilih
                kecamatanSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                kelurahanSelect.innerHTML = `<option value="">Pilih Desa/Kelurahan</option>`;

                if (kotaId) {
                    fetch(`/kecamatan/${kotaId}`)
                        .then((response) => response.json())
                        .then((data) => {
                            data.forEach((kecamatan) => {
                                kecamatanSelect.innerHTML +=
                                    `<option value="${kecamatan.id}">${kecamatan.nama_kecamatan}</option>`;
                            });
                        })
                        .catch((error) => {
                            console.error("Error fetching kecamatan:", error);
                            alert("Gagal memuat data kecamatan");
                        });
                }
            });

            // Mengambil data kelurahan berdasarkan kecamatan
            document.getElementById("kecamatan").addEventListener("change", function() {
                let kecamatanId = this.value;
                let kelurahanSelect = document.getElementById("desa_kelurahan");

                // Reset dropdown kelurahan jika kecamatan tidak dipilih
                kelurahanSelect.innerHTML = `<option value="">Pilih Desa/Kelurahan</option>`;

                if (kecamatanId) {
                    fetch(`/kelurahan/${kecamatanId}`)
                        .then((response) => response.json())
                        .then((data) => {
                            data.forEach((kelurahan) => {
                                kelurahanSelect.innerHTML +=
                                    `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`;
                            });
                        })
                        .catch((error) => {
                            console.error("Error fetching kelurahan:", error);
                            alert("Gagal memuat data kelurahan");
                        });
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>

</html>
