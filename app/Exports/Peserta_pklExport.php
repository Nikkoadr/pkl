<?php

namespace App\Exports;

use App\Models\Peserta_pkl;
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
        // base query
        $query = Peserta_pkl::with(['dudi', 'peserta.user', 'peserta.kelas.kompetensi']);

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('user_id', $user->id)->first();

            if ($kaprodi) {
                $query->whereHas('peserta.kelas', function ($q) use ($kaprodi) {
                    $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                });
            } else {
                return collect(); // kosong kalau tidak valid
            }
        }

        if (Gate::allows('guru_pembimbing')) {
            $user = Auth::user();
            $guru = Guru::where('user_id', $user->id)->first();

            if ($guru) {
                $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');
                $query->whereIn('dudi_id', $dudi_ids);
            } else {
                return collect();
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'nis'           => "'" . ($item->peserta->nis ?? '-'),
                'nisn'          => "'" . ($item->peserta->nisn ?? '-'),
                'nama'          => $item->peserta->user->nama ?? '-',
                'tempat_lahir'  => $item->peserta->user->tempat_lahir ?? '-',
                'tanggal_lahir' => $item->peserta->user->tanggal_lahir
                    ? Carbon::parse($item->peserta->user->tanggal_lahir)->translatedFormat('d F Y')
                    : '-',
                'kelas'         => $item->peserta->kelas->nama_kelas ?? '-',
                'dudi'          => $item->dudi->nama_dudi ?? '-',
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
