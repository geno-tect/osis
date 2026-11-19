<?php

use App\Http\Controllers\OsisController;
use App\Http\Controllers\ProfileController;
use App\Models\Osis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    if (! $request->user()->isAdmin()) {
        return redirect()->route('osis.index');
    }

    return view('dashboard', [
        'totalAnggota' => Osis::count(),
        'totalSekbid' => Osis::query()->distinct()->count('sekbid'),
        'anggotaTerbaru' => Osis::latest()->take(5)->get(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/osis', [OsisController::class, 'index'])->name('osis.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/osis/create', [OsisController::class, 'create'])->name('osis.create');
    Route::post('/osis', [OsisController::class, 'store'])->name('osis.store');
    Route::get('/osis/{id}/edit', [OsisController::class, 'edit'])->name('osis.edit');
    Route::put('/osis/{id}', [OsisController::class, 'update'])->name('osis.update');
    Route::delete('/osis/{id}', [OsisController::class, 'destroy'])->name('osis.destroy');
});

require __DIR__.'/auth.php';
