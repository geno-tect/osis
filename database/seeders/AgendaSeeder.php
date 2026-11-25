<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        if (Agenda::query()->exists()) {
            return;
        }

        $events = [
            [
                'judul' => 'Musyawarah besar OSIS',
                'tanggal_mulai' => '2026-12-04',
                'deskripsi' => 'Ruang bersama untuk membahas arah kerja kabinet dan menampung usulan dari tiap kelas.',
                'status' => 'Pendaftaran dibuka',
                'warna_status' => 'amber',
                'rincian' => 'Waktu dan tempat: lapang depan.',
                'gambar' => 'img/gambar-1.jpeg',
            ],
            [
                'judul' => 'Pekan kreativitas siswa',
                'tanggal_mulai' => '2027-01-12',
                'deskripsi' => 'Pekan kegiatan seni dan olahraga antar kelas, ditutup dengan panggung karya siswa.',
                'status' => 'Segera dibuka',
                'warna_status' => 'sky',
                'rincian' => 'Waktu dan tempat: lapang baru.',
                'gambar' => 'img/gambar-2.jpeg',
            ],
            [
                'judul' => 'Bakti sosial lingkungan',
                'tanggal_mulai' => '2027-01-24',
                'deskripsi' => 'Kerja bersama membersihkan area sekolah dan mengumpulkan donasi untuk lingkungan sekitar.',
                'status' => 'Undangan',
                'warna_status' => 'slate',
                'rincian' => 'Waktu dan tempat: sekolah.',
                'gambar' => 'img/gambar-3.jpeg',
            ],
        ];

        foreach ($events as $event) {
            Agenda::query()->create($event);
        }
    }
}
