<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Dashboard;
use App\Livewire\master\MasterPegawai;
use App\Livewire\master\MasterKelas;
use App\Livewire\master\MasterTahunAjar;
use App\Livewire\master\MasterKurikulum;
use App\Livewire\master\MasterMapel;
use App\Livewire\master\MasterJenjang;

Route::middleware('guest')->group(function () {
    // Halaman login
    Route::get('/', [AuthController::class, 'index'])->name('login');

    // Proses login
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', Dashboard::class)->name('dashboard');
    Route::livewire('/master-pegawai', MasterPegawai::class)->name('pegawai.index');
    Route::livewire('/master-kelas', MasterKelas::class)->name('kelas.index');
    Route::livewire('/master-tahun-ajar', MasterTahunAjar::class)->name('tahunajar.index');
    Route::livewire('/master-kurikulum', MasterKurikulum::class)->name('kurikulum.index');
    Route::livewire('/master-mapel', MasterMapel::class)->name('mapel.index');
    Route::livewire('/master-jenjang', MasterJenjang::class)->name('jenjang.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
