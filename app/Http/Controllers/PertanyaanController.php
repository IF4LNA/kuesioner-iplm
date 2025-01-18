<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function create()
    {
        $questions = Pertanyaan::all(); // Mengambil semua pertanyaan
        return view('admin.create_question', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teks_pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|string|in:UPLM 1,UPLM 2,UPLM 3,UPLM 4,UPLM 5,UPLM 6,UPLM 7',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
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
}
