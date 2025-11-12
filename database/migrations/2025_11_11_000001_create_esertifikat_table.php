<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('esertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_pkl_id')->constrained('peserta_pkl')->onDelete('cascade');
            $table->string('nomor_sertifikat')->unique();
            $table->date('tanggal_diterbitkan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esertifikat');
    }
};
