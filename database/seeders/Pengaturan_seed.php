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
            'alamat_sekolah' => 'Jl. Raya Karanganyar No.28/A Kandanghaur Indamayu',
            'no_telp_sekolah' => '081122207770',
            'kepala_sekolah' => 'H.Afandi, S.Pd., M.Ed',
            'ketua_pkl' => 'H.Nanang Hadi M, S.ST',
            'sekretaris_pkl' => 'Rizky Ramadona, S.T',
            'tanggal_mulai_pkl' => '2025-09-01',
            'tanggal_selesai_pkl' => '2025-11-30',
        ]);
    }
}
