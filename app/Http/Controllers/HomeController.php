<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\Osis;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $osisList = Schema::hasTable('osis')
            ? Osis::orderBy('nama')->get()
            : collect();
        $agendaList = Schema::hasTable('events')
            ? Event::upcoming()->get()
            : collect();
        $newsList = Schema::hasTable('news')
            ? News::query()->orderByDesc('date')->get()
            : collect();

        return view('beranda', [
            'content' => config('beranda'),
            'osisList' => $osisList,
            'agendaList' => $agendaList,
            'newsList' => $newsList,
        ]);
    }
}
