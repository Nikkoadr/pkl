<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Peserta;
use App\Models\Dudi;
use App\Models\Guru_pembimbing;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $logbook = Logbook::with(['peserta', 'dudi'])->latest()->get();
        $peserta = Peserta::all();
        $dudi = Dudi::all();

        return view('home.logbook.index', compact('logbook', 'peserta', 'dudi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'dudi_id' => 'required|exists:dudi,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $path = $file->store('foto_bukti', 'public');
            $data['foto_bukti'] = $path;
        }

        Logbook::create($data);

        return redirect()->back()->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $logbook = Logbook::findOrFail($id);
        $peserta = Peserta::all();
        $dudi = Dudi::all();

        return view('logbook.edit', compact('logbook', 'peserta', 'dudi'));
    }

    public function update(Request $request, $id)
    {
        $logbook = Logbook::findOrFail($id);

        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'dudi_id' => 'required|exists:dudi,id',
            'guru_pembimbing_id' => 'required|exists:guru_pembimbing,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $path = $file->store('foto_bukti', 'public');
            $data['foto_bukti'] = $path;
        }

        $logbook->update($data);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $logbook = Logbook::findOrFail($id);
        $logbook->delete();

        return redirect()->back()->with('success', 'Logbook berhasil dihapus.');
    }
}
