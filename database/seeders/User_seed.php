<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class User_seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'nama' => 'Administrator',
            'email' => 'pkl@smkmuhkandanghaur.sch.id',
            'password' => Hash::make('Secret123'),
        ]);
        User::create([
            'role_id' => 2,
            'nama' => 'Kaprodi',
            'email' => 'kaprodi@smkmuhkandanghaur.sch.id',
            'password' => Hash::make('Secret123'),
        ]);
        User::create([
            'role_id' => 3,
            'nama' => 'Guru Pembimbing',
            'email' => 'guru@smkmuhkandanghaur.sch.id',
            'password' => Hash::make('Secret123'),
        ]);
        User::create([
            'role_id' => 4,
            'nama' => 'Peserta TKJ',
            'email' => 'peserta_tkj@smkmuhkandanghaur.sch.id',
            'password' => Hash::make('Secret123'),
        ]);
        User::create([
            'role_id' => 4,
            'nama' => 'Peserta TKR',
            'email' => 'peserta_tkr@smkmuhkandanghaur.sch.id',
            'password' => Hash::make('Secret123'),
        ]);
    }
}
