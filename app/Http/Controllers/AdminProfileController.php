<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure the User model is imported
use App\Models\AdminProfile;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin
     */
    public function edit()
    {
        $user = Auth::user(); // Ensure $user is an instance of the User model
        if (!$user instanceof User) {
            throw new \Exception("Authenticated user is not an instance of the User model.");
        }
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Mengupdate profil admin
     */
    public function update(Request $request)
    {
        // Logika untuk mengupdate profil
        $user = Auth::user();
    
        // Validasi input
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'nip' => 'required|numeric|unique:admin_profiles,nip,' . $user->id . ',user_id',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
    
        // Update email di tabel users
        if ($request->email) {
            $user->email = $request->email;
            if ($user instanceof User) {
                $user->save();
            } else {
                throw new \Exception("Authenticated user is not an instance of the User model.");
            }
        } else {
            return redirect()->back()->with('warning', 'Email harus diisi karena penting untuk reset password.');
        }
    
        // Update atau buat profil admin
        $adminProfile = $user->adminProfile ?? new AdminProfile();
        $adminProfile->user_id = $user->id;
        $adminProfile->nama_admin = $request->nama_admin;
        $adminProfile->nip = $request->nip;
        $adminProfile->alamat = $request->alamat;
        $adminProfile->kontak = $request->kontak;
    
        // Upload dan resize foto profil
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($adminProfile->foto) {
                $oldPhotoPath = storage_path('app/public/' . $adminProfile->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Hapus file foto lama
                }
            }
    
            // Upload foto baru
            $foto = $request->file('foto');
            $filename = 'profile_' . $user->id . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('profiles', $filename, 'public');
    
            // Resize foto menggunakan GD Library
            $this->resizeImage(storage_path('app/public/' . $path), 200, 200);
    
            // Simpan path foto baru ke database
            $adminProfile->foto = $path;
        }
    
        // Simpan perubahan profil admin
        $adminProfile->save();
    
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Fungsi untuk resize gambar menggunakan GD Library
     */
    private function resizeImage($path, $width, $height)
    {
        // Dapatkan informasi gambar
        list($originalWidth, $originalHeight, $type) = getimagesize($path);

        // Buat gambar dari file yang diupload
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($path);
                break;
            default:
                throw new \Exception("Tipe gambar tidak didukung.");
        }

        // Buat gambar baru dengan ukuran yang diinginkan
        $destination = imagecreatetruecolor($width, $height);

        // Resize gambar
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

        // Simpan gambar yang sudah di-resize
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $path);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $path);
                break;
        }

        // Hapus resource gambar dari memori
        imagedestroy($source);
        imagedestroy($destination);
    }

    
}