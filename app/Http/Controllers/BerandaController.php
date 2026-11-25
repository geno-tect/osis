<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Osis;
use Illuminate\Support\Facades\Schema;

class BerandaController extends Controller
{
    public function index()
    {
        $osisList = Schema::hasTable('osis')
            ? Osis::orderBy('nama')->get()
            : collect();
        $agendaList = Schema::hasTable('agenda')
            ? Agenda::upcoming()->get()
            : collect();
        $beritaList = Schema::hasTable('berita')
            ? Berita::query()->orderByDesc('tanggal')->get()
            : collect();

        return view('beranda', [
            'content' => config('beranda'),
            'osisList' => $osisList,
            'agendaList' => $agendaList,
            'beritaList' => $beritaList,
        ]);
    }
}
