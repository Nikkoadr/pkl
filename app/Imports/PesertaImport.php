<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::create([
            'role_id' => 4,
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        Peserta::create([
            'tahun_ajaran_id' => $row['tahun_ajaran_id'],
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'kelas_id' => $row['kelas_id'],
            'user_id' => $user->id,
        ]);
    }
}
