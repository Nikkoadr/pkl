<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\Peserta;
use App\Models\Pengaturan;
use App\Models\Kaprodi;
use App\Models\Guru;
use App\Models\Guru_pembimbing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
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
    public function index()
    {
        $tahunAktif = tahunAktif(); // helper global, ambil tahun ajaran aktif

        if (!$tahunAktif) {
            return redirect()->route('home.dashboard')->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        if (Gate::allows('admin')) {
            $dudiList = Dudi::whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->withCount(['peserta_pkl as peserta_pkl_count' => function ($q) use ($tahunAktif) {
                    $q->whereHas('peserta', function ($qq) use ($tahunAktif) {
                        $qq->where('tahun_ajaran_id', $tahunAktif->id);
                    });
                }])
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $dudiList = Dudi::whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi, $tahunAktif) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                    ->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->withCount(['peserta_pkl as peserta_pkl_count' => function ($q) use ($kaprodi, $tahunAktif) {
                    $q->whereHas('peserta.kelas', function ($qq) use ($kaprodi, $tahunAktif) {
                        $qq->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                            ->where('tahun_ajaran_id', $tahunAktif->id);
                    });
                }])
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        if (Gate::allows('guru')) {
            $user = Auth::user();
            $guru = Guru::where('user_id', $user->id)->first();

            if (!$guru) {
                abort(403, 'Anda tidak terdaftar sebagai Guru');
            }

            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $dudiList = Dudi::whereIn('id', $dudi_ids)
                ->withCount(['peserta_pkl as peserta_pkl_count' => function ($q) use ($tahunAktif) {
                    $q->whereHas('peserta', function ($qq) use ($tahunAktif) {
                        $qq->where('tahun_ajaran_id', $tahunAktif->id);
                    });
                }])
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        abort(403);
    }


    public function cetakKopSurat($dudi_id)
    {
        $dudi = Dudi::findOrFail($dudi_id);
        return view('partials.docx.kop_surat', compact('dudi'));
    }

    public function cetakPermohonan($dudi_id)
    {
        $peserta = Peserta::with('kelas.kompetensi')
            ->whereHas('peserta_pkl', fn($q) => $q->where('dudi_id', $dudi_id))
            ->get();

        $firstPeserta = $peserta->first();

        $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';
        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;
        $dudi = Dudi::findOrFail($dudi_id);
        return view('partials.docx.permohonan', compact('peserta', 'kompetensi', 'tanggal_mulai', 'tanggal_selesai', 'dudi', 'kepala_sekolah', 'ketua_pkl', 'sekretaris_pkl'));
    }

    public function cetakPengantar($dudi_id)
    {
        $peserta = Peserta::with(['kelas.kompetensi', 'user'])
            ->whereHas('peserta_pkl', fn($q) => $q->where('dudi_id', $dudi_id))
            ->get();
        $firstPeserta = $peserta->first();

        $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';

        $jumlah_siswa = $peserta->count();

        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;

        $dudi = Dudi::findOrFail($dudi_id);

        return view('partials.docx.pengantar', compact(
            'peserta',
            'kompetensi',
            'jumlah_siswa',
            'tanggal_mulai',
            'tanggal_selesai',
            'dudi',
            'kepala_sekolah',
            'ketua_pkl',
            'sekretaris_pkl'
        ));
    }

    public function cetakPenarikan($dudi_id)
    {
        $dudi = Dudi::findOrFail($dudi_id);

        $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';
        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;
        return view('partials.docx.penarikan', compact('tanggal_mulai', 'tanggal_selesai', 'dudi', 'kepala_sekolah', 'ketua_pkl', 'sekretaris_pkl'));
    }

    public function cetakKopSuratMassal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $data = [];
        foreach ($ids as $id) {
            $dudi = Dudi::find($id);
            $data[] = [
                'dudi' => $dudi,
            ];
        }

        return view('partials.docx.cetak_masal_kop_surat', compact('data'));
    }
    public function cetakPermohonanMassal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];

        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;

        foreach ($ids as $id) {
            $dudi = Dudi::find($id);

            if (!$dudi) {
                continue;
            }

            $peserta = Peserta::with('kelas.kompetensi')
                ->whereHas('peserta_pkl', fn($q) => $q->where('dudi_id', $id))
                ->get();

            if ($peserta->isEmpty()) {
                continue;
            }

            $firstPeserta = $peserta->first();
            $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';

            $data[] = [
                'dudi' => $dudi,
                'peserta' => $peserta,
                'kompetensi' => $kompetensi,
            ];
        }

        return view('partials.docx.cetak_masal_surat_permohonan', compact('data', 'tanggal_mulai', 'tanggal_selesai', 'kepala_sekolah', 'ketua_pkl', 'sekretaris_pkl'));
    }

    public function cetakPengantarMassal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $data = [];

        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;

        foreach ($ids as $id) {
            $dudi = Dudi::find($id);

            if (!$dudi) {
                continue;
            }

            $peserta = Peserta::with(['kelas.kompetensi', 'user'])
                ->whereHas('peserta_pkl', fn($q) => $q->where('dudi_id', $id))
                ->get();

            if ($peserta->isEmpty()) {
                continue;
            }

            $firstPeserta = $peserta->first();
            $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';
            $jumlah_siswa = $peserta->count();

            $data[] = [
                'dudi' => $dudi,
                'peserta' => $peserta,
                'kompetensi' => $kompetensi,
                'jumlah_siswa' => $jumlah_siswa,
            ];
        }
        return view('partials.docx.cetak_masal_surat_pengantar', compact('data', 'tanggal_mulai', 'tanggal_selesai', 'kepala_sekolah', 'ketua_pkl', 'sekretaris_pkl'));
    }

    public function cetakPenarikanMassal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $data = [];

        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
        $kepala_sekolah = $pengaturan->kepala_sekolah;
        $ketua_pkl = $pengaturan->ketua_pkl;
        $sekretaris_pkl = $pengaturan->sekretaris_pkl;

        foreach ($ids as $id) {
            $dudi = Dudi::find($id);

            if (!$dudi) {
                continue;
            }

            $data[] = [
                'dudi' => $dudi,
            ];
        }

        return view('partials.docx.cetak_masal_surat_penarikan', compact('data', 'tanggal_mulai', 'tanggal_selesai', 'kepala_sekolah', 'ketua_pkl', 'sekretaris_pkl'));
    }
}
