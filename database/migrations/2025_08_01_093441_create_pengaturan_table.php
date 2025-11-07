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
            $table->string('nama_sekolah', 50)->nullable();
            $table->text('alamat_sekolah')->nullable();
            $table->string('no_telp_sekolah', 25)->nullable();
            $table->string('kepala_sekolah', 50)->nullable();
            $table->string('ketua_pkl', 50)->nullable();
            $table->string('sekretaris_pkl', 50)->nullable();
            $table->date('tanggal_mulai_pkl')->nullable();
            $table->date('tanggal_selesai_pkl')->nullable();
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
