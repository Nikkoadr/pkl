<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tempat_pkl;

class Tempat_pklController extends Controller
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
        $tempat_pkl = Tempat_pkl::with(['dudi', 'peserta.user'])->get();
        return view('home.tempat_pkl.index', compact('tempat_pkl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required',
            'peserta_id' => 'required',
        ]);

        $sudahTerdaftar = Tempat_pkl::where('peserta_id', $request->peserta_id)->exists();

        if ($sudahTerdaftar) {
            return redirect()->back()->withErrors(['peserta_id' => 'Peserta ini sudah terdaftar di tempat PKL lain.'])->withInput();
        }

        Tempat_pkl::create([
            'dudi_id' => $request->dudi_id,
            'peserta_id' => $request->peserta_id,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    function edit(Request $request, $id)
    {
        $data = Tempat_pkl::findOrFail($id);
        return view('home.tempat_pkl.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dudi_id' => 'required',
            'peserta_id' => 'required',
        ]);

        $duplikat = Tempat_pkl::where('peserta_id', $request->peserta_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($duplikat) {
            return redirect()->back()->withErrors([
                'peserta_id' => 'Peserta ini sudah terdaftar di tempat PKL lain.'
            ])->withInput();
        }

        $tempat_pkl = Tempat_pkl::findOrFail($id);
        $tempat_pkl->update([
            'dudi_id' => $request->dudi_id,
            'peserta_id' => $request->peserta_id,
        ]);

        return redirect()->route('tempat_pkl.index')->with('success', 'Data berhasil diupdate');
    }


    function destroy($id)
    {
        $tempat_pkl = Tempat_pkl::findOrFail($id);
        $tempat_pkl->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
