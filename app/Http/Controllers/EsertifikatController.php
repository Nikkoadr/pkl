<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
            $kaprodi = \App\Models\Kaprodi::where('user_id', $user->id)->first();

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
