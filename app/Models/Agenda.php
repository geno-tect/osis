<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'judul',
        'tanggal_mulai',
        'deskripsi',
        'status',
        'warna_status',
        'rincian',
        'gambar',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
        ];
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('tanggal_mulai', '>=', today())->orderBy('tanggal_mulai');
    }
}
