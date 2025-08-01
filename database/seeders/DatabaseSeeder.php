<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            Tahun_ajaran_seed::class,
            Role_seed::class,
            User_seed::class,
            Kompetensi_keahlian_seed::class,
            Kelas_seed::class,
            Dudi_seed::class,
            Pengaturan_seed::class,
        ]);
    }
}
