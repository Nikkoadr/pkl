<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kompetensi_keahlian;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Kelas::with('kompetensi')->get();
        return view('home.kelas.index', compact('data'));
    }

    public function create()
    {
        $kompetensi = Kompetensi_keahlian::all();
        return view('home.kelas.create', compact('kompetensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kompetensi_keahlian_id' => $request->kompetensi_keahlian_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kompetensi = Kompetensi_keahlian::all();
        return view('home.kelas.edit', compact('kelas', 'kompetensi'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'kompetensi_keahlian_id' => $request->kompetensi_keahlian_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
