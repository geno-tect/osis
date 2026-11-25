<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Osis extends Model
{
    public const SEKBID_OPTIONS = [
        'Keagamaan',
        'Bela Negara',
        'Akademik',
        'Seni',
        'Olahraga',
        'Organisasi',
        'Sosial',
        'Komunikasi',
        'Lingkungan',
        'Kesehatan',
    ];

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
