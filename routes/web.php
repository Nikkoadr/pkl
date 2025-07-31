<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Guru_pembimbingController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PersertaController;
use App\Http\Controllers\Tempat_pklController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\EsertifikatController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\Auto_completeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/autocomplete/dudi', [Auto_completeController::class, 'autoCompleteDudi']);
Route::get('/autocomplete/users', [Auto_completeController::class, 'autoCompleteUser']);
Route::get('/autocomplete/guru', [Auto_completeController::class, 'autoCompleteGuru']);


Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');

Route::resource('/home/dudi', DudiController::class);
Route::resource('/home/users', UserController::class);
Route::put('/home/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

Route::resource('/home/guru', GuruController::class);

Route::resource('/home/guru_pembimbing', Guru_pembimbingController::class);
Route::resource('/home/tempat_pkl', Tempat_pklController::class);

Route::get('/home/peserta', [PersertaController::class, 'index'])->name('home.peserta');
Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/esertifikat', [EsertifikatController::class, 'index'])->name('home.esertifikat');
Route::get('/home/pengaturan', [PengaturanController::class, 'index'])->name('home.pengaturan');
