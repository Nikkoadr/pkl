<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kaprodi;
use App\Models\Kompetensi_keahlian;

class KaprodiController extends Controller
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
        $kaprodi = Kaprodi::with('user', 'kompetensi_keahlian')->get();
        return view('home.kaprodi.index', compact('kaprodi'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('home.kaprodi.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);

        Kaprodi::create([
            'user_id' => $validated['user_id'],
            'kompetensi_keahlian_id' => $validated['kompetensi_keahlian_id'],
        ]);

        return redirect()->route('kaprodi.index')
            ->with('success', 'Kaprodi berhasil ditambahkan.');
    }

    public function edit(Kaprodi $kaprodi)
    {
        $this->authorize('admin');
        $kompetensi = Kompetensi_keahlian::all();

        return view('home.kaprodi.edit', compact('kaprodi', 'kompetensi'));
    }

    public function update(Request $request, Kaprodi $kaprodi)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
        ]);

        $kaprodi->update([
            'user_id' => $validated['user_id'],
            'kompetensi_keahlian_id' => $validated['kompetensi_keahlian_id'],
        ]);

        return redirect()->route('kaprodi.index')
            ->with('success', 'Kaprodi berhasil diperbarui.');
    }


    public function destroy(Kaprodi $kaprodi)
    {
        $this->authorize('admin');
        $kaprodi->delete();
        return redirect()->back()->with('success', 'Kaprodi berhasil dihapus.');
    }
}
