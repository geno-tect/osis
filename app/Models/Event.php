<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'description',
        'status',
        'status_tone',
        'detail',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
        ];
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('start_date', '>=', today())->orderBy('start_date');
    }
}
