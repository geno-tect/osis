<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->date('start_date');
            $table->text('description');
            $table->string('status', 50);
            $table->string('status_tone', 20)->default('sky');
            $table->text('detail')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index('start_date');
        });

        $now = now();
        $events = collect(config('beranda.events', []))->map(function (array $event) use ($now) {
            return [
                'title' => $event['title'],
                'start_date' => $event['date_iso'],
                'description' => $event['description'],
                'status' => $event['status'],
                'status_tone' => $event['status_tone'] ?? 'sky',
                'detail' => $event['detail'] ?? null,
                'image' => $event['image'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if ($events !== []) {
            DB::table('events')->insert($events);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
