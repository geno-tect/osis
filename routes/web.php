<?php

use App\Http\Controllers\AspirationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsAdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OsisController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use App\Models\Aspiration;
use App\Models\Osis;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('beranda');

Route::get('/aspirasi', [AspirationController::class, 'index'])->name('aspirasi.index');
Route::post('/aspirasi', [AspirationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('aspirasi.store');

Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');

Route::get('/osis', fn () => redirect('/#anggota'));

Route::get('/dashboard', function (Request $request) {
    if (! $request->user()->isAdmin()) {
        return redirect()->route('beranda');
    }

    return view('dashboard', [
        'totalAnggota' => Osis::count(),
        'totalSekbid' => Osis::query()->distinct()->count('sekbid'),
        'anggotaList' => Osis::latest()->get(),
        'agendaList' => Event::query()->orderByDesc('start_date')->get(),
        'totalAgendaMendatang' => Event::upcoming()->count(),
        'newsList' => News::query()->orderByDesc('date')->get(),
        'aspirationList' => Aspiration::query()->latest()->get(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/berita/create', [NewsAdminController::class, 'create'])->name('news.create');
    Route::post('/dashboard/berita', [NewsAdminController::class, 'store'])->name('news.store');
    Route::get('/dashboard/berita/{news}/edit', [NewsAdminController::class, 'edit'])->name('news.edit');
    Route::put('/dashboard/berita/{news}', [NewsAdminController::class, 'update'])->name('news.update');
    Route::delete('/dashboard/berita/{news}', [NewsAdminController::class, 'destroy'])->name('news.destroy');

    Route::get('/agenda/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/agenda', [EventController::class, 'store'])->name('events.store');
    Route::get('/agenda/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/agenda/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/agenda/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/osis/create', [OsisController::class, 'create'])->name('osis.create');
    Route::post('/osis', [OsisController::class, 'store'])->name('osis.store');
    Route::get('/osis/{id}/edit', [OsisController::class, 'edit'])->name('osis.edit');
    Route::put('/osis/{id}', [OsisController::class, 'update'])->name('osis.update');
    Route::delete('/osis/{id}', [OsisController::class, 'destroy'])->name('osis.destroy');
});

require __DIR__.'/auth.php';
