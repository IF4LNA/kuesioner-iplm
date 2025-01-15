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

    public function destroy($id)
    {
        $question = Pertanyaan::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
