<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaAdminController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\OsisController;
use App\Http\Controllers\ProfileController;
use App\Models\Agenda;
use App\Models\Aspirasi;
use App\Models\Berita;
use App\Models\Osis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');
Route::post('/aspirasi', [AspirasiController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('aspirasi.store');

Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/osis', fn () => redirect('/#anggota'));

Route::get('/dashboard', function (Request $request) {
    if (! $request->user()->isAdmin()) {
        return redirect()->route('beranda');
    }

    return view('dashboard', [
        'totalAnggota' => Osis::count(),
        'totalSekbid' => Osis::query()->distinct()->count('sekbid'),
        'anggotaList' => Osis::latest()->get(),
        'agendaList' => Agenda::query()->orderByDesc('tanggal_mulai')->get(),
        'totalAgendaMendatang' => Agenda::upcoming()->count(),
        'beritaList' => Berita::query()->orderByDesc('tanggal')->get(),
        'aspirasiList' => Aspirasi::query()->latest()->get(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/berita/create', [BeritaAdminController::class, 'create'])->name('berita.create');
    Route::post('/dashboard/berita', [BeritaAdminController::class, 'store'])->name('berita.store');
    Route::get('/dashboard/berita/{berita}/edit', [BeritaAdminController::class, 'edit'])->name('berita.edit');
    Route::put('/dashboard/berita/{berita}', [BeritaAdminController::class, 'update'])->name('berita.update');
    Route::delete('/dashboard/berita/{berita}', [BeritaAdminController::class, 'destroy'])->name('berita.destroy');

    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/agenda/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');

    Route::get('/osis/create', [OsisController::class, 'create'])->name('osis.create');
    Route::post('/osis', [OsisController::class, 'store'])->name('osis.store');
    Route::get('/osis/{id}/edit', [OsisController::class, 'edit'])->name('osis.edit');
    Route::put('/osis/{id}', [OsisController::class, 'update'])->name('osis.update');
    Route::delete('/osis/{id}', [OsisController::class, 'destroy'])->name('osis.destroy');
});

require __DIR__.'/auth.php';
