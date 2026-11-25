<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('beranda.news', []) as $article) {
            Berita::query()->firstOrCreate(
                ['slug' => $article['slug']],
                [
                    'kategori' => $article['category'],
                    'tanggal' => $article['date'],
                    'judul' => $article['title'],
                    'ringkasan' => $article['excerpt'],
                    'gambar' => $article['image'] ?? null,
                    'isi' => $article['body'] ?? [],
                ],
            );
        }
    }
}
