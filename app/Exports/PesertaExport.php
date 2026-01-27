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

class PesertaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Peserta::with([
            'user',
            'kelas.kompetensi',
            'peserta_pkl.dudi'
        ]);

        if (Gate::allows('prodi')) {

            $guru = $this->getCurrentGuru();
            if (!$guru) return collect();

            $kaprodi = Kaprodi::where('guru_id', $guru->id)->first();
            if (!$kaprodi) return collect();

            $query->whereHas('kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            });
        }

        if (Gate::allows('guru_pembimbing')) {

            $guru = $this->getCurrentGuru();
            if (!$guru) return collect();

            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $query->whereHas('peserta_pkl', function ($q) use ($dudi_ids) {
                $q->whereIn('dudi_id', $dudi_ids);
            });
        }

        return $query->get()->map(function ($peserta) {

            $dudi = optional($peserta->peserta_pkl)->dudi;

            return [
                'nis'               => "'" . ($peserta->nis ?? '-'),
                'nisn'              => "'" . ($peserta->nisn ?? '-'),
                'nama'              => optional($peserta->user)->nama ?? '-',
                'jenis_kelamin'     => optional($peserta->user)->jenis_kelamin ?? '-',
                'tempat_lahir'      => optional($peserta->user)->tempat_lahir ?? '-',
                'tanggal_lahir'     => optional($peserta->user)->tanggal_lahir
                    ? Carbon::parse($peserta->user->tanggal_lahir)->translatedFormat('d F Y')
                    : '-',
                'no_telp'           => optional($peserta->user)->no_telp ?? '-',
                'kelas'             => optional($peserta->kelas)->nama_kelas ?? '-',

                'nama_dudi'         => $dudi->nama_dudi ?? 'Belum memiliki DUDI',
                'alamat_dudi'       => $dudi->alamat_dudi ?? '-',
                'no_telp_dudi'      => "'" . ($dudi->no_telp_dudi ?? '-'),
                'jabatan_pimpinan'  => $dudi->jabatan_pimpinan ?? '-',
                'nomor_kepegawaian' => "'" . ($dudi->nomor_kepegawaian ?? '-'),
                'nama_pimpinan_dudi' => $dudi->nama_pimpinan_dudi ?? '-',
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
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kelas',
            'No. Telp',

            'Nama DUDI',
            'Alamat DUDI',
            'No. Telp DUDI',
            'Jabatan Pimpinan',
            'Nomor Kepegawaian',
            'Nama Pimpinan DUDI',
        ];
    }
}
