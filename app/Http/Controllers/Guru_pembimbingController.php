<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru_pembimbing;
use App\Models\Guru;
use App\Models\Dudi;

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
        $pembimbing = Guru_pembimbing::with('guru.user', 'dudi')->get();
        $guru = Guru::with('user')->get();
        $dudi = Dudi::all();
        return view('home.guru_pembimbing.index', compact('pembimbing', 'guru', 'dudi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'dudi_id' => 'required|exists:dudi,id',
        ]);

        Guru_pembimbing::create($validated);

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
