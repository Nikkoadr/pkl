<?php

namespace App\Http\Controllers;

use App\Models\Nilai_pkl;
use App\Models\Peserta_pkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Sidang_pkl;
use App\Models\Kaprodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SidangPklController extends Controller
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
    private function hitungNilaiAkhir($nilai)
    {
        if (!$nilai) return null;

        $rataSikap = (
            $nilai->nilai_disiplin_kerja +
            $nilai->nilai_kemajuan_kerja +
            $nilai->nilai_kualitas_kerja +
            $nilai->nilai_inisiatif_kreatifitas +
            $nilai->nilai_perilaku
        ) / 5;

        return round(($rataSikap + $nilai->nilai_sidang_pkl) / 2, 2);
    }

    public function index()
    {
        $user = Auth::user();
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()->route('home.dashboard')->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $pesertaSudahSidang = Sidang_pkl::pluck('peserta_pkl_id');

        if (Gate::allows('admin')) {

            $sidang_pkl = Sidang_pkl::with([
                'guru.user',
                'peserta_pkl.peserta.user',
                'peserta_pkl.peserta.kelas',
                'peserta_pkl.nilai_pkl',
                'peserta_pkl.dudi'
            ])
                ->whereHas('peserta_pkl.nilai_pkl')
                ->whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->get();

            $sidang_pkl->each(function ($item) {
                if ($item->peserta_pkl && $item->peserta_pkl->nilai_pkl) {
                    $nilai = $item->peserta_pkl->nilai_pkl;
                    $nilai->nilai_akhir_pkl = $this->hitungNilaiAkhir($nilai);
                }
            });

            $peserta_pkl = Peserta_pkl::whereNotIn('id', $pesertaSudahSidang)
                ->whereHas('nilai_pkl')
                ->whereHas('peserta', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->with([
                    'peserta.user',
                    'peserta.kelas',
                    'dudi'
                ])
                ->get();

            return view('home.sidang_pkl.index', compact('sidang_pkl', 'peserta_pkl'));
        }

        if (Gate::allows('prodi')) {

            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $sidang_pkl = Sidang_pkl::whereHas('peserta_pkl.nilai_pkl')
                ->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi, $tahunAktif) {
                    $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                        ->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->with([
                    'guru.user',
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.peserta.kelas',
                    'peserta_pkl.nilai_pkl',
                    'peserta_pkl.dudi'
                ])
                ->get();

            $sidang_pkl->each(function ($item) {
                if ($item->peserta_pkl && $item->peserta_pkl->nilai_pkl) {
                    $nilai = $item->peserta_pkl->nilai_pkl;
                    $nilai->nilai_akhir_pkl = $this->hitungNilaiAkhir($nilai);
                }
            });

            $peserta_pkl = Peserta_pkl::whereHas('peserta.kelas', function ($q) use ($kaprodi, $tahunAktif) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                    ->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->whereNotIn('id', $pesertaSudahSidang)
                ->whereHas('nilai_pkl')
                ->with([
                    'peserta.user',
                    'peserta.kelas',
                    'dudi'
                ])
                ->get();

            return view('home.sidang_pkl.index', compact('sidang_pkl', 'peserta_pkl'));
        }

        if (Gate::allows('guru_penguji')) {

            $guruId = $user->guru->id;

            $sidang_pkl = Sidang_pkl::where('guru_id', $guruId)
                ->whereHas('peserta_pkl.nilai_pkl')
                ->whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->with([
                    'guru.user',
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.peserta.kelas',
                    'peserta_pkl.nilai_pkl',
                    'peserta_pkl.dudi'
                ])
                ->get();

            $sidang_pkl->each(function ($item) {
                if ($item->peserta_pkl && $item->peserta_pkl->nilai_pkl) {
                    $nilai = $item->peserta_pkl->nilai_pkl;
                    $nilai->nilai_akhir_pkl = $this->hitungNilaiAkhir($nilai);
                }
            });

            return view('home.sidang_pkl.index', compact('sidang_pkl'));
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini');
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',

            'peserta_pkl_id' => 'required|array',
            'peserta_pkl_id.*' => 'exists:peserta_pkl,id',
        ]);

        $tanggal_sidang = now()->toDateString();

        $pesertaSudahAda = Sidang_pkl::whereIn('peserta_pkl_id', $request->peserta_pkl_id)
            ->where('guru_id', '!=', $request->guru_id)
            ->pluck('peserta_pkl_id')
            ->toArray();

        if (!empty($pesertaSudahAda)) {
            $namaPeserta = Peserta_pkl::whereIn('id', $pesertaSudahAda)
                ->with('peserta.user')
                ->get()
                ->map(fn($p) => $p->peserta->user->nama ?? '-')
                ->toArray();

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Peserta berikut sudah memiliki guru penguji lain: ' . implode(', ', $namaPeserta)
                );
        }

        $pesertaBelumDinilai = Peserta_pkl::whereIn('id', $request->peserta_pkl_id)
            ->whereDoesntHave('nilai_pkl')
            ->with('peserta.user')
            ->get();

        if ($pesertaBelumDinilai->count() > 0) {
            $namaPeserta = $pesertaBelumDinilai
                ->map(fn($p) => $p->peserta->user->nama ?? '-')
                ->toArray();

            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Peserta berikut belum memiliki nilai PKL sehingga tidak dapat disidangkan: '
                        . implode(', ', $namaPeserta)
                );
        }

        foreach ($request->peserta_pkl_id as $pesertaId) {
            Sidang_pkl::firstOrCreate(
                [
                    'guru_id'        => $request->guru_id,
                    'peserta_pkl_id' => $pesertaId,
                ],
                [
                    'tanggal_sidang' => $tanggal_sidang,
                ]
            );
        }

        return redirect()
            ->route('sidang_pkl.index')
            ->with('success', 'Data sidang PKL berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $nilai_sidang_pkl = Nilai_pkl::with('peserta_pkl.peserta.user')->findOrFail($id);

        return view('home.sidang_pkl.edit', compact('nilai_sidang_pkl'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_sidang_pkl' => 'required|numeric|min:0|max:100',
            'komentar'     => 'nullable|string',
        ]);

        $nilai_sidang_pkl = Nilai_pkl::findOrFail($id);
        $nilai_sidang_pkl->update([
            'nilai_sidang_pkl' => $request->nilai_sidang_pkl,
            'komentar'     => $request->komentar,
        ]);

        return redirect()
            ->route('sidang_pkl.index')
            ->with('success', 'Data nilai sidang PKL berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sidang_pkl = Sidang_pkl::findOrFail($id);
        $sidang_pkl->delete();

        return redirect()->route('sidang_pkl.index')->with('success', 'Data sidang PKL berhasil dihapus.');
    }
}
