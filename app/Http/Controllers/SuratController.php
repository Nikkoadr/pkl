<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\Peserta;
use App\Models\Pengaturan;

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
        $dudiList = Dudi::has('tempatPkl')->withCount('tempatPkl')->get();
        return view('home.surat.index', compact('dudiList'));
    }

    public function cetakPermohonan($dudi_id)
    {
        $peserta = Peserta::with('kelas.kompetensi')
            ->whereHas('tempat_pkl', fn($q) => $q->where('dudi_id', $dudi_id))
            ->get();

        $firstPeserta = $peserta->first();

        $kompetensi = $firstPeserta?->kelas?->kompetensi?->nama_kompetensi ?? '—';
        $pengaturan = Pengaturan::latest()->first();
        $tanggal_mulai = \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->translatedFormat('j F Y');
        $tanggal_selesai = \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->translatedFormat('j F Y');
        $dudi = Dudi::findOrFail($dudi_id);
        return view('partials.docx.permohonan', compact('peserta', 'kompetensi', 'tanggal_mulai', 'tanggal_selesai', 'dudi'));
    }


    public function cetakPengantar($dudi_id)
    {
        $dudi = Dudi::with('tempatPkl.peserta.user')->findOrFail($dudi_id);
        return view('home.surat.cetak_pengantar', compact('dudi'));
    }
}
