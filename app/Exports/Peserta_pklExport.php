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
        $query = Peserta::with([
            'user',
            'kelas.kompetensi',
            'peserta_pkl.dudi'
        ]);

        $guru = $this->getCurrentGuru();
        if (!$guru) return collect();


        if (Gate::allows('prodi')) {
            $kaprodi = Kaprodi::where('guru_id', $guru->id)->first();
            if (!$kaprodi) return collect();

            $query->whereHas('kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            });
        }

        if (Gate::allows('guru_pembimbing')) {
            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $query->whereHas('peserta_pkl', function ($q) use ($dudi_ids) {
                $q->whereIn('dudi_id', $dudi_ids);
            });
        }

        return $query->get()->map(function ($peserta) {

            $dudi = optional($peserta->peserta_pkl)->dudi;
            $dudiName = $dudi->nama_dudi ?? 'Belum memiliki DUDI';

            return [
                'nis'           => "'" . ($peserta->nis ?? '-'),
                'nisn'          => "'" . ($peserta->nisn ?? '-'),
                'nama'          => optional($peserta->user)->nama ?? '-',
                'tempat_lahir'  => optional($peserta->user)->tempat_lahir ?? '-',
                'tanggal_lahir' => optional($peserta->user)->tanggal_lahir
                    ? Carbon::parse($peserta->user->tanggal_lahir)->translatedFormat('d F Y')
                    : '-',
                'kelas'         => optional($peserta->kelas)->nama_kelas ?? '-',
                'dudi'          => $dudiName,
            ];
        });
    }

    private function getCurrentGuru()
    {
        return Guru::where('user_id', Auth::id())->first();
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
