<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AspirasiController extends Controller
{
    public function index()
    {
        return view('aspirasi.index', [
            'content' => config('beranda'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => ['required', Rule::in(config('beranda.aspiration.categories'))],
            'pesan' => ['required', 'string', 'min:20', 'max:2000'],
            'nama' => ['nullable', 'string', 'max:100'],
        ], [
            'kategori.required' => 'Pilih kategori aspirasi.',
            'kategori.in' => 'Kategori yang dipilih tidak tersedia.',
            'pesan.required' => 'Tulis isi aspirasi.',
            'pesan.min' => 'Tulis minimal 20 karakter agar pesanmu jelas.',
            'pesan.max' => 'Isi aspirasi maksimal 2000 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',
        ]);

        Aspirasi::create($validated);

        return redirect()
            ->route('aspirasi.index')
            ->with('success', 'Aspirasi terkirim. Terima kasih.');
    }
}
