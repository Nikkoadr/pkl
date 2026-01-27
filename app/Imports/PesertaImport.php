<?php

namespace App\Imports;

use App\Models\{User, Peserta, Kelas, Tahun_ajaran, Dudi, Peserta_pkl};
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow};
use Exception;

class PesertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();
        $tahun_ajaran = Tahun_ajaran::where('nama_tahun_ajaran', $row['tahun_ajaran'])->first();
        $dudi = Dudi::where('nama_dudi', $row['nama_dudi'])->first();

        if (!$kelas) {
            throw new Exception("Kelas {$row['kelas']} tidak ditemukan");
        }

        if (!$tahun_ajaran) {
            throw new Exception("Tahun Ajaran {$row['tahun_ajaran']} tidak ditemukan");
        }

        $dudi = null;

        if (!empty($row['nama_dudi'])) {
            $dudi = Dudi::where('nama_dudi', $row['nama_dudi'])->first();
        }

        $user = User::create([
            'role_id' => 4,
            'nama' => $row['nama_peserta'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'no_telp' => $row['no_telp'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        $peserta = Peserta::create([
            'user_id' => $user->id,
            'tahun_ajaran_id' => $tahun_ajaran->id,
            'nisn' => ltrim($row['nisn'], "'"),
            'nis' => ltrim($row['nis'], "'"),
            'kelas_id' => $kelas->id,
        ]);

        if ($dudi) {
            Peserta_pkl::create([
                'peserta_id' => $peserta->id,
                'dudi_id' => $dudi->id,
            ]);
        }
    }
}
