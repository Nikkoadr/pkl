<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Models\Esertifikat;
use App\Models\Nilai_pkl;
use App\Models\Kelas;
use App\Models\Kompetensi_keahlian;
use App\Helpers\EsertifikatHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    private function generateNomor()
    {
        $tahun = date('Y');

        $count = Esertifikat::whereYear('tanggal_diterbitkan', $tahun)->count() + 1;

        return '086.' . str_pad($count, 3, '0', STR_PAD_LEFT)
            . '/KET/III.4/AU/F/' . $tahun;
    }

    public function generate($id)
    {
        $nilai_pkl = Nilai_pkl::with('peserta_pkl.peserta.user')->findOrFail($id);

        $lengkap = !(
            $nilai_pkl->nilai_disiplin_kerja === null ||
            $nilai_pkl->nilai_kemajuan_kerja === null ||
            $nilai_pkl->nilai_kualitas_kerja === null ||
            $nilai_pkl->nilai_inisiatif_kreatifitas === null ||
            $nilai_pkl->nilai_perilaku === null ||
            $nilai_pkl->nilai_sidang_pkl === null
        );

        if (!$lengkap) {
            return back()->with('error', 'Tidak dapat membuat e-sertifikat. Nilai peserta belum lengkap.');
        }

        $sudahAda = Esertifikat::where('peserta_pkl_id', $nilai_pkl->peserta_pkl_id)->exists();
        if ($sudahAda) {
            return back()->with('error', 'Sertifikat peserta tersebut sudah pernah digenerate.');
        }
        Esertifikat::create([
            'peserta_pkl_id'       => $nilai_pkl->peserta_pkl_id,
            'nomor_sertifikat'     => $this->generateNomor(),
            'kepala_sekolah'       => Pengaturan::value('kepala_sekolah') ?? '',
            'tanggal_mulai_pkl'    => Pengaturan::value('tanggal_mulai_pkl') ?? null,
            'tanggal_selesai_pkl'  => Pengaturan::value('tanggal_selesai_pkl') ?? null,
            'tanggal_diterbitkan'  => now(),
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
        $listGagal = [];

        $dataNilai = Nilai_pkl::with('peserta_pkl.peserta.user')
            ->whereIn('id', $ids)
            ->get();

        foreach ($dataNilai as $nilai) {

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
                $listGagal[] = $nilai->peserta_pkl->peserta->user->nama . " (nilai belum lengkap)";
                continue;
            }

            $sudahAda = Esertifikat::where('peserta_pkl_id', $nilai->peserta_pkl_id)->exists();
            if ($sudahAda) {
                $gagal++;
                $listGagal[] = $nilai->peserta_pkl->peserta->user->nama . " (sertifikat sudah ada)";
                continue;
            }

            try {
                Esertifikat::create([
                    'peserta_pkl_id' => $nilai->peserta_pkl_id,
                    'nomor_sertifikat' => $this->generateNomor(),
                    'kepala_sekolah'       => Pengaturan::value('kepala_sekolah') ?? '',
                    'tanggal_mulai_pkl'    => Pengaturan::value('tanggal_mulai_pkl') ?? null,
                    'tanggal_selesai_pkl'  => Pengaturan::value('tanggal_selesai_pkl') ?? null,
                    'tanggal_diterbitkan' => now(),
                ]);

                $berhasil++;
            } catch (\Throwable $e) {
                $gagal++;
                $listGagal[] = $nilai->peserta_pkl->peserta->user->nama . " (error sistem)";
            }
        }

        $pesanGagal = "";
        if (count($listGagal) > 0) {
            $pesanGagal = "<br><br><strong>Daftar peserta gagal:</strong><br>- " . implode("<br>- ", $listGagal);
        }

        return back()->with('success', "E-sertifikat berhasil dibuat: {$berhasil}, gagal: {$gagal} {$pesanGagal}");
    }

    public function index(Request $request)
    {
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()
                ->route('home.dashboard')
                ->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $query = Esertifikat::whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran_id', $tahunAktif->id);
        });

        $kaprodi = null;

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda bukan Kaprodi');
            }

            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            });
        }


        if ($request->filled('kompetensi')) {
            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($request) {
                $q->where('kompetensi_keahlian_id', $request->kompetensi);
            });
        }

        if ($request->filled('kompetensi') && $request->filled('kelas')) {
            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($request) {
                $q->where('id', $request->kelas);
            });
        }

        $esertifikat = $query->with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
            'peserta_pkl.nilai_pkl',
        ])->get();

        $esertifikat->each(function ($item) {
            $peserta = $item->peserta_pkl->peserta ?? null;
            $nilai   = $item->peserta_pkl->nilai_pkl ?? null;

            $item->nisn       = $peserta->nisn ?? '-';
            $item->nama       = $peserta->user->nama ?? '-';
            $item->kelas      = $peserta->kelas->nama_kelas ?? '-';
            $item->kompetensi = $peserta->kelas->kompetensi->nama_kompetensi ?? '-';
            $item->nama_dudi  = $item->peserta_pkl->dudi->nama_dudi ?? '-';

            if ($nilai) {
                $rataSikap = (
                    $nilai->nilai_disiplin_kerja +
                    $nilai->nilai_kemajuan_kerja +
                    $nilai->nilai_kualitas_kerja +
                    $nilai->nilai_inisiatif_kreatifitas +
                    $nilai->nilai_perilaku
                ) / 5;

                $item->rata_rata_sikap  = round($rataSikap);
                $item->nilai_sidang_pkl = $nilai->nilai_sidang_pkl;
                $item->nilai_akhir      = round(($rataSikap + $nilai->nilai_sidang_pkl) / 2);
            }
        });

        if (Gate::allows('prodi')) {
            $listKompetensi = Kompetensi_keahlian::where(
                'id',
                $kaprodi->kompetensi_keahlian_id
            )->get();
        } else {
            $listKompetensi = Kompetensi_keahlian::orderBy('nama_kompetensi')->get();
        }

        $listKelas = collect();
        if ($request->filled('kompetensi')) {
            $listKelas = Kelas::where('kompetensi_keahlian_id', $request->kompetensi)
                ->orderBy('nama_kelas')
                ->get();
        }

        return view('home.esertifikat.index', compact(
            'esertifikat',
            'listKompetensi',
            'listKelas'
        ));
    }

    public function cetak_depan($id)
    {
        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
        ])->findOrFail($id);

        $user = $esertifikat->peserta_pkl->peserta->user ?? null;

        $foto = $user?->foto_profil
            ? asset('storage/foto_profil/' . $user->foto_profil)
            : asset('assets/dist/img/foto-default.jpeg');

        $qrWithLogo = base64_encode(
            QrCode::format('png')
                ->size(220)
                ->margin(1)
                ->errorCorrection('H')
                ->merge(public_path('assets/dist/img/logo_barcode.png'), 0.25, true)
                ->generate(url('/esertifikat/scan/' . $esertifikat->hash))
        );

        return view('partials.esertifikat.depan', compact('esertifikat', 'user', 'foto', 'qrWithLogo'));
    }


    public function cetak_belakang($id)
    {
        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
            'peserta_pkl.nilai_pkl'
        ])->findOrFail($id);

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

        return view('partials.esertifikat.belakang', compact('esertifikat',));
    }

    public function cetak_depan_massal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
        ])->find($ids)->filter()->values();

        $data->transform(function ($row) {
            $user = $row->peserta_pkl->peserta->user ?? null;

            $row->nama = $user?->nama ?? '-';
            $row->foto = $user?->foto_profil
                ? asset('storage/foto_profil/' . $user->foto_profil)
                : asset('assets/dist/img/foto-default.jpeg');

            $qrSize = 600;
            $logoScale = 0.30;
            $row->qrWithLogo = base64_encode(
                QrCode::format('png')
                    ->size($qrSize)
                    ->margin(1)
                    ->errorCorrection('H')
                    ->merge(public_path('assets/dist/img/logo_barcode.png'), $logoScale, true)
                    ->generate(url('/esertifikat/scan/' . $row->hash))
            );

            return $row;
        });

        return view('partials.esertifikat.depan_massal', compact('data'));
    }

    public function cetak_belakang_massal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];
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

                $rata_rata = round(((
                    $nilai->nilai_disiplin_kerja +
                    $nilai->nilai_kemajuan_kerja +
                    $nilai->nilai_kualitas_kerja +
                    $nilai->nilai_inisiatif_kreatifitas +
                    $nilai->nilai_perilaku
                ) / 5), 2);

                $nilai_sidang = $nilai->nilai_sidang_pkl;
                $nilai_akhir = round(($rata_rata + $nilai_sidang) / 2, 2);

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

        return view('partials.esertifikat.belakang_massal', compact('data'));
    }

    public function destroy($id)
    {
        $esertifikat = Esertifikat::findOrFail($id);
        $esertifikat->delete();

        return redirect()->route('esertifikat.index')->with('success', 'E-sertifikat berhasil dihapus.');
    }

    public function destroy_massal(Request $request)
    {
        $ids = $request->ids ?? [];
        if (empty($ids)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang dipilih.'
            ]);
        }
        Esertifikat::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'E-sertifikat berhasil dihapus.'
        ]);
    }

    public function scan($hash)
    {
        $esertifikat = Esertifikat::with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas.kompetensi',
            'peserta_pkl.dudi',
            'peserta_pkl.nilai_pkl',
        ])->where('hash', $hash)->first();

        if (!$esertifikat) {
            return view('home.esertifikat.invalid');
        }

        // Ambil data peserta dan user
        $user       = $esertifikat->peserta_pkl->peserta->user ?? null;
        $peserta    = $esertifikat->peserta_pkl->peserta ?? null;
        $kelas      = $peserta->kelas ?? null;
        $kompetensi = $kelas->kompetensi ?? null;
        $dudi       = $esertifikat->peserta_pkl->dudi ?? null;

        // Nama dan foto
        $nama = $user?->nama ?? '-';
        $foto = $user?->foto_profil
            ? asset('storage/foto_profil/' . $user->foto_profil)
            : asset('assets/dist/img/foto-default.jpeg');

        // QR Code dengan logo
        $qrWithLogo = base64_encode(
            QrCode::format('png')
                ->size(220)
                ->margin(1)
                ->errorCorrection('H')
                ->merge(public_path('assets/dist/img/logo_barcode.png'), 0.25, true)
                ->generate(url('/esertifikat/scan/' . $esertifikat->hash))
        );

        // Nomor fallback
        $nomorFallback = '086.' . str_pad($esertifikat->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y');

        // Hitung nilai jika ada
        $nilai = $esertifikat->peserta_pkl->nilai_pkl;
        if ($nilai) {
            $nilai_aspek = [
                'Disiplin Kerja'        => $nilai->nilai_disiplin_kerja,
                'Kemajuan Kerja'        => $nilai->nilai_kemajuan_kerja,
                'Kualitas Kerja'        => $nilai->nilai_kualitas_kerja,
                'Inisiatif & Kreativitas' => $nilai->nilai_inisiatif_kreatifitas,
                'Perilaku'              => $nilai->nilai_perilaku,
            ];

            $rata_rata    = round(array_sum($nilai_aspek) / count($nilai_aspek), 2);
            $nilai_sidang = $nilai->nilai_sidang_pkl;
            $nilai_akhir  = round(($rata_rata + $nilai_sidang) / 2, 2);

            $predikat_akhir = EsertifikatHelper::predikat($nilai_akhir);
            $catatan_sikap  = EsertifikatHelper::catatan_sikap($nilai_aspek);

            $esertifikat->rata_rata        = $rata_rata;
            $esertifikat->nilai_sidang_pkl = $nilai_sidang;
            $esertifikat->nilai_akhir      = $nilai_akhir;
            $esertifikat->predikat         = $predikat_akhir;
            $esertifikat->catatan_sikap    = $catatan_sikap;
        } else {
            $esertifikat->rata_rata        = null;
            $esertifikat->nilai_sidang_pkl = null;
            $esertifikat->nilai_akhir      = null;
            $esertifikat->predikat         = null;
            $esertifikat->catatan_sikap    = null;
        }

        // Kirim semua data ke view
        return view('home.esertifikat.show', compact(
            'esertifikat',
            'nilai',
            'user',
            'peserta',
            'kelas',
            'kompetensi',
            'dudi',
            'nama',
            'foto',
            'qrWithLogo',
            'nomorFallback'
        ));
    }
}
