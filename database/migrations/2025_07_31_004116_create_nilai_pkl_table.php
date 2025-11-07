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
        Schema::create('nilai_pkl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_pkl_id')->constrained('peserta_pkl')->onDelete('cascade');
            $table->integer('nilai_disiplin_kerja')->nullable();
            $table->integer('nilai_kemajuan_kerja')->nullable();
            $table->integer('nilai_kualitas_kerja')->nullable();
            $table->integer('nilai_inisiatif_kreatifitas')->nullable();
            $table->integer('nilai_prilaku')->nullable();
            $table->string('foto_bukti_nilai_pkl', 120)->nullable();
            $table->integer('nilai_sidang_pkl')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_pkl');
    }
};
