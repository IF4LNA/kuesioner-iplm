<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function create()
    {
        $questions = Pertanyaan::orderBy('tahun', 'desc')
            ->orderBy('kategori', 'asc')
            ->get(); // Mengambil semua pertanyaan dengan sorting
        
        return view('admin.create_question', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teks_pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|string|in:UPLM 1,UPLM 2,UPLM 3,UPLM 4,UPLM 5,UPLM 6,UPLM 7',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'tipe_jawaban' => 'required|string|in:text,number,radio', // Validasi untuk tipe jawaban
        ]);
    
        Pertanyaan::create($request->all());
    
        return redirect()->back()->with('success', 'Pertanyaan berhasil dibuat!');
    }

    //edit pertanyaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'teks_pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|string|in:UPLM 1,UPLM 2,UPLM 3,UPLM 4,UPLM 5,UPLM 6,UPLM 7',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'tipe_jawaban' => 'required|string|in:text,number,radio', // Validasi untuk tipe jawaban
        ]);
    
        $question = Pertanyaan::findOrFail($id);
        $question->update($request->all());
    
        return redirect()->route('questions.create')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    //edit pertanyaan berdasarkan id
    public function edit($id)
    {
        $question = Pertanyaan::findOrFail($id);
        return view('admin.edit_question', compact('question'));
    }

    //hapus pertanyaan
    public function destroy($id)
    {
        $question = Pertanyaan::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function getByYear($tahun)
{
    $questions = Pertanyaan::where('tahun', $tahun)->get();
    return response()->json($questions);
}
public function copy(Request $request)
{
    $request->validate([
        'tahun_sumber' => 'required|integer',
        'tahun_tujuan' => 'required|integer|different:tahun_sumber',
        'selected_questions' => 'required|array',
    ]);

    $tahunSumber = $request->tahun_sumber;
    $tahunTujuan = $request->tahun_tujuan;
    $selectedQuestions = $request->selected_questions;

    // Cek apakah pertanyaan sudah ada di tahun tujuan
    $existingQuestions = Pertanyaan::where('tahun', $tahunTujuan)
        ->whereIn('teks_pertanyaan', Pertanyaan::whereIn('id_pertanyaan', $selectedQuestions)->pluck('teks_pertanyaan'))
        ->exists();

    if ($existingQuestions) {
        return redirect()->back()->with('error', 'Beberapa pertanyaan sudah ada di tahun tujuan.');
    }

    // Copy pertanyaan yang dipilih
    foreach ($selectedQuestions as $id) {
        $question = Pertanyaan::findOrFail($id);
        Pertanyaan::create([
            'teks_pertanyaan' => $question->teks_pertanyaan,
            'kategori' => $question->kategori,
            'tahun' => $tahunTujuan,
            'tipe_jawaban' => $question->tipe_jawaban, // Salin tipe jawaban
        ]);
    }

    return redirect()->back()->with('success', 'Pertanyaan berhasil disalin.');
}

}
