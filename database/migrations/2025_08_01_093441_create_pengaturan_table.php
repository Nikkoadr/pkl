<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->string('no_telp_sekolah')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('sekretaris_pkl')->nullable();
            $table->string('logo_sekolah')->nullable();
            $table->date('tanggal_mulai_pkl')->nullable();
            $table->date('tanggal_selesai_pkl')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('nomor_surat_permohonan')->nullable();
            $table->string('nomor_surat_pengantar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
