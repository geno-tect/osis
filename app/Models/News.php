<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'slug',
        'category',
        'date',
        'title',
        'excerpt',
        'image',
        'body',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'body' => 'array',
        ];
    }
}
