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
use App\Http\Controllers\Tahun_ajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\NilaiController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// ==============================
// 🔎 Autocomplete
// ==============================
Route::prefix('autocomplete')->group(function () {
    Route::get('/dudi', [Auto_completeController::class, 'autoCompleteDudi']);
    Route::get('/users', [Auto_completeController::class, 'autoCompleteUser']);
    Route::get('/guru', [Auto_completeController::class, 'autoCompleteGuru']);
    Route::get('/guru_pembimbing', [Auto_completeController::class, 'autoCompleteGuruPembimbing']);
    Route::get('/peserta', [Auto_completeController::class, 'autoCompletePeserta']);
});

// ==============================
// 🏠 Dashboard & Umum
// ==============================
Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');

// ==============================
// 📚 Master Data
// ==============================
Route::resource('/home/tahun_ajaran', Tahun_ajaranController::class);
Route::resource('/home/kelas', KelasController::class);
Route::resource('/home/users', UserController::class);
Route::resource('/home/dudi', DudiController::class);
Route::resource('/home/guru', GuruController::class);
Route::resource('/home/peserta', PersertaController::class);
Route::resource('/home/guru_pembimbing', Guru_pembimbingController::class);
Route::resource('/home/tempat_pkl', Tempat_pklController::class);
Route::resource('/home/pengaturan', PengaturanController::class)->only('index', 'update');
Route::resource('/home/logbook', LogbookController::class);

// ==============================
// 📤 Import Data
// ==============================
Route::post('/home/import_dudi', [DudiController::class, 'import'])->name('dudi.import');
Route::post('/home/import_guru', [GuruController::class, 'import'])->name('guru.import');

// ==============================
// 🔐 User Management
// ==============================
Route::post('/home/users/delete-multiple', [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');
Route::put('/home/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

// ==============================
// 📄 Surat / Dokumen
// ==============================
Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/permohonan/{id}', [SuratController::class, 'cetakPermohonan'])->name('surat.permohonan');
Route::get('/home/pengantar/{id}', [SuratController::class, 'cetakPengantar'])->name('surat.pengantar');
Route::get('/home/permohonan-massal', [SuratController::class, 'cetakPermohonanMassal'])->name('surat.permohonan.massal');
Route::get('/home/pengantar-massal', [SuratController::class, 'cetakPengantarMassal'])->name('surat.pengantar.massal');
Route::get('/home/esertifikat', [EsertifikatController::class, 'index'])->name('home.esertifikat');

// ==============================
// 📄 Nilai
// ==============================
Route::get('/home/nilai', [NilaiController::class, 'index'])->name('nilai.index');
