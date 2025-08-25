<?php

namespace App\Exports;

use App\Models\Peserta;
use App\Models\Kaprodi;
use App\Models\Guru;
use App\Models\Guru_pembimbing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class Peserta_pklExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Peserta::with(['user', 'kelas.kompetensi', 'peserta_pkl.dudi']);

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('user_id', $user->id)->first();

            if ($kaprodi) {
                $query->whereHas('kelas', function ($q) use ($kaprodi) {
                    $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                });
            } else {
                return collect();
            }
        }

        if (Gate::allows('guru_pembimbing')) {
            $user = Auth::user();
            $guru = Guru::where('user_id', $user->id)->first();

            if ($guru) {
                $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');
                $query->whereHas('peserta_pkl', function ($q) use ($dudi_ids) {
                    $q->whereIn('dudi_id', $dudi_ids);
                });
            } else {
                return collect();
            }
        }

        return $query->get()->map(function ($peserta) {
            $dudiName = $peserta->peserta_pkl->dudi->nama_dudi ?? 'Belum memiliki DUDI';

            return [
                'nis'           => "'" . ($peserta->nis ?? '-'),
                'nisn'          => "'" . ($peserta->nisn ?? '-'),
                'nama'          => $peserta->user->nama ?? '-',
                'tempat_lahir'  => $peserta->user->tempat_lahir ?? '-',
                'tanggal_lahir' => $peserta->user->tanggal_lahir
                    ? Carbon::parse($peserta->user->tanggal_lahir)->translatedFormat('d F Y')
                    : '-',
                'kelas'         => $peserta->kelas->nama_kelas ?? '-',
                'dudi'          => $dudiName,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kelas',
            'DUDI',
        ];
    }
}
