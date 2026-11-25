<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'slug' => 'class-meeting-satu-pekan-satu-cerita',
                'kategori' => 'Kegiatan',
                'tanggal' => '2026-11-18',
                'judul' => 'Class meeting: satu pekan, satu cerita',
                'ringkasan' => 'Tiga hari penuh pertandingan, sorak kelas, dan kerja panitia yang rapi. Ini catatan singkat dari lapangan.',
                'gambar' => 'img/gambar-1.jpeg',
                'isi' => [
                    'Lapangan sekolah berubah jadi arena selama tiga hari. Ada turnamen futsal, voli, dan estafet yang membuat kelas saling menyemangati dari pinggir lapangan.',
                    'Panitia dari sekbid olahraga menyiapkan jadwal pertandingan dan papan skor. Beberapa siswa dari kelas lain ikut membantu menjaga ketertiban dan membagikan air minum.',
                    'Catatan ini adalah contoh liputan untuk pratinjau desain. Ganti dengan hasil wawancara dan dokumentasi resmi panitia.',
                ],
            ],
            [
                'slug' => 'hari-guru-ruang-untuk-berterima-kasih',
                'kategori' => 'Sekolah',
                'tanggal' => '2026-11-16',
                'judul' => 'Hari Guru: ruang untuk berterima kasih',
                'ringkasan' => 'Pesan singkat dari siswa, mading bertuliskan tangan, dan foto bersama di taman sekolah.',
                'gambar' => 'img/gambar-2.jpeg',
                'isi' => [
                    'Pagi dimulai dengan upacara singkat dan pesan dari perwakilan siswa. Setelah itu, kelas-kelas menyiapkan kejutan kecil untuk guru wali kelas.',
                    'Mading di koridor diisi tulisan tangan siswa. Ada juga sesi foto bersama di taman sekolah yang berlangsung sampai jam istirahat.',
                    'Liputan ini masih contoh dan perlu dilengkapi dengan nama narasumber serta dokumentasi asli.',
                ],
            ],
            [
                'slug' => 'bakti-sosial-dari-kelas-ke-lingkungan-sekitar',
                'kategori' => 'Sosial',
                'tanggal' => '2026-11-09',
                'judul' => 'Bakti sosial: dari kelas ke lingkungan sekitar',
                'ringkasan' => 'Buku, alat tulis, dan waktu siswa dikumpulkan untuk satu tujuan yang sama.',
                'gambar' => 'img/gambar-3.jpeg',
                'isi' => [
                    'Kegiatan dimulai dari pengumpulan buku dan alat tulis di setiap kelas. Hasilnya dirapikan oleh panitia sebelum diserahkan ke perpustakaan sekolah.',
                    'Siswa dari beberapa sekbid bekerja bersama menyortir sumbangan dan mengecek kondisi barang. Kegiatan berlangsung di aula pada Sabtu pagi.',
                    'Teks ini adalah contoh untuk pratinjau desain. Ganti dengan data dan dokumentasi kegiatan yang sebenarnya.',
                ],
            ],
        ];

        foreach ($articles as $article) {
            Berita::query()->firstOrCreate(
                ['slug' => $article['slug']],
                [
                    'kategori' => $article['kategori'],
                    'tanggal' => $article['tanggal'],
                    'judul' => $article['judul'],
                    'ringkasan' => $article['ringkasan'],
                    'gambar' => $article['gambar'],
                    'isi' => $article['isi'],
                ],
            );
        }
    }
}
