<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('beranda.news', []) as $article) {
            News::query()->firstOrCreate(
                ['slug' => $article['slug']],
                [
                    'category' => $article['category'],
                    'date' => $article['date'],
                    'title' => $article['title'],
                    'excerpt' => $article['excerpt'],
                    'image' => $article['image'] ?? null,
                    'body' => $article['body'] ?? [],
                ],
            );
        }
    }
}
