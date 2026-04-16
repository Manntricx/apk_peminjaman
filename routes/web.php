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

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('alats', \App\Http\Controllers\Admin\AlatController::class);
        Route::resource('peminjamans', \App\Http\Controllers\Admin\PeminjamanController::class);
        Route::resource('pengembalians', \App\Http\Controllers\Admin\PengembalianController::class);
        
        // Logs
        Route::get('logs', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'index'])->name('logs.index');
        Route::delete('logs/clear', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'clear'])->name('logs.clear');
    });
});

require __DIR__.'/auth.php';
