<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Osis extends Model
{
    protected $table = 'osis';

    protected $fillable = [
        'id_osis',
        'nama',
        'kelas',
        'jurusan',
        'sekbid',
        'jabatan',
        'foto',
    ];
}
