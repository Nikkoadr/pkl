<?php

namespace App\Http\Controllers;

use App\Models\Tahun_ajaran;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;
use Illuminate\Support\Carbon;

class ArsipController extends Controller
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
        $tahun_ajaran = Tahun_ajaran::latest()->get();
        return view('home.arsip.index', compact('tahun_ajaran'));
    }

    public function export_arsip($id_tahun_ajaran)
    {
        $tahunAjaran = Tahun_ajaran::findOrFail($id_tahun_ajaran);

        $namaFile = 'arsip_PKL_' . $tahunAjaran->tahun_ajaran . '.xlsx';
 

        return Excel::download(new ArsipExport($id_tahun_ajaran), $namaFile);
    }
}
