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
use App\Http\Controllers\KaprodiController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => true,
    'reset' => false,
    'verify' => false
]);

// ==============================
// Autocomplete
// ==============================
Route::prefix('autocomplete')->group(function () {
    Route::get('/dudi', [Auto_completeController::class, 'autoCompleteDudi']);
    Route::get('/users', [Auto_completeController::class, 'autoCompleteUser']);
    Route::get('/guru', [Auto_completeController::class, 'autoCompleteGuru']);
    Route::get('/guru_pembimbing', [Auto_completeController::class, 'autoCompleteGuruPembimbing']);
    Route::get('/peserta', [Auto_completeController::class, 'autoCompletePeserta']);
    Route::get('/peserta_pkl', [Auto_completeController::class, 'autoCompletePesertaPKL']);
    Route::get('/kompetensi', [Auto_completeController::class, 'autoCompleteKompetensi']);
});

// ==============================
// Dashboard & Umum
// ==============================
Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
Route::get('/home/profil', [HomeController::class, 'profil'])->name('home.profil');
Route::put('/home/profil/update', [HomeController::class, 'update_profil'])->name('home.profil.update');
Route::get('/home/peserta_pkl/export', [Peserta_pklController::class, 'export'])->name('peserta_pkl.export');
Route::get('/home/peserta/request_dudi', [PersertaController::class, 'request_dudi'])->name('peserta.request_dudi');
Route::post('/home/peserta/store_request_dudi', [PersertaController::class, 'store_request_dudi'])->name('peserta.store_request_dudi');
Route::get('/home/logbook/cetak_rekap', [LogbookController::class, 'cetak_rekap'])->name('logbook.cetak.rekap');
// ==============================
// Master Data
// ==============================
Route::resource('/home/tahun_ajaran', Tahun_ajaranController::class);
Route::resource('/home/kelas', KelasController::class);
Route::resource('/home/kaprodi', KaprodiController::class);
Route::resource('/home/users', UserController::class);
Route::resource('/home/dudi', DudiController::class);
Route::resource('/home/guru', GuruController::class);
Route::resource('/home/peserta', PersertaController::class);
Route::resource('/home/guru_pembimbing', Guru_pembimbingController::class);
Route::resource('/home/peserta_pkl', Peserta_pklController::class);
Route::resource('/home/pengaturan', PengaturanController::class)->only('index', 'update');
Route::resource('/home/logbook', LogbookController::class);
Route::post('/home/logbook/store_siswa', [LogbookController::class, 'store_siswa'])->name('logbook.store_siswa');
// ==============================
// Import Data
// ==============================
Route::post('/home/import_dudi', [DudiController::class, 'import'])->name('dudi.import');
Route::post('/home/import_guru', [GuruController::class, 'import'])->name('guru.import');
Route::post('/home/import_peserta', [PersertaController::class, 'import'])->name('peserta.import');

// ==============================
// User Management
// ==============================
Route::post('/home/users/delete-multiple', [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');
Route::put('/home/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

// ==============================
// Surat / Dokumen
// ==============================
Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/kop_surat/{id}', [SuratController::class, 'cetakKopSurat'])->name('surat.kop_surat');
Route::get('/home/permohonan/{id}', [SuratController::class, 'cetakPermohonan'])->name('surat.permohonan');
Route::get('/home/pengantar/{id}', [SuratController::class, 'cetakPengantar'])->name('surat.pengantar');
Route::get('/home/kop-surat-massal', [SuratController::class, 'cetakKopSuratMassal'])->name('surat.kop_surat.massal');
Route::get('/home/permohonan-massal', [SuratController::class, 'cetakPermohonanMassal'])->name('surat.permohonan.massal');
Route::get('/home/pengantar-massal', [SuratController::class, 'cetakPengantarMassal'])->name('surat.pengantar.massal');

Route::get('/home/esertifikat', [EsertifikatController::class, 'index'])->name('home.esertifikat');
Route::get('/home/esertifikat/cetak_depan/{id}', [EsertifikatController::class, 'cetak_depan'])->name('cetak.esertifikat_depan');
Route::get('/home/esertifikat/cetak_belakang/{id}', [EsertifikatController::class, 'cetak_belakang'])->name('cetak.esertifikat_belakang');
Route::get('/home/esertifikat/cetak_depan_massal', [EsertifikatController::class, 'cetak_depan_massal'])->name('cetak.esertifikat_depan.massal');
Route::get('/home/esertifikat/cetak_belakang_massal', [EsertifikatController::class, 'cetak_belakang_massal'])->name('cetak.esertifikat_belakang.massal');

// ==============================
// Nilai
// ==============================
Route::get('/home/nilai_pkl', [Nilai_pklController::class, 'index'])->name('nilai_pkl.index');
Route::post('/home/nilai_pkl/store', [Nilai_pklController::class, 'store'])->name('nilai_pkl.store');
Route::post('/home/nilai_pkl/store_peserta', [Nilai_pklController::class, 'store_peserta'])->name('nilai_pkl.store_peserta');
Route::get('/home/nilai_pkl/{id}/edit/', [Nilai_pklController::class, 'edit'])->name('nilai_pkl.edit');
Route::put('/home/nilai_pkl/{id}/update/', [Nilai_pklController::class, 'update'])->name('nilai_pkl.update');
Route::put('/home/nilai_pkl/{id}/update_peserta/', [Nilai_pklController::class, 'update_siswa'])->name('nilai_pkl.update_siswa');
Route::delete('/home/nilai_pkl/{id}/destroy/', [Nilai_pklController::class, 'destroy'])->name('nilai_pkl.destroy');
