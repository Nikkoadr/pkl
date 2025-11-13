<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Models\Esertifikat;
use App\Models\Nilai_pkl;

class EsertifikatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['scan']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function generate($id)
    {
        $nilai_pkl = Nilai_pkl::with('peserta_pkl.peserta.user')->findOrFail($id);

        if (
            $nilai_pkl->nilai_disiplin_kerja === null ||
            $nilai_pkl->nilai_kemajuan_kerja === null ||
            $nilai_pkl->nilai_kualitas_kerja === null ||
            $nilai_pkl->nilai_inisiatif_kreatifitas === null ||
            $nilai_pkl->nilai_perilaku === null ||
            $nilai_pkl->nilai_sidang_pkl === null
        ) {
            return back()->with('error', 'Tidak dapat membuat e-sertifikat. Nilai belum lengkap.');
        }

        if ($nilai_pkl->esertifikat) {
            return back()->with('error', 'E-sertifikat sudah pernah digenerate untuk peserta ini.');
        }

        Esertifikat::create([
            'peserta_pkl_id' => $nilai_pkl->peserta_pkl_id,
            'nomor_sertifikat' => $this->generateNomor(),
            'tanggal_diterbitkan' => now(),
        ]);

        return back()->with('success', 'E-sertifikat berhasil digenerate.');
    }

    public function generate_massal(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $berhasil = 0;
        $gagal = 0;

        $dataNilai = Nilai_pkl::with('peserta_pkl.peserta.user')
            ->whereIn('id', $ids)
            ->get();

        foreach ($dataNilai as $nilai) {
            try {
                $lengkap = !(
                    $nilai->nilai_disiplin_kerja === null ||
                    $nilai->nilai_kemajuan_kerja === null ||
                    $nilai->nilai_kualitas_kerja === null ||
                    $nilai->nilai_inisiatif_kreatifitas === null ||
                    $nilai->nilai_perilaku === null ||
                    $nilai->nilai_sidang_pkl === null
                );

                if (!$lengkap) {
                    $gagal++;
                    continue;
                }

                $sudahAda = Esertifikat::where('peserta_pkl_id', $nilai->peserta_pkl_id)->exists();
                if ($sudahAda) {
                    $gagal++;
                    continue;
                }

                Esertifikat::create([
                    'peserta_pkl_id' => $nilai->peserta_pkl_id,
                    'nomor_sertifikat' => $this->generateNomor(),
                    'tanggal_diterbitkan' => now(),
                ]);

                $berhasil++;
            } catch (\Throwable $e) {
                // Kalau ada error pada peserta tertentu, lanjut ke peserta berikutnya
                $gagal++;
                continue;
            }
        }

        return back()->with('success', "E-sertifikat berhasil dibuat: {$berhasil}, gagal: {$gagal}");
    }

    private function generateNomor()
    {
        $tahun = date('Y');

        $count = Esertifikat::whereYear('tanggal_diterbitkan', $tahun)->count() + 1;

        return '086.' . str_pad($count, 3, '0', STR_PAD_LEFT)
            . '/KET/III.4/AU/F/' . $tahun;
    }

    public function index()
    {
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()->route('home.dashboard')->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        if (Gate::allows('admin')) {
            $esertifikat = Esertifikat::whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->with([
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.peserta.kelas.kompetensi',
                    'peserta_pkl.dudi',
                    'peserta_pkl.nilai_pkl',
                ])->get();
        } elseif (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $esertifikat = Esertifikat::whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi, $tahunAktif) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                    ->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->with([
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.peserta.kelas.kompetensi',
                    'peserta_pkl.dudi',
                    'peserta_pkl.nilai_pkl',
                ])->get();
        } else {
            abort(403);
        }

        $esertifikat->each(function ($item) {
            $nilai = $item->peserta_pkl->nilai_pkl->first();

            if ($nilai) {
                $rata_sikap = (
                    $nilai->nilai_disiplin_kerja +
                    $nilai->nilai_kemajuan_kerja +
                    $nilai->nilai_kualitas_kerja +
                    $nilai->nilai_inisiatif_kreatifitas +
                    $nilai->nilai_perilaku
                ) / 5;

                $nilai_sidang = $nilai->nilai_sidang_pkl;

                $nilai_akhir = ($rata_sikap + $nilai_sidang) / 2;

                $item->rata_rata_sikap = round($rata_sikap, 2);
                $item->nilai_sidang_pkl = $nilai_sidang;
                $item->nilai_akhir = round($nilai_akhir, 2);
            } else {
                $item->rata_rata_sikap = null;
                $item->nilai_sidang_pkl = null;
                $item->nilai_akhir = null;
            }
        });

        return view('home.esertifikat.index', compact('esertifikat'));
    }


    public function cetak_depan($id)
    {
        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
        ])->findOrFail($id);

        $pengaturan = Pengaturan::latest()->first();

        return view('partials.esertifikat.depan', compact('esertifikat', 'pengaturan'));
    }

    public function cetak_belakang($id)
    {
        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
            'peserta_pkl.nilai_pkl'
        ])->findOrFail($id);

        $pengaturan = Pengaturan::latest()->first();

        $nilai = $esertifikat->peserta_pkl->nilai_pkl;

        if ($nilai) {
            $rata_rata = round((
                $nilai->nilai_disiplin_kerja +
                $nilai->nilai_kemajuan_kerja +
                $nilai->nilai_kualitas_kerja +
                $nilai->nilai_inisiatif_kreatifitas +
                $nilai->nilai_perilaku
            ) / 5, 2);

            $nilai_sidang = $nilai->nilai_sidang_pkl;
            $nilai_akhir = round(($rata_rata + $nilai_sidang) / 2, 2);

            $esertifikat->rata_rata = $rata_rata;
            $esertifikat->nilai_sidang_pkl = $nilai_sidang;
            $esertifikat->nilai_akhir = $nilai_akhir;
        } else {
            $esertifikat->rata_rata = null;
            $esertifikat->nilai_sidang_pkl = null;
            $esertifikat->nilai_akhir = null;
        }

        return view('partials.esertifikat.belakang', compact('esertifikat', 'pengaturan'));
    }

    public function cetak_depan_massal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];
        $pengaturan = Pengaturan::latest()->first();

        foreach ($ids as $id) {
            $esertifikat = Esertifikat::with([
                'peserta_pkl.peserta.user',
                'peserta_pkl.peserta.kelas.kompetensi',
                'peserta_pkl.dudi',
            ])->find($id);

            if ($esertifikat) {
                $data[] = $esertifikat;
            }
        }

        return view('partials.esertifikat.depan_massal', compact('data', 'pengaturan'));
    }

    public function cetak_belakang_massal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];
        $pengaturan = Pengaturan::latest()->first();
        $pesertaTanpaNilai = [];

        foreach ($ids as $id) {
            $esertifikat = Esertifikat::with([
                'peserta_pkl.peserta.user',
                'peserta_pkl.peserta.kelas.kompetensi',
                'peserta_pkl.dudi',
                'peserta_pkl.nilai_pkl'
            ])->find($id);

            if ($esertifikat) {
                $nilai = $esertifikat->peserta_pkl->nilai_pkl;

                if (!$nilai) {
                    $pesertaTanpaNilai[] = $esertifikat->peserta_pkl->peserta->user->name ?? 'Peserta ID: ' . $id;
                    continue;
                }

                // Hitung nilai rata-rata dan nilai akhir
                $rata_rata = round(((
                    $nilai->nilai_disiplin_kerja +
                    $nilai->nilai_kemajuan_kerja +
                    $nilai->nilai_kualitas_kerja +
                    $nilai->nilai_inisiatif_kreatifitas +
                    $nilai->nilai_perilaku
                ) / 5), 2);

                $nilai_sidang = $nilai->nilai_sidang_pkl;
                $nilai_akhir = round(($rata_rata + $nilai_sidang) / 2, 2);

                // Tambahkan ke model sementara (tidak disimpan ke DB)
                $esertifikat->rata_rata = $rata_rata;
                $esertifikat->nilai_sidang_pkl = $nilai_sidang;
                $esertifikat->nilai_akhir = $nilai_akhir;

                $data[] = $esertifikat;
            }
        }

        if (!empty($pesertaTanpaNilai)) {
            return redirect()->back()->with(
                'error',
                'Peserta berikut belum memiliki nilai: ' . implode(', ', $pesertaTanpaNilai)
            );
        }

        return view('partials.esertifikat.belakang_massal', compact('data', 'pengaturan'));
    }

    public function destroy($id)
    {
        $esertifikat = Esertifikat::findOrFail($id);
        $esertifikat->delete();

        return redirect()->route('home.esertifikat')->with('success', 'E-sertifikat berhasil dihapus.');
    }

    public function destroy_massal(Request $request)
    {
        $ids = $request->ids ?? [];
        Esertifikat::whereIn('id', $ids)->delete();
        return response()->json(['message' => 'Sertifikat berhasil dihapus.']);
    }

    public function scan($nomor_sertifikat)
    {
        $nomor_sertifikat = urldecode($nomor_sertifikat);

        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
        ])->where('nomor_sertifikat', $nomor_sertifikat)->firstOrFail();

        $pengaturan = Pengaturan::latest()->first();

        return view('home.esertifikat.show', compact('esertifikat', 'pengaturan'));
    }
}
