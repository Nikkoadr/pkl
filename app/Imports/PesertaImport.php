<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Peserta_pkl;
use App\Models\Kelas;
use App\Models\Tahun_ajaran;
use App\Models\Dudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PesertaImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();
        $tahun_ajaran = Tahun_ajaran::where('nama_tahun_ajaran', $row['tahun_ajaran'])->first();

        if (!$kelas || !$tahun_ajaran) {
            return null;
        }

        $tanggal_lahir = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                $tanggal_lahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggal_lahir = null;
            }
        }

        $user = User::create([
            'role_id'       => 4,
            'nama'          => $row['nama_peserta'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir'  => $row['tempat_lahir'] ?? '-',
            'tanggal_lahir' => $tanggal_lahir,
            'no_telp'       => $row['no_telp'] ?? '-',
            'email'         => $row['email'],
            'password'      => Hash::make($row['password'] ?? '12345678'),
        ]);

        // 4. Buat Data Peserta
        $peserta = Peserta::create([
            'user_id'         => $user->id,
            'tahun_ajaran_id' => $tahun_ajaran->id,
            'nisn'            => ltrim($row['nisn'], "'"),
            'nis'             => ltrim($row['nis'], "'"),
            'kelas_id'        => $kelas->id,
        ]);

        if (!empty($row['nama_dudi'])) {
            $dudi = Dudi::where('nama_dudi', $row['nama_dudi'])->first();
            if ($dudi) {
                Peserta_pkl::create([
                    'peserta_id' => $peserta->id,
                    'dudi_id'    => $dudi->id,
                ]);
            }
        }

        return $user;
    }

    // Memproses setiap 100 baris untuk menjaga performa memori
    public function chunkSize(): int
    {
        return 100;
    }
}
