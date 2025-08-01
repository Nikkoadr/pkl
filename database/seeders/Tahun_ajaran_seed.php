<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tahun_ajaran;

class Tahun_ajaran_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tahun_ajaran::create([
            'nama_tahun_ajaran' => '2025/2026',
        ]);
    }
}
