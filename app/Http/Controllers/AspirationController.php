<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AspirationController extends Controller
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

        Aspiration::create($validated);

        return redirect()
            ->route('aspirasi.index')
            ->with('success', 'Aspirasi terkirim. Terima kasih.');
    }
}
