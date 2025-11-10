<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Models\Guru;
use App\Models\Guru_pembimbing;
use App\Models\Peserta;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Peserta_pklExport;
use Illuminate\Support\Carbon;

class PesertaPklController extends Controller
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
            $peserta_pkl = Peserta_pkl::with(['dudi', 'peserta.user', 'peserta.kelas.kompetensi'])->get();
            return view('home.peserta_pkl.index', compact('peserta_pkl'));
        }

        if (Gate::allows('prodi')) {
            $user = Auth::user();

            $guru = $user->guru;
            $kaprodi = Kaprodi::where('guru_id', $guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $peserta_pkl = Peserta_pkl::with([
                'dudi',
                'peserta.user',
                'peserta.kelas.kompetensi'
            ])->whereHas('peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })->get();

            return view('home.peserta_pkl.index', compact('peserta_pkl'));
        }



        if (Gate::allows('guru_pembimbing')) {
            $user = Auth::user();

            $guru = Guru::where('user_id', $user->id)->first();
            if (!$guru) {
                abort(403, 'Anda tidak terdaftar sebagai Guru Pembimbing');
            }

            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $peserta_pkl = Peserta_pkl::with(['dudi', 'peserta.user', 'peserta.kelas.kompetensi'])
                ->whereIn('dudi_id', $dudi_ids)
                ->get();

            return view('home.peserta_pkl.index', compact('peserta_pkl'));
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required',
            'peserta_id' => 'required',
        ]);

        $sudahTerdaftar = Peserta_pkl::where('peserta_id', $request->peserta_id)->exists();

        if ($sudahTerdaftar) {
            return redirect()->back()->withErrors(['peserta_id' => 'Peserta ini sudah terdaftar di tempat PKL lain.'])->withInput();
        }

        Peserta_pkl::create([
            'dudi_id' => $request->dudi_id,
            'peserta_id' => $request->peserta_id,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    function edit(Request $request, $id)
    {
        $data = Peserta_pkl::findOrFail($id);
        return view('home.peserta_pkl.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dudi_id' => 'required',
            'peserta_id' => 'required',
        ]);

        $duplikat = Peserta_pkl::where('peserta_id', $request->peserta_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($duplikat) {
            return redirect()->back()->withErrors([
                'peserta_id' => 'Peserta ini sudah terdaftar di tempat PKL lain.'
            ])->withInput();
        }

        $peserta_pkl = Peserta_pkl::findOrFail($id);
        $peserta_pkl->update([
            'dudi_id' => $request->dudi_id,
            'peserta_id' => $request->peserta_id,
        ]);

        return redirect()->route('peserta_pkl.index')->with('success', 'Data berhasil diupdate');
    }

    public function export()
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        return Excel::download(new Peserta_pklExport, 'peserta_pkl_' . $tanggal . '.xlsx');
    }

    function destroy($id)
    {
        $peserta_pkl = Peserta_pkl::findOrFail($id);
        $peserta_pkl->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
