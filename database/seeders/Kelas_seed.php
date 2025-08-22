<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class Kelas_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create(['nama_kelas' => '11-FKK-1', 'kompetensi_keahlian_id' => 6]);
        Kelas::create(['nama_kelas' => '11-FKK-2', 'kompetensi_keahlian_id' => 6]);
        Kelas::create(['nama_kelas' => '11-LAS-1', 'kompetensi_keahlian_id' => 4]);
        Kelas::create(['nama_kelas' => '11-TEI-1', 'kompetensi_keahlian_id' => 3]);
        Kelas::create(['nama_kelas' => '11-TKJ-1', 'kompetensi_keahlian_id' => 1]);
        Kelas::create(['nama_kelas' => '11-TKJ-2', 'kompetensi_keahlian_id' => 1]);
        Kelas::create(['nama_kelas' => '11-TKJ-3', 'kompetensi_keahlian_id' => 1]);
        Kelas::create(['nama_kelas' => '11-TKJ-4', 'kompetensi_keahlian_id' => 1]);
        Kelas::create(['nama_kelas' => '11-TKR-1', 'kompetensi_keahlian_id' => 2]);
        Kelas::create(['nama_kelas' => '11-TKR-2', 'kompetensi_keahlian_id' => 2]);
        Kelas::create(['nama_kelas' => '11-TKR-3', 'kompetensi_keahlian_id' => 2]);
        Kelas::create(['nama_kelas' => '11-TKR-4', 'kompetensi_keahlian_id' => 2]);
        Kelas::create(['nama_kelas' => '11-TKR-5', 'kompetensi_keahlian_id' => 2]);
        Kelas::create(['nama_kelas' => '11-TSM-1', 'kompetensi_keahlian_id' => 5]);
        Kelas::create(['nama_kelas' => '11-TSM-2', 'kompetensi_keahlian_id' => 5]);
        Kelas::create(['nama_kelas' => '11-TSM-3', 'kompetensi_keahlian_id' => 5]);
    }
}
