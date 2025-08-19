<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru_pembimbing;
use App\Models\Guru;
use App\Models\Dudi;
use Illuminate\Support\Facades\Gate;

class Guru_pembimbingController extends Controller
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
        if (Gate::allows('admin') || Gate::allows('prodi')) {
            $pembimbing = Guru_pembimbing::with('guru.user', 'dudi')->get();
            $guru = Guru::with('user')->get();
            $dudiList = Dudi::all();
            return view('home.guru_pembimbing.index', compact('pembimbing', 'guru', 'dudiList'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'dudi_id' => 'required|array',
            'dudi_id.*' => 'exists:dudi,id',
        ]);

        $sudahDipilih = Guru_pembimbing::whereIn('dudi_id', $request->dudi_id)->pluck('dudi_id')->toArray();

        if (!empty($sudahDipilih)) {
            $dudiTerpakai = Dudi::whereIn('id', $sudahDipilih)->pluck('nama_dudi')->toArray();
            return redirect()->back()
                ->withInput()
                ->with('error', 'DUDI berikut sudah dipilih oleh guru lain: ' . implode(', ', $dudiTerpakai));
        }

        foreach ($request->dudi_id as $dudiId) {
            Guru_pembimbing::create([
                'guru_id' => $request->guru_id,
                'dudi_id' => $dudiId,
            ]);
        }

        return redirect()->back()->with('success', 'Guru pembimbing berhasil ditambahkan.');
    }



    public function edit($id)
    {
        $data = Guru_pembimbing::with(['guru.user', 'dudi'])->findOrFail($id);
        return view('home.guru_pembimbing.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'dudi_id' => 'required|exists:dudi,id',
        ]);

        $data = Guru_pembimbing::findOrFail($id);
        $data->update([
            'guru_id' => $request->guru_id,
            'dudi_id' => $request->dudi_id,
        ]);

        return redirect()->route('guru_pembimbing.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembimbing = Guru_pembimbing::findOrFail($id);
        $pembimbing->delete();

        return redirect()->back()->with('success', 'Guru pembimbing berhasil dihapus.');
    }
}
