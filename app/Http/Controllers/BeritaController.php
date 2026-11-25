<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaController extends Controller
{
    public function show(string $slug)
    {
        $berita = Berita::query()->where('slug', $slug)->firstOrFail();
        $article = [
            'slug' => $berita->slug,
            'category' => $berita->kategori,
            'date' => $berita->tanggal->toDateString(),
            'date_label' => $berita->tanggal->locale('id')->translatedFormat('j F Y'),
            'title' => $berita->judul,
            'excerpt' => $berita->ringkasan,
            'image' => $berita->gambar,
            'body' => $berita->isi ?? [],
        ];

        return view('berita.detail', [
            'article' => $article,
            'content' => config('beranda'),
        ]);
    }
}
