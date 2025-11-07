<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class Role_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'nama_role' => 'Admin',
        ]);
        Role::create([
            'nama_role' => 'Kaprodi',
        ]);
        Role::create([
            'nama_role' => 'Guru',
        ]);
        Role::create([
            'nama_role' => 'Peserta',
        ]);
    }
}
