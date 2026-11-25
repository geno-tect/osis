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

        $events = collect(config('beranda.events', []))->map(function (array $event) {
            return [
                'judul' => $event['title'],
                'tanggal_mulai' => $event['date_iso'],
                'deskripsi' => $event['description'],
                'status' => $event['status'],
                'warna_status' => $event['status_tone'] ?? 'sky',
                'rincian' => $event['detail'] ?? null,
                'gambar' => $event['image'] ?? null,
            ];
        });

        foreach ($events as $event) {
            Agenda::query()->create($event);
        }
    }
}
