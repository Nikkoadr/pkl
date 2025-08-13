<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Peserta;
use App\Models\Dudi;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $logbook = Logbook::with([
            'peserta.user',
            'dudi',
            'guru_pembimbing.guru.user'
        ])->latest()->get();

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

        $sudahAda = Logbook::where('peserta_id', $request->peserta_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Peserta sudah mengisi logbook pada tanggal ini.');
        }

        $data = $request->only([
            'peserta_id',
            'dudi_id',
            'tanggal',
            'jam',
            'keterangan'
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_logbook', $filename, 'public');
            $data['foto_bukti'] = $filename;
        }

        Logbook::create($data);

        return redirect()->back()->with('success', 'Logbook berhasil ditambahkan.');
    }



    public function edit($id)
    {
        $logbook = Logbook::with(['peserta.user', 'dudi'])->findOrFail($id);
        return view('home.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logbook = Logbook::findOrFail($id);

        $data = $request->only(['tanggal', 'jam', 'keterangan']);

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
