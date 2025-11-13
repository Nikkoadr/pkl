<?php

namespace App\Imports;

use App\Models\Peserta_pkl;
use App\Models\Peserta;
use App\Models\Dudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Peserta_pklImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $peserta = Peserta::whereHas('user', function ($q) use ($row) {
            $q->where('nama', $row['nama_peserta']);
        })->first();

        $dudi = Dudi::where('nama_dudi', $row['nama_dudi'])->first();

        if (!$peserta || !$dudi) {
            return null;
        }

        return new Peserta_pkl([
            'peserta_id' => $peserta->id,
            'dudi_id' => $dudi->id,
        ]);
    }
}
