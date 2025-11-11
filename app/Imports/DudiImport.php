<?php

namespace App\Imports;

use App\Models\Dudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Kompetensi_keahlian;

class DudiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kompetensi_keahlian = Kompetensi_keahlian::where('nama_kompetensi', $row['kompetensi_keahlian'])->first();
        if (!$kompetensi_keahlian) {
            throw new \Exception("Kompetensi Keahlian {$row['kompetensi_keahlian']} tidak ditemukan");
        }
        return new Dudi([
            'nama_dudi' => $row['nama_dudi'],
            'alamat_dudi' => $row['alamat_dudi'],
            'no_telp_dudi' => $row['no_telp_dudi'],
            'nomor_kepegawaian' => $row['nomor_kepegawaian'],
            'nama_pimpinan_dudi' => $row['nama_pimpinan_dudi'],
            'kuota' => $row['kuota'],
            'kompetensi_keahlian_id' => $kompetensi_keahlian->id,
        ]);
    }
}
