<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Common Routes for Admin & Petugas
    Route::prefix('admin')->name('admin.')->middleware('role:admin,petugas')->group(function () {
        Route::resource('peminjamans', \App\Http\Controllers\Admin\PeminjamanController::class);
        Route::resource('pengembalians', \App\Http\Controllers\Admin\PengembalianController::class);
    });

    // Admin Only
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('alats', \App\Http\Controllers\Admin\AlatController::class);
        Route::get('logs', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'index'])->name('logs.index');
        Route::delete('logs/clear', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'clear'])->name('logs.clear');
    });

    // Petugas Only (Operational features specifically for them)
    Route::prefix('admin')->name('admin.')->middleware('role:petugas')->group(function () {
        Route::get('laporan', function() { return view('admin.laporan.index'); })->name('laporan.index');
    });
});

require __DIR__.'/auth.php';
