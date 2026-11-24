<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (Event::query()->exists()) {
            return;
        }

        $events = collect(config('beranda.events', []))->map(function (array $event) {
            return [
                'title' => $event['title'],
                'start_date' => $event['date_iso'],
                'description' => $event['description'],
                'status' => $event['status'],
                'status_tone' => $event['status_tone'] ?? 'sky',
                'detail' => $event['detail'] ?? null,
                'image' => $event['image'] ?? null,
            ];
        });

        foreach ($events as $event) {
            Event::query()->create($event);
        }
    }
}
