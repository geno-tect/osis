<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->ubahKolom('agenda', [
            'title' => 'judul',
            'start_date' => 'tanggal_mulai',
            'description' => 'deskripsi',
            'status_tone' => 'warna_status',
            'detail' => 'rincian',
            'image' => 'gambar',
        ]);
        $this->ubahKolom('berita', [
            'category' => 'kategori',
            'date' => 'tanggal',
            'title' => 'judul',
            'excerpt' => 'ringkasan',
            'image' => 'gambar',
            'body' => 'isi',
        ]);
    }

    public function down(): void
    {
        $this->ubahKolom('berita', [
            'kategori' => 'category',
            'tanggal' => 'date',
            'judul' => 'title',
            'ringkasan' => 'excerpt',
            'gambar' => 'image',
            'isi' => 'body',
        ]);
        $this->ubahKolom('agenda', [
            'judul' => 'title',
            'tanggal_mulai' => 'start_date',
            'deskripsi' => 'description',
            'warna_status' => 'status_tone',
            'rincian' => 'detail',
            'gambar' => 'image',
        ]);
    }

    private function ubahKolom(string $tabel, array $kolom): void
    {
        if (! Schema::hasTable($tabel)) {
            return;
        }

        foreach ($kolom as $namaLama => $namaBaru) {
            if (Schema::hasColumn($tabel, $namaLama) && ! Schema::hasColumn($tabel, $namaBaru)) {
                Schema::table($tabel, fn ($table) => $table->renameColumn($namaLama, $namaBaru));
            }
        }
    }
};
