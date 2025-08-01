<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class Pengaturan_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create([
            'nama_sekolah' => 'SMK Muhammadiyah Kandanghaur',
            'alamat_sekolah' => 'Jl. Raya Kandanghaur No. 123, Kandanghaur, Indramayu',
            'no_telp_sekolah' => '0234-567890',
            'kepala_sekolah' => 'Drs. H. Ahmad Fauzi',
            'sekretaris_pkl' => 'H. Jajang Mulyana',
            'logo_sekolah' => 'logo.png',
            'tanggal_mulai_pkl' => '2025-08-01',
            'tanggal_selesai_pkl' => '2025-11-30',
            'nomor_surat_permohonan' => '123/SMK-MUH/PKL/2025',
            'nomor_surat_pengantar' => '456/SMK-MUH/PKL/2025',
        ]);
    }
}
