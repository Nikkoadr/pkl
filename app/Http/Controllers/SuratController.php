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
        if (Gate::allows('admin')) {
            $dudiList = Dudi::has('peserta_pkl')
                ->withCount('peserta_pkl')
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        if (Gate::allows('prodi')) {
            $user = Auth::user();

            // Ambil kompetensi keahlian dari kaprodi
            $kaprodi = Kaprodi::where('user_id', $user->id)->first();
            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $dudiList = Dudi::whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })
                ->withCount(['peserta_pkl' => function ($q) use ($kaprodi) {
                    $q->whereHas('peserta.kelas', function ($qq) use ($kaprodi) {
                        $qq->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                    });
                }])
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        if (Gate::allows('guru_pembimbing')) {
            $user = Auth::user();

            // ambil guru dari user
            $guru = Guru::where('user_id', $user->id)->first();
            if (!$guru) {
                abort(403, 'Anda tidak terdaftar sebagai Guru');
            }

            // ambil daftar dudi yang dibimbing guru
            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $dudiList = Dudi::whereIn('id', $dudi_ids)
                ->withCount('peserta_pkl')
                ->get();

            return view('home.surat.index', compact('dudiList'));
        }

        abort(403);
    }

    public function cetakPermohonan($dudi_id)
    {
        $peserta = Peserta::with('kelas.kompetensi')
            ->whereHas('peserta_pkl', fn($q) => $q->where('dudi_id', $dudi_id))
            ->get();

        $firstPeserta = $peserta->first();

        $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';
        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
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
        $tanggal_mulai = \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
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

    public function cetakPermohonanMassal(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $data = [];

        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
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
        $tanggal_mulai = \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y');
        $tanggal_selesai = \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y');
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
}
