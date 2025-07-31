<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
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
        $guru = Guru::with('user')->get();
        return view('home.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('home.guru.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Guru::create($validated);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('home.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $validated = $request->validate([
            'keterangan' => 'nullable|string|max:255',
        ]);

        $guru->update($validated);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
