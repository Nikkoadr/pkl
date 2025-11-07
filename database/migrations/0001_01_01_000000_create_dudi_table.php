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
        Schema::create('dudi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dudi', 100)->nullable();
            $table->text('alamat_dudi')->nullable();
            $table->string('no_telp_dudi', 25)->nullable();
            $table->string('jabatan_pimpinan', 50)->nullable();
            $table->string('nomor_kepegawaian', 50)->nullable();
            $table->string('nama_pimpinan_dudi', 100)->nullable();
            $table->integer('kuota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudi');
    }
};
