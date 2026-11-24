<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 180)->unique();
            $table->string('category', 80);
            $table->date('date');
            $table->string('title', 180);
            $table->text('excerpt');
            $table->string('image')->nullable();
            $table->json('body');
            $table->timestamps();

            $table->index('date');
        });

        $now = now();
        $articles = collect(config('beranda.news', []))->map(function (array $article) use ($now) {
            return [
                'slug' => $article['slug'],
                'category' => $article['category'],
                'date' => $article['date'],
                'title' => $article['title'],
                'excerpt' => $article['excerpt'],
                'image' => $article['image'] ?? null,
                'body' => json_encode($article['body'] ?? []),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if ($articles !== []) {
            DB::table('news')->insert($articles);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
