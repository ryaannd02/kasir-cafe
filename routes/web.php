<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manajer\ManajerController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Kasir\TransaksiController;
use App\Http\Controllers\Manajer\MenuController;

// -------------------- DEFAULT --------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// -------------------- AUTH --------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -------------------- ADMIN --------------------
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/log', [AdminController::class, 'log'])->name('admin.log');

    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

// -------------------- MANAJER --------------------
Route::middleware(['auth.manajer'])->group(function () {
    Route::get('/manajer/dashboard', [ManajerController::class, 'index'])->name('manajer.dashboard');

    // Menu
    Route::get('/manajer/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/manajer/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/manajer/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/manajer/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/manajer/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Laporan
    Route::get('/manajer/laporan', [ManajerController::class, 'laporan'])->name('manajer.laporan');

    // Log Aktivitas
    Route::get('/manajer/log', [ManajerController::class, 'log'])->name('manajer.log');
});

// -------------------- KASIR --------------------
Route::middleware(['auth.kasir'])->group(function () {
    Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');

    // Transaksi
    Route::get('/kasir/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/kasir/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
});