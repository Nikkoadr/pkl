<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('esertifikats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nilai_pkl_id');
            $table->unsignedBigInteger('peserta_pkl_id');
            $table->string('nomor_sertifikat')->unique();
            $table->date('tanggal_diterbitkan');
            $table->timestamps();

            $table->foreign('nilai_pkl_id')->references('id')->on('nilai_pkl')->onDelete('cascade');
            $table->foreign('peserta_pkl_id')->references('id')->on('peserta_pkl')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esertifikats');
    }
};
