<?php

namespace App\Http\Controllers;

class NewsController extends Controller
{
    public function show(string $slug)
    {
        $article = collect(config('beranda.news'))->firstWhere('slug', $slug);

        abort_unless($article, 404);

        return view('berita.show', [
            'article' => $article,
            'content' => config('beranda'),
        ]);
    }
}
