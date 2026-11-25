<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'slug',
        'kategori',
        'tanggal',
        'judul',
        'ringkasan',
        'gambar',
        'isi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'isi' => 'array',
        ];
    }
}
