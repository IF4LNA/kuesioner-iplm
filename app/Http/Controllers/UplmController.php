<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\JenisPerpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Uplm1Export;
use App\Exports\Uplm2Export;
use App\Exports\Uplm3Export;
use App\Exports\Uplm4Export;
use App\Exports\Uplm5Export;
use App\Exports\Uplm6Export;
use App\Exports\Uplm7Export;
use App\Exports\UplmPdfExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class UplmController extends Controller
{
    
    public function filterUplm(Request $request, $id)
    {
        $viewName = 'admin.uplm' . $id;

        // Query untuk data Perpustakaan
        $query = Perpustakaan::with([
            'user',
            'kelurahan.kecamatan',
            'jawaban.pertanyaan',
            'jenis'
        ]);

        // Optimasi filter dengan whereIn
        if ($request->filled('jenis')) {
            $jenisIds = JenisPerpustakaan::where('jenis', $request->jenis)
                ->pluck('id_jenis');
            $query->whereIn('id_jenis', $jenisIds);
        }

        if ($request->filled('subjenis')) {
            $subjenisIds = JenisPerpustakaan::where('subjenis', $request->subjenis)
                ->pluck('id_jenis');
            $query->whereIn('id_jenis', $subjenisIds);
        }

        // Optimasi pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perpustakaan', 'like', "%$search%")
                    ->orWhere('npp', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%");
            });
        }

        // Sorting
        $sortField = $request->input('sortField', 'created_at');
        $sortOrder = $request->input('sortOrder', 'asc');
        $query->orderBy($sortField, $sortOrder);

        // Pagination
        $perPage = $request->input('perPage', 10); // Default 10 data per halaman
        $data = $query->paginate($perPage);

        // Filter pertanyaan berdasarkan tahun
        $pertanyaanQuery = Pertanyaan::where('kategori', 'UPLM ' . $id);

        // Jika tahun dipilih di filter, gunakan tahun tersebut
        if ($request->has('tahun') && $request->tahun != '') {
            $selectedYear = $request->tahun;
            $pertanyaanQuery->where('tahun', $selectedYear);
        } else {
            // Jika tidak, gunakan tahun terbaru
            $selectedYear = Pertanyaan::where('kategori', 'UPLM ' . $id)->max('tahun');
            $pertanyaanQuery->where('tahun', $selectedYear);
        }

        $pertanyaan = $pertanyaanQuery->get();

        // Ambil daftar tahun unik, jenis, dan subjenis
        $years = Pertanyaan::select('tahun')->distinct()->pluck('tahun');
        $jenisList = JenisPerpustakaan::select('jenis')->distinct()->pluck('jenis');
        $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

        return view($viewName, compact('data', 'pertanyaan', 'id', 'years', 'jenisList', 'subjenisList', 'selectedYear'));
    }

    public function editJawaban($id, Jawaban $jawaban)
    {
        // Ambil nama perpustakaan melalui relasi
        $namaPerpustakaan = $jawaban->perpustakaan->nama_perpustakaan;

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Edit Jawaban',
            'description' => 'Admin edit jawaban ' . $namaPerpustakaan,
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        return view('admin.jawaban_edit', compact('id', 'jawaban'));
    }

    public function updateJawaban(Request $request, $id, Jawaban $jawaban)
    {
        $request->validate([
            'jawaban' => 'required|string|max:255',
        ]);

        $jawaban->update([
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('uplm', $id)->with('success', 'Jawaban berhasil diperbarui.');
    }

    public function deleteJawaban($id, Jawaban $jawaban)
    {
        $namaPerpustakaan = $jawaban->perpustakaan->nama_perpustakaan;
        $jawaban->delete();

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Delete Jawaban',
            'description' => 'Admin menghapus jawaban ' . $namaPerpustakaan,
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        return redirect()->route('uplm', $id)->with('success', 'Jawaban berhasil dihapus.');
    }

    public function exportExcel($id)
    {
        // Mendapatkan parameter filter dari request
        $jenis = request()->get('jenis');
        $subjenis = request()->get('subjenis');
        $tahun = request()->get('tahun');
        $perPage = request()->get('perPage', 10); // Ambil nilai perPage dari request, default 10
        $page = request()->get('page', 1); // Ambil nilai page dari request, default 1

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Export Excel',
            'description' => "Admin mengekspor data UPLM {$id} ke Excel dengan filter:\n"
                . "- Jenis: {$jenis}\n"
                . "- Subjenis: {$subjenis}\n"
                . "- Tahun: {$tahun}\n"
                . "- Per Page: {$perPage}\n"
                . "- Page: {$page}",
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        // Mengirim parameter filter ke UplmExport berdasarkan ID
        $exports = [
            1 => Uplm1Export::class,
            2 => Uplm2Export::class,
            3 => Uplm3Export::class,
            4 => Uplm4Export::class,
            5 => Uplm5Export::class,
            6 => Uplm6Export::class,
            7 => Uplm7Export::class,
        ];

        if (!isset($exports[$id])) {
            return abort(404, 'Export not found');
        }

        // Teruskan perPage dan page ke kelas ekspor
        return Excel::download(new $exports[$id]($jenis, $subjenis, $tahun, $page, $perPage), "uplm{$id}_data.xlsx");
    }

    public function exportUplmPdf($id, Request $request, $kategori)
    {
        $jenis = $request->get('jenis');
        $subjenis = $request->get('subjenis');
        $tahun = $request->get('tahun');
        $perPage = $request->get('perPage', 10); // Default 10 jika tidak ada request
        $page = $request->get('page', 1); // Default halaman 1

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Export PDF',
            'description' => "Admin mengekspor data UPLM {$id} ke Pdf dengan filter:\n"
                . "- Jenis: {$jenis}\n"
                . "- Subjenis: {$subjenis}\n"
                . "- Tahun: {$tahun}\n"
                . "- Entries: {$perPage}",
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        // Menentukan kelas export berdasarkan kategori
        $exportClass = 'App\\Exports\\Uplm' . $kategori . 'PdfExport';

        if (!class_exists($exportClass)) {
            return response()->json(['error' => 'Kategori tidak valid'], 404);
        }

        // Kirim nilai perPage dan page ke class export
        $export = new $exportClass($jenis, $subjenis, $tahun, $page, $perPage);
        return $export->downloadPdf();
    }
}
