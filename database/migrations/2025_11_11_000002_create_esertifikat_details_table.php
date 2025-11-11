<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('esertifikat_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('esertifikat_id');
            $table->integer('nilai_disiplin_kerja');
            $table->integer('nilai_kemajuan_kerja');
            $table->integer('nilai_kualitas_kerja');
            $table->integer('nilai_inisiatif_kreatifitas');
            $table->integer('nilai_perilaku');
            $table->integer('nilai_sidang_pkl');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('esertifikat_id')->references('id')->on('esertifikats')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esertifikat_details');
    }
};
