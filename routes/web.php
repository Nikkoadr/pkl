<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\GuruPembimbingController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PersertaController;
use App\Http\Controllers\PesertaPklController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\EsertifikatController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\Tahun_ajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\NilaiPklController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\SidangPklController;
use App\Http\Controllers\ArsipController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::prefix('autocomplete')->group(function () {
    Route::get('/dudi', [AutoCompleteController::class, 'autoCompleteDudi']);
    Route::get('/users', [AutoCompleteController::class, 'autoCompleteUser']);
    Route::get('/guru', [AutoCompleteController::class, 'autoCompleteGuru']);
    Route::get('/guru_pembimbing', [AutoCompleteController::class, 'autoCompleteGuruPembimbing']);
    Route::get('/peserta', [AutoCompleteController::class, 'autoCompletePeserta']);
    Route::get('/peserta_pkl', [AutoCompleteController::class, 'autoCompletePesertaPKL']);
    Route::get('/kompetensi', [AutoCompleteController::class, 'autoCompleteKompetensi']);
});

Route::get('/home/dashboard', [HomeController::class, 'index'])->name('home.dashboard');
Route::get('/home/profil', [HomeController::class, 'profil'])->name('home.profil');
Route::put('/home/profil/update', [HomeController::class, 'update_profil'])->name('home.profil.update');

Route::get('/home/peserta/request_dudi', [PersertaController::class, 'request_dudi'])->name('peserta.request_dudi');
Route::post('/home/peserta/store_request_dudi', [PersertaController::class, 'store_request_dudi'])->name('peserta.store_request_dudi');
Route::post('/home/import_peserta', [PersertaController::class, 'import'])->name('peserta.import');
Route::get('/home/peserta/export', [PersertaController::class, 'export'])->name('peserta.export');
Route::resource('/home/peserta', PersertaController::class);

Route::get('/home/logbook/cetak_rekap', [LogbookController::class, 'cetak_rekap'])->name('logbook.cetak.rekap');
Route::post('/home/logbook/store_siswa', [LogbookController::class, 'store_siswa'])->name('logbook.store_siswa');
Route::resource('/home/logbook', LogbookController::class);

Route::resource('/home/tahun_ajaran', Tahun_ajaranController::class);

Route::resource('/home/kelas', KelasController::class);

Route::resource('/home/kaprodi', KaprodiController::class);

Route::post('/home/import_dudi', [DudiController::class, 'import'])->name('dudi.import');
Route::get('/home/dudi/export', [DudiController::class, 'export'])->name('dudi.export');
Route::resource('/home/dudi', DudiController::class);

Route::post('/home/import_guru', [GuruController::class, 'import'])->name('guru.import');
Route::resource('/home/guru', GuruController::class);

Route::resource('/home/guru_pembimbing', GuruPembimbingController::class);

Route::resource('/home/pengaturan', PengaturanController::class)->only('index', 'update');

Route::get('/home/surat', [SuratController::class, 'index'])->name('home.surat');
Route::get('/home/kop_surat/{id}', [SuratController::class, 'cetakKopSurat'])->name('surat.kop_surat');
Route::get('/home/booking/{id}', [SuratController::class, 'cetakBooking'])->name('surat.booking');
Route::get('/home/permohonan/{id}', [SuratController::class, 'cetakPermohonan'])->name('surat.permohonan');
Route::get('/home/pengantar/{id}', [SuratController::class, 'cetakPengantar'])->name('surat.pengantar');
Route::get('/home/penarikan/{id}', [SuratController::class, 'cetakPenarikan'])->name('surat.penarikan');

Route::get('/home/kop-surat-massal', [SuratController::class, 'cetakKopSuratMassal'])->name('surat.kop_surat.massal');
Route::get('/home/booking-massal', [SuratController::class, 'cetakBookingMassal'])->name('surat.booking.massal');
Route::get('/home/permohonan-massal', [SuratController::class, 'cetakPermohonanMassal'])->name('surat.permohonan.massal');
Route::get('/home/pengantar-massal', [SuratController::class, 'cetakPengantarMassal'])->name('surat.pengantar.massal');
Route::get('/home/penarikan-massal', [SuratController::class, 'cetakPenarikanMassal'])->name('surat.penarikan.massal');

Route::get('/home/sidang_pkl/', [SidangPklController::class, 'index'])->name('sidang_pkl.index');
Route::post('/home/sidang_pkl/store', [SidangPklController::class, 'store'])->name('sidang_pkl.store');
Route::get('/home/sidang_pkl/edit/{id}', [SidangPklController::class, 'edit'])->name('sidang_pkl.edit');
Route::put('/home/sidang_pkl/update/{id}', [SidangPklController::class, 'update'])->name('sidang_pkl.update');
Route::delete('/home/sidang_pkl/destroy/{id}', [SidangPklController::class, 'destroy'])->name('sidang_pkl.destroy');

Route::get('/home/nilai_pkl', [NilaiPklController::class, 'index'])->name('nilai_pkl.index');
Route::post('/home/nilai_pkl/store', [NilaiPklController::class, 'store'])->name('nilai_pkl.store');
Route::post('/home/nilai_pkl/store_peserta', [NilaiPklController::class, 'store_peserta'])->name('nilai_pkl.store_peserta');
Route::get('/home/nilai_pkl/{id}/edit/', [NilaiPklController::class, 'edit'])->name('nilai_pkl.edit');
Route::put('/home/nilai_pkl/{id}/update/', [NilaiPklController::class, 'update'])->name('nilai_pkl.update');
Route::put('/home/nilai_pkl/{id}/update_peserta/', [NilaiPklController::class, 'update_siswa'])->name('nilai_pkl.update_siswa');
Route::delete('/home/nilai_pkl/{id}/destroy/', [NilaiPklController::class, 'destroy'])->name('nilai_pkl.destroy');

Route::get('/home/esertifikat', [EsertifikatController::class, 'index'])->name('home.esertifikat');
Route::delete('/home/esertifikat/{id}', [EsertifikatController::class, 'destroy'])->name('esertifikat.destroy');
Route::post('/home/esertifikat/destroy_massal', [EsertifikatController::class, 'destroy_massal'])->name('esertifikat.destroy_massal');

Route::post('/nilai_pkl/generate_massal', [EsertifikatController::class, 'generate_massal'])->name('esertifikat.generate_massal');
Route::post('/nilai_pkl/generate/{id}', [EsertifikatController::class, 'generate'])->name('esertifikat.generate');

Route::get('/esertifikat/scan/{hash}', [EsertifikatController::class, 'scan'])->where('hash', '[A-Fa-f0-9]{64}');

Route::get('/home/esertifikat/cetak_depan/{id}', [EsertifikatController::class, 'cetak_depan'])->name('cetak.esertifikat_depan');
Route::get('/home/esertifikat/cetak_belakang/{id}', [EsertifikatController::class, 'cetak_belakang'])->name('cetak.esertifikat_belakang');
Route::post('/home/esertifikat/cetak-depan-massal', [EsertifikatController::class, 'cetak_depan_massal'])->name('cetak.esertifikat-depan-massal');
Route::post('/home/esertifikat/cetak-belakang-massal', [EsertifikatController::class, 'cetak_belakang_massal'])->name('cetak.esertifikat-belakang-massal');

Route::get('/home/arsip', [ArsipController::class, 'index'])->name('arsip.index');
Route::get('/home/arsip/export/{id}', [ArsipController::class, 'export_arsip'])->name('arsip.export');
