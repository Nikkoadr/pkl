<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use App\Models\Pengaturan;

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
        $peserta = Peserta_pkl::with([
            'peserta.user',
            'peserta.kelas.kompetensi',
            'dudi',
            'nilai_pkl'
        ])->get();
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

        foreach ($ids as $id) {
            $peserta_pkl = Peserta_pkl::with([
                'peserta.user',
                'peserta.kelas.kompetensi',
                'dudi',
                'nilai_pkl'
            ])->find($id);

            if ($peserta_pkl) {
                $data[] = $peserta_pkl;
            }
        }

        return view('partials.esertifikat.belakang_massal', compact('data', 'pengaturan'));
    }
}
