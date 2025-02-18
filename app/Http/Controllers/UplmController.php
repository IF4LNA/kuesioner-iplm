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
use Illuminate\Support\Facades\DB;

class UplmController extends Controller
{
    // Halaman UPLM
    public function showUplm($id)
    {
        $viewName = 'admin.uplm' . $id;
        $data = Perpustakaan::with(['user', 'kelurahan.kecamatan', 'jawaban.pertanyaan'])->get();
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

        if ($request->has('jenis') && $request->jenis != '') {
            $query->whereHas('jenis', function ($q) use ($request) {
                $q->where('jenis', $request->jenis);
            });
        }

        if ($request->has('subjenis') && $request->subjenis != '') {
            $query->whereHas('jenis', function ($q) use ($request) {
                $q->where('subjenis', $request->subjenis);
            });
        }

        // Tambahkan logika untuk sorting
        $sortField = $request->input('sortField', 'created_at'); // Default sort by 'created_at' (tahun)
        $sortOrder = $request->input('sortOrder', 'asc'); // Default sort order
        $query->orderBy($sortField, $sortOrder);

        $data = $query->get();

        // Filter pertanyaan berdasarkan tahun
        $pertanyaanQuery = Pertanyaan::where('kategori', 'UPLM ' . $id);
        if ($request->has('tahun') && $request->tahun != '') {
            $pertanyaanQuery->where('tahun', $request->tahun);
        }
        $pertanyaan = $pertanyaanQuery->get();

        // Ambil daftar tahun unik dari kolom 'tahun' di tabel 'pertanyaan'
        $years = Pertanyaan::select('tahun')->distinct()->pluck('tahun');

        // Ambil daftar jenis dan subjenis dari tabel jenis_perpustakaans
        $jenisList = JenisPerpustakaan::select('jenis')->distinct()->pluck('jenis');
        $subjenisList = JenisPerpustakaan::select('subjenis')->distinct()->pluck('subjenis');

        return view($viewName, compact('data', 'pertanyaan', 'id', 'years', 'jenisList', 'subjenisList'));
    }

    public function editJawaban($id, Jawaban $jawaban)
    {
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
        $jawaban->delete();
        return redirect()->route('uplm', $id)->with('success', 'Jawaban berhasil dihapus.');
    }

    public function exportExcel($id)
    {
        // Mendapatkan parameter filter dari request
        $jenis = request()->get('jenis');
        $subjenis = request()->get('subjenis');
        $tahun = request()->get('tahun');

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
}
