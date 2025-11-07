<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::create([
            'role_id' => 3,
            'nama' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        Guru::create([
            'user_id' => $user->id,
            'keterangan' => $row['keterangan'],
        ]);
    }
}
