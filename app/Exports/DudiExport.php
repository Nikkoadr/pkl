<?php

namespace App\Exports;

use App\Models\{Dudi, Kaprodi, Guru};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings};

class DudiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Dudi::with('kompetensi_keahlian');

        /*
        |----------------------------------------------------------
        | PRODI → FILTER BERDASARKAN KOMPETENSI KEAHLIAN
        |----------------------------------------------------------
        */
        if (Gate::allows('prodi')) {

            $guru = Guru::where('user_id', Auth::id())->first();
            if (!$guru) {
                return collect();
            }

            $kaprodi = Kaprodi::where('guru_id', $guru->id)->first();
            if (!$kaprodi) {
                return collect();
            }

            $query->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
        }

        /*
        |----------------------------------------------------------
        | ADMIN → TANPA FILTER (AMBIL SEMUA)
        |----------------------------------------------------------
        */
        // Gate::allows('admin') → otomatis ambil semua

        return $query->get()->map(function ($dudi) {
            return [
                'nama_dudi'          => $dudi->nama_dudi ?? '-',
                'alamat_dudi'        => $dudi->alamat_dudi ?? '-',
                'no_telp_dudi'       => "'" . ($dudi->no_telp_dudi ?? '-'),
                'jabatan_pimpinan'   => $dudi->jabatan_pimpinan ?? '-',
                'nomor_kepegawaian'  => "'" . ($dudi->nomor_kepegawaian ?? '-'),
                'nama_pimpinan_dudi' => $dudi->nama_pimpinan_dudi ?? '-',
                'kuota'              => $dudi->kuota ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama DUDI',
            'Alamat DUDI',
            'No. Telp DUDI',
            'Jabatan Pimpinan',
            'Nomor Kepegawaian',
            'Nama Pimpinan DUDI',
            'Kuota',
        ];
    }
}
