<?php

namespace App\Exports;

use App\Models\Peserta;
use App\Models\Guru;
use App\Models\Kaprodi;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ArsipExport implements FromCollection, WithHeadings
{
    protected $tahunAjaranId;

    public function __construct($tahunAjaranId)
    {
        $this->tahunAjaranId = $tahunAjaranId;
    }

    private function getCurrentGuru()
    {
        return Guru::where('user_id', Auth::id())->first();
    }

    public function collection()
    {
        $query = Peserta::with([
            'user',
            'kelas.kompetensi',
            'peserta_pkl.dudi',
            'peserta_pkl.nilai_pkl',
            'peserta_pkl.esertifikat',
        ])

            ->where('tahun_ajaran_id', $this->tahunAjaranId);

        if (Gate::allows('prodi')) {

            $guru = $this->getCurrentGuru();
            if (!$guru) return collect();

            $kaprodi = Kaprodi::where('guru_id', $guru->id)->first();
            if (!$kaprodi) return collect();

            $query->whereHas('kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            });
        }

        return $query->get()->map(function ($peserta) {

            $pesertaPkl  = $peserta->peserta_pkl;
            $dudi        = optional($pesertaPkl)->dudi;
            $nilai       = optional($pesertaPkl)->nilai_pkl;
            $esertifikat = optional($pesertaPkl)->esertifikat;

            $nilaiList = [
                $nilai->nilai_disiplin_kerja ?? null,
                $nilai->nilai_kemajuan_kerja ?? null,
                $nilai->nilai_kualitas_kerja ?? null,
                $nilai->nilai_inisiatif_kreatifitas ?? null,
                $nilai->nilai_perilaku ?? null,
                $nilai->nilai_sidang_pkl ?? null,
            ];

            $nilaiTerisi = collect($nilaiList)->filter(fn($v) => $v !== null);
            $adaNilai = $nilaiTerisi->count() > 0;

            return [
                'nis'               => "'" . ($peserta->nis ?? '-'),
                'nisn'              => "'" . ($peserta->nisn ?? '-'),
                'nama'              => optional($peserta->user)->nama ?? '-',
                'tempat_lahir'      => optional($peserta->user)->tempat_lahir ?? '-',
                'tanggal_lahir'     => optional($peserta->user)->tanggal_lahir
                    ? Carbon::parse($peserta->user->tanggal_lahir)->translatedFormat('d F Y')
                    : '-',
                'kelas'             => optional($peserta->kelas)->nama_kelas ?? '-',
                'nama_dudi'         => $dudi->nama_dudi ?? 'Belum memiliki DUDI',

                'disiplin_kerja'    => $nilaiList[0] ?? 'Belum ada nilai',
                'kemajuan_kerja'    => $nilaiList[1] ?? 'Belum ada nilai',
                'kualitas_kerja'    => $nilaiList[2] ?? 'Belum ada nilai',
                'inisiatif'         => $nilaiList[3] ?? 'Belum ada nilai',
                'perilaku'          => $nilaiList[4] ?? 'Belum ada nilai',
                'nilai_sidang'      => $nilaiList[5] ?? 'Belum ada nilai',

                'nilai_akhir' => $adaNilai ? round($nilaiTerisi->avg()) : 'Belum ada nilai',

                'nomor_sertifikat'  => $esertifikat->nomor_sertifikat ?? 'Belum ada sertifikat',
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
            'Nama DUDI',
            'Nilai Disiplin Kerja',
            'Nilai Kemajuan Kerja',
            'Nilai Kualitas Kerja',
            'Nilai Inisiatif & Kreatifitas',
            'Nilai Perilaku',
            'Nilai Sidang PKL',
            'Nilai Akhir',
            'Nomor Sertifikat',
        ];
    }
}
