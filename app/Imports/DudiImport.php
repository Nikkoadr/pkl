<?php

namespace App\Imports;

use App\Models\Dudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DudiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Dudi([
            'nama_dudi' => $row['nama_dudi'],
        ]);
    }
}
