<?php

namespace App\Http\Controllers;

use App\Models\Tahun_ajaran;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;
use Illuminate\Support\Str;
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
        $tahun_jaran = Tahun_ajaran::findOrFail($id_tahun_ajaran);
        $nama_tahun = Str::slug($tahun_jaran->nama_tahun_ajaran);
        $nama_file = 'arsip_PKL_' . $nama_tahun . Carbon::now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new ArsipExport($id_tahun_ajaran), $nama_file);
    }
}
