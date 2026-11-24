<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function show(string $slug)
    {
        $news = News::query()->where('slug', $slug)->firstOrFail();
        $article = [
            'slug' => $news->slug,
            'category' => $news->category,
            'date' => $news->date->toDateString(),
            'date_label' => $news->date->locale('id')->translatedFormat('j F Y'),
            'title' => $news->title,
            'excerpt' => $news->excerpt,
            'image' => $news->image,
            'body' => $news->body ?? [],
        ];

        return view('berita.show', [
            'article' => $article,
            'content' => config('beranda'),
        ]);
    }
}
