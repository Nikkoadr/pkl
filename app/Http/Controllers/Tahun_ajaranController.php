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
            'nama_tahun_ajaran' => 'required|string|unique:tahun_ajaran,nama_tahun_ajaran',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->status === 'aktif' && Tahun_ajaran::where('status', 'aktif')->exists()) {
            return redirect()->back()->with('error', 'Hanya boleh ada satu tahun ajaran aktif.');
        }

        Tahun_ajaran::create([
            'nama_tahun_ajaran' => $request->nama_tahun_ajaran,
            'status' => $request->status,
        ]);

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
        $item = Tahun_ajaran::findOrFail($id);

        $request->validate([
            'nama_tahun_ajaran' => 'required|unique:tahun_ajaran,nama_tahun_ajaran,' . $id,
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($request->status === 'aktif') {
            Tahun_ajaran::where('status', 'aktif')->where('id', '!=', $id)->update(['status' => 'nonaktif']);
        }

        $item->update($request->only('nama_tahun_ajaran', 'status'));

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $item = Tahun_ajaran::findOrFail($id);
        $item->delete();

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
