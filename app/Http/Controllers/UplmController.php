<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perpustakaan;
use App\Models\JenisPerpustakaan;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UplmExport;
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
    // Halaman UPLM
    public function showUplm($id)
    {
        $viewName = 'admin.uplm' . $id;
        $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->paginate(10); // Paginasi 10 data per halaman
        $pertanyaan = collect(); // Default data kosong
        $jawaban = collect(); // Default data kosong

        switch ($id) {
            case 1:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 1')->get();
                break;
            case 2:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 2')->get();
                break;
            case 3:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 3')->get();
                break;
            case 4:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 4')->get();
                break;
            case 5:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 5')->get();
                break;
            case 6:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 6')->get();
                break;
            case 7:
                $pertanyaan = Pertanyaan::where('kategori', 'UPLM 7')->get();
                break;
            default:
                return abort(404, 'Page not found');
        }

        // Cek apakah view ada
        if (view()->exists($viewName)) {
            return view($viewName, compact('data', 'pertanyaan', 'jawaban'));
        } else {
            return abort(404, 'Page not found');
        }
    }

    public function filterUplm(Request $request, $id)
{
    $viewName = 'admin.uplm' . $id;

    // Query untuk data Perpustakaan
    $query = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan']);

    // Filter berdasarkan jenis
    if ($request->has('jenis') && $request->jenis != '') {
        $query->whereHas('jenis', function ($q) use ($request) {
            $q->where('jenis', $request->jenis);
        });
    }

    // Filter berdasarkan subjenis
    if ($request->has('subjenis') && $request->subjenis != '') {
        $query->whereHas('jenis', function ($q) use ($request) {
            $q->where('subjenis', $request->subjenis);
        });
    }

    // Fitur pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('nama_perpustakaan', 'like', '%' . $search . '%')
              ->orWhere('npp', 'like', '%' . $search . '%')
              ->orWhere('alamat', 'like', '%' . $search . '%');
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

        // $data = JenisPerpustakaan::where('jenis', $jenis)
        //     ->where('subjenis', $subjenis)
        //     ->whereYear('created_at', $tahun)
        //     ->get();


        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Export Excel',
            'description' => "Admin mengekspor data UPLM {$id} ke Excel dengan filter:\n"
                . "- Jenis: {$jenis}\n"
                . "- Subjenis: {$subjenis}\n"
                . "- Tahun: {$tahun}",
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        // Mengirim parameter filter ke UplmExport berdasarkan ID
        switch ($id) {
            case 1:
                // Mengirim parameter filter ke UplmExport
                return Excel::download(new UplmExport($jenis, $subjenis, $tahun), 'uplm1_data.xlsx');
            case 2:
                return Excel::download(new Uplm2Export($jenis, $subjenis, $tahun), 'uplm2_data.xlsx');
            case 3:
                return Excel::download(new Uplm3Export($jenis, $subjenis, $tahun), 'uplm3_data.xlsx');
            case 4:
                return Excel::download(new Uplm4Export($jenis, $subjenis, $tahun), 'uplm4_data.xlsx');
            case 5:
                return Excel::download(new Uplm5Export($jenis, $subjenis, $tahun), 'uplm5_data.xlsx');
            case 6:
                return Excel::download(new Uplm6Export($jenis, $subjenis, $tahun), 'uplm6_data.xlsx');
            case 7:
                return Excel::download(new Uplm7Export($jenis, $subjenis, $tahun), 'uplm7_data.xlsx');
            default:
                return abort(404, 'Export not found');
        }
    }

    // Export PDF UPLM 1
    public function exportPdf($id)
    {
        $jenis = request()->get('jenis');
        $subjenis = request()->get('subjenis');
        $tahun = request()->get('tahun');

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Export PDF',
            'description' => "Admin mengekspor data UPLM {$id} ke Pdf dengan filter:\n"
                . "- Jenis: {$jenis}\n"
                . "- Subjenis: {$subjenis}\n"
                . "- Tahun: {$tahun}",
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        $data = new UplmPdfExport($jenis, $subjenis, $tahun);
        $pdf = Pdf::loadView('admin.uplm_pdf', [
            'data' => $data->view()->getData()['data'],
            'headings' => $data->view()->getData()['headings']
        ]);

        return $pdf->download('uplm1-report.pdf');
    }


    // Export PDF UPLM 2-7
    public function exportUplmPdf($id, Request $request, $kategori)
    {
        $jenis = $request->get('jenis');
        $subjenis = $request->get('subjenis');
        $tahun = $request->get('tahun');

        // Simpan log aktivitas
        ActivityLog::create([
            'action'      => 'Export PDF',
            'description' => "Admin mengekspor data UPLM {$id} ke Pdf dengan filter:\n"
            . "- Jenis: {$jenis}\n"
            . "- Subjenis: {$subjenis}\n"
            . "- Tahun: {$tahun}",
            'id_akun'     => auth()->user()->id,
            'created_at'  => now(),
        ]);

        // Menentukan kelas export berdasarkan kategori
        $exportClass = 'App\\Exports\\Uplm' . $kategori . 'PdfExport';

        if (!class_exists($exportClass)) {
            return response()->json(['error' => 'Kategori tidak valid'], 404);
        }

        $export = new $exportClass($jenis, $subjenis, $tahun);
        return $export->downloadPdf();
    }
}
