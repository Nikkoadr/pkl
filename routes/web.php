<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PersertaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\EsertifikatController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/autocomplete/dudi', [RegisterController::class, 'autoCompleteDudi'])->name('autocomplete.dudi');

Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
Route::resource('/home/dudi', \App\Http\Controllers\DudiController::class);
Route::get('/home/guru', [GuruController::class, 'index'])->name('home.guru');
Route::get('/home/peserta', [PersertaController::class, 'index'])->name('home.peserta');
Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/esertifikat', [EsertifikatController::class, 'index'])->name('home.esertifikat');
Route::get('/home/pengaturan', [PengaturanController::class, 'index'])->name('home.pengaturan');
