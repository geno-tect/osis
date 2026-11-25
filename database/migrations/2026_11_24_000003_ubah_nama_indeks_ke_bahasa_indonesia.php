<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table): void {
            $table->dropIndex('events_start_date_index');
            $table->index('tanggal_mulai', 'agenda_tanggal_mulai_index');
        });

        Schema::table('berita', function (Blueprint $table): void {
            $table->dropIndex('news_date_index');
            $table->index('tanggal', 'berita_tanggal_index');
            $table->dropUnique('news_slug_unique');
            $table->unique('slug', 'berita_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table): void {
            $table->dropIndex('berita_tanggal_index');
            $table->index('tanggal', 'news_date_index');
            $table->dropUnique('berita_slug_unique');
            $table->unique('slug', 'news_slug_unique');
        });

        Schema::table('agenda', function (Blueprint $table): void {
            $table->dropIndex('agenda_tanggal_mulai_index');
            $table->index('tanggal_mulai', 'events_start_date_index');
        });
    }
};
