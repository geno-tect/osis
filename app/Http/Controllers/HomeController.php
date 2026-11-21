<?php

namespace App\Http\Controllers;

use App\Models\Osis;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $osisList = Schema::hasTable('osis')
            ? Osis::orderBy('nama')->get()
            : collect();

        return view('beranda', [
            'content' => config('beranda'),
            'osisList' => $osisList,
        ]);
    }
}
