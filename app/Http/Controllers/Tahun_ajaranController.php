<?php

namespace App\Http\Controllers;

use App\Models\Tahun_ajaran;
use Illuminate\Http\Request;

class Tahun_ajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Tahun_ajaran::latest()->get();
        return view('home.tahun_ajaran.index', compact('data'));
    }

    public function create()
    {
        return view('home.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tahun_ajaran' => 'required|unique:tahun_ajaran,nama_tahun_ajaran',
        ]);

        Tahun_ajaran::create($request->all());

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $item = Tahun_ajaran::findOrFail($id);
        return view('home.tahun_ajaran.show', compact('item'));
    }

    public function edit(string $id)
    {
        $item = Tahun_ajaran::findOrFail($id);
        return view('home.tahun_ajaran.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_tahun_ajaran' => 'required|unique:tahun_ajaran,nama_tahun_ajaran,' . $id,
        ]);

        $item = Tahun_ajaran::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $item = Tahun_ajaran::findOrFail($id);
        $item->delete();

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
