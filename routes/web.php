<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'peminjam') {
        return redirect()->route('peminjam.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================================================
    // ADMIN — Full CRUD + Logs
    // ============================================================
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('alats', \App\Http\Controllers\Admin\AlatController::class);
        Route::resource('peminjamans', \App\Http\Controllers\Admin\PeminjamanController::class);
        Route::post('peminjamans/{peminjaman}/approve', [\App\Http\Controllers\Admin\PeminjamanController::class, 'approve'])->name('peminjamans.approve');
        Route::resource('pengembalians', \App\Http\Controllers\Admin\PengembalianController::class);
        Route::get('logs', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'index'])->name('logs.index');
        Route::delete('logs/clear', [\App\Http\Controllers\Admin\LogAktifitasController::class, 'clear'])->name('logs.clear');
    });

    // ============================================================
    // PETUGAS — Approve Peminjaman, Pantau Pengembalian, Laporan, Log
    // ============================================================
    Route::prefix('petugas')->name('petugas.')->middleware('role:petugas')->group(function () {
        // Menyetujui Peminjaman (list + detail + approve action)
        Route::get('peminjamans', [\App\Http\Controllers\Petugas\PeminjamanController::class, 'index'])->name('peminjamans.index');
        Route::get('peminjamans/{peminjaman}', [\App\Http\Controllers\Petugas\PeminjamanController::class, 'show'])->name('peminjamans.show');
        Route::post('peminjamans/{peminjaman}/approve', [\App\Http\Controllers\Petugas\PeminjamanController::class, 'approve'])->name('peminjamans.approve');
        Route::post('peminjamans/{peminjaman}/reject', [\App\Http\Controllers\Petugas\PeminjamanController::class, 'reject'])->name('peminjamans.reject');
        
        // Memantau Pengembalian (list + detail + process return)
        Route::get('pengembalians', [\App\Http\Controllers\Petugas\PengembalianController::class, 'index'])->name('pengembalians.index');
        Route::get('pengembalians/{pengembalian}', [\App\Http\Controllers\Petugas\PengembalianController::class, 'show'])->name('pengembalians.show');
        Route::post('pengembalians', [\App\Http\Controllers\Petugas\PengembalianController::class, 'store'])->name('pengembalians.store');
        
        // Mencetak Laporan
        Route::get('laporan', [\App\Http\Controllers\Petugas\LaporanController::class, 'index'])->name('laporan.index');
    });

    // ============================================================
    // PEMINJAM — Landing portal with dedicated controller
    // ============================================================
    Route::prefix('peminjam')->name('peminjam.')->middleware('role:peminjam')->group(function () {
        Route::get('/', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'dashboard'])->name('dashboard');
        Route::get('alats', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'alats'])->name('alats');
        Route::get('peminjamans', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'peminjamansIndex'])->name('peminjamans.index');
        Route::get('peminjamans/create', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'peminjamansCreate'])->name('peminjamans.create');
        Route::post('peminjamans', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'peminjamansStore'])->name('peminjamans.store');
        Route::get('pengembalians', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'pengembalianIndex'])->name('pengembalians.index');
        Route::post('pengembalians', [\App\Http\Controllers\Peminjam\PeminjamController::class, 'pengembalianStore'])->name('pengembalians.store');
    });
});

require __DIR__.'/auth.php';

