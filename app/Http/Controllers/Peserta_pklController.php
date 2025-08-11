<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta_pkl;

class Peserta_pklController extends Controller
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
        $this->authorize('admin');
        $peserta_pkl = Peserta_pkl::with(['dudi', 'peserta.user'])->get();
        return view('home.peserta_pkl.index', compact('peserta_pkl'));
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


    function destroy($id)
    {
        $peserta_pkl = Peserta_pkl::findOrFail($id);
        $peserta_pkl->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
