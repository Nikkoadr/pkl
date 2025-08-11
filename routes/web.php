<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Guru_pembimbingController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PersertaController;
use App\Http\Controllers\Peserta_pklController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\EsertifikatController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\Auto_completeController;
use App\Http\Controllers\Tahun_ajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\Nilai_pklController;

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
    Route::get('/peserta_pkl', [Auto_completeController::class, 'autoCompletePesertaPKL']);
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
Route::resource('/home/peserta_pkl', Peserta_pklController::class);
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
Route::get('/home/nilai_pkl', [Nilai_pklController::class, 'index'])->name('nilai_pkl.index');
Route::post('/home/nilai_pkl/store', [Nilai_pklController::class, 'store'])->name('nilai_pkl.store');
Route::get('/home/nilai_pkl/{id}/edit/', [Nilai_pklController::class, 'edit'])->name('nilai_pkl.edit');
Route::put('/home/nilai_pkl/{id}/update/', [Nilai_pklController::class, 'update'])->name('nilai_pkl.update');
Route::delete('/home/nilai_pkl/{id}/destroy/', [Nilai_pklController::class, 'destroy'])->name('nilai_pkl.destroy');
