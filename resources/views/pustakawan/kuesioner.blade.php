<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengisian Data Diri Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menambahkan Font Awesome -->
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
            color: #007bff; /* Menambahkan warna biru pada ikon */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Form Box -->
            <div class="form-box">
                <h2>Form Data Responden</h2>

                <!-- Nama Perpustakaan -->
                <div class="mb-3">
                    <label for="nama_perpustakaan" class="form-label">Nama Perpustakaan:</label>
                    <input type="text" id="nama_perpustakaan" name="nama_perpustakaan" class="form-control" required>
                </div>

                <!-- Jenis Perpustakaan -->
                <div class="mb-3">
                    <label for="jenis_perpustakaan" class="form-label">Jenis Perpustakaan:</label>
                    <select id="jenis_perpustakaan" name="jenis_perpustakaan" class="form-select" required>
                        <option value="">Pilih Jenis Perpustakaan</option>
                        <option value="umum">Perpustakaan Umum</option>
                        <option value="sekolah">Perpustakaan Sekolah</option>
                        <option value="kampus">Perpustakaan Kampus</option>
                    </select>
                </div>

                <!-- Kota -->
                <div class="mb-3">
                    <label for="kota" class="form-label">Kota:</label>
                    <select id="kota" name="kota" class="form-select" required>
                        <option value="">Pilih Kota</option>
                        <option value="Bandung">Bandung</option>
                    </select>
                </div>

                <!-- Kecamatan -->
                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan:</label>
                    <select id="kecamatan" name="kecamatan" class="form-select" required>
                        <option value="">Pilih Kecamatan</option>
                        <option value="Kecamatan 1">Kecamatan 1</option>
                        <option value="Kecamatan 2">Kecamatan 2</option>
                        <option value="Kecamatan 3">Kecamatan 3</option>
                    </select>
                </div>

                <!-- Desa/Kelurahan -->
                <div class="mb-3">
                    <label for="desa_kelurahan" class="form-label">Desa/Kelurahan:</label>
                    <select id="desa_kelurahan" name="desa_kelurahan" class="form-select" required>
                        <option value="">Pilih Desa/Kelurahan</option>
                        <option value="Desa 1">Desa 1</option>
                        <option value="Desa 2">Desa 2</option>
                        <option value="Desa 3">Desa 3</option>
                    </select>
                </div>

                <!-- NPP -->
                <div class="mb-3">
                    <label for="npp" class="form-label">NPP:</label>
                    <input type="text" id="npp" name="npp" class="form-control" required>
                </div>

                <!-- No Telpon -->
                <div class="mb-3">
                    <label for="no_telpon" class="form-label">No Telepon:</label>
                    <input type="text" id="no_telpon" name="no_telpon" class="form-control" required>
                </div>

                <!-- Upload Foto -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Foto:</label>
                    <div class="custom-file">
                        <input type="file" id="foto" name="foto" class="custom-file-input" accept="image/*" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menambahkan event listener agar label berubah ketika memilih file
        document.getElementById('foto').addEventListener('change', function () {
            var fileName = this.files[0].name;
            var label = this.nextElementSibling;
            label.innerHTML = '<i class="fas fa-upload"></i> ' + fileName;
        });
    </script>
</body>
</html>
