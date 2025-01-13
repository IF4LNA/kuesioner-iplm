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
            'kategori' => 'required|string|max:100',
            'tahun' => 'required|integer',
        ]);

        Pertanyaan::create($request->all());

        return redirect()->route('questions.create')->with('success', 'Pertanyaan berhasil dibuat!');
    }

    public function destroy($id)
    {
        $question = Pertanyaan::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.create')->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
