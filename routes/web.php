<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\MasterPegawai;
use App\Livewire\Dashboard;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', Dashboard::class)->name('dashboard');
    Route::livewire('/master-pegawai', MasterPegawai::class)->name('pegawai.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
