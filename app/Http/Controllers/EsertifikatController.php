<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Models\Nilai_pkl;
use App\Models\Esertifikat;
use Illuminate\Support\Facades\DB;

class EsertifikatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function generate($id)
    {
        $nilai = Nilai_pkl::with('peserta_pkl.peserta.user')->findOrFail($id);

        if (!$this->isComplete($nilai)) {
            return back()->with('error', 'Tidak dapat membuat e-sertifikat. Nilai belum lengkap.');
        }

        // Cek apakah sudah ada sertifikat
        if ($nilai->esertifikat) {
            return back()->with('error', 'E-sertifikat sudah pernah digenerate untuk peserta ini.');
        }

        try {
            DB::transaction(function () use ($nilai) {
                // Buat sertifikat
                $esertifikat = $nilai->esertifikat()->create([
                    'peserta_pkl_id' => $nilai->peserta_pkl_id,
                    'nomor_sertifikat' => $this->generateNomor(),
                    'tanggal_diterbitkan' => now(),
                ]);

                // Simpan detail nilainya
                $esertifikat->detail()->create([
                    'nilai_disiplin_kerja' => $nilai->nilai_disiplin_kerja,
                    'nilai_kemajuan_kerja' => $nilai->nilai_kemajuan_kerja,
                    'nilai_kualitas_kerja' => $nilai->nilai_kualitas_kerja,
                    'nilai_inisiatif_kreatifitas' => $nilai->nilai_inisiatif_kreatifitas,
                    'nilai_perilaku' => $nilai->nilai_perilaku,
                    'nilai_sidang_pkl' => $nilai->nilai_sidang_pkl,
                    'komentar' => $nilai->komentar,
                ]);
            });

            return back()->with('success', 'E-sertifikat berhasil digenerate.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate massal e-sertifikat
     */
    public function generate_massal(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $berhasil = 0;
        $gagal = 0;

        try {
            DB::transaction(function () use ($ids, &$berhasil, &$gagal) {
                $dataNilai = Nilai_pkl::with('peserta_pkl.peserta.user', 'esertifikat')
                    ->whereIn('id', $ids)
                    ->get();

                foreach ($dataNilai as $nilai) {
                    // Lewati jika belum lengkap atau sudah punya sertifikat
                    if (!$this->isComplete($nilai) || $nilai->esertifikat) {
                        $gagal++;
                        continue;
                    }

                    // Generate sertifikat dan detail
                    $esertifikat = $nilai->esertifikat()->create([
                        'peserta_pkl_id' => $nilai->peserta_pkl_id,
                        'nomor_sertifikat' => $this->generateNomor(),
                        'tanggal_diterbitkan' => now(),
                    ]);

                    $esertifikat->detail()->create([
                        'nilai_disiplin_kerja' => $nilai->nilai_disiplin_kerja,
                        'nilai_kemajuan_kerja' => $nilai->nilai_kemajuan_kerja,
                        'nilai_kualitas_kerja' => $nilai->nilai_kualitas_kerja,
                        'nilai_inisiatif_kreatifitas' => $nilai->nilai_inisiatif_kreatifitas,
                        'nilai_perilaku' => $nilai->nilai_perilaku,
                        'nilai_sidang_pkl' => $nilai->nilai_sidang_pkl,
                        'komentar' => $nilai->komentar,
                    ]);

                    $berhasil++;
                }
            });

            return back()->with('success', "E-sertifikat berhasil dibuat: {$berhasil}, gagal: {$gagal}");
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cek kelengkapan nilai
     */
    private function isComplete($nilai)
    {
        return $nilai->nilai_disiplin_kerja !== null &&
            $nilai->nilai_kemajuan_kerja !== null &&
            $nilai->nilai_kualitas_kerja !== null &&
            $nilai->nilai_inisiatif_kreatifitas !== null &&
            $nilai->nilai_perilaku !== null &&
            $nilai->nilai_sidang_pkl !== null;
    }

    /**
     * Generate nomor sertifikat unik
     */
    private function generateNomor()
    {
        $count = Esertifikat::count() + 1;
        return 'EPKL-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        if (Gate::allows('admin')) {
            // Admin → semua peserta PKL
            $peserta = Peserta_pkl::with([
                'peserta.user',
                'peserta.kelas.kompetensi',
                'dudi',
                'nilai_pkl'
            ])->get();
        } elseif (Gate::allows('prodi')) {
            // Prodi → peserta PKL sesuai kompetensi keahlian kaprodinya
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $peserta = Peserta_pkl::whereHas('peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })
                ->with([
                    'peserta.user',
                    'peserta.kelas.kompetensi',
                    'dudi',
                    'nilai_pkl'
                ])
                ->get();
        } else {
            abort(403);
        }

        return view('home.esertifikat.index', compact('peserta'));
    }


    public function cetak_depan($id)
    {
        $peserta = Peserta_pkl::with([
            'peserta.user',
            'peserta.kelas.kompetensi',
            'dudi'
        ])->find($id);
        $pengaturan = Pengaturan::latest()->first();
        return view('partials.esertifikat.depan', compact('peserta', 'pengaturan'));
    }

    public function cetak_belakang($id)
    {
        $peserta_pkl = Peserta_pkl::with([
            'peserta.user',
            'peserta.kelas.kompetensi',
            'dudi',
            'nilai_pkl'
        ])->find($id);

        if (!$peserta_pkl->nilai_pkl || $peserta_pkl->nilai_pkl->isEmpty()) {
            return redirect()->back()->with('error', 'Nilai PKL belum diisi untuk peserta ini.');
        }

        $pengaturan = Pengaturan::latest()->first();
        return view('partials.esertifikat.belakang', compact('peserta_pkl', 'pengaturan'));
    }

    public function cetak_depan_massal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];

        $pengaturan = Pengaturan::latest()->first();

        foreach ($ids as $id) {
            $peserta = Peserta_pkl::with([
                'peserta.user',
                'peserta.kelas.kompetensi',
                'dudi'
            ])->find($id);

            if ($peserta) {
                $data[] = $peserta;
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
            $peserta_pkl = Peserta_pkl::with([
                'peserta.user',
                'peserta.kelas.kompetensi',
                'dudi',
                'nilai_pkl'
            ])->find($id);

            if ($peserta_pkl) {
                if (!$peserta_pkl->nilai_pkl || $peserta_pkl->nilai_pkl->isEmpty()) {
                    $pesertaTanpaNilai[] = $peserta_pkl->peserta->user->name ?? 'Peserta ID: ' . $id;
                } else {
                    $data[] = $peserta_pkl;
                }
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
}
