<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'aspirations' => 'aspirasi',
            'events' => 'agenda',
            'news' => 'berita',
        ] as $namaLama => $namaBaru) {
            if (Schema::hasTable($namaLama) && ! Schema::hasTable($namaBaru)) {
                Schema::rename($namaLama, $namaBaru);
            }
        }

    }

    public function down(): void
    {
        foreach ([
            'aspirasi' => 'aspirations',
            'agenda' => 'events',
            'berita' => 'news',
        ] as $namaBaru => $namaLama) {
            if (Schema::hasTable($namaBaru) && ! Schema::hasTable($namaLama)) {
                Schema::rename($namaBaru, $namaLama);
            }
        }
    }

};
