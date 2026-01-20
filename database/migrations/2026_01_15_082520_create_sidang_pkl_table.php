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
        Schema::create('sidang_pkl', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_sidang');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->string('bukti_sidang', 120)->nullable();
            $table->foreignId('peserta_pkl_id')->constrained('peserta_pkl')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidang_pkl');
    }
};
