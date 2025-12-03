<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru_pembimbing;
use App\Models\Guru;
use App\Models\Dudi;
use App\Models\Kompetensi_keahlian;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;

class GuruPembimbingController extends Controller
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
        if (Gate::allows('admin')) {
            $pembimbing = Guru_pembimbing::with('guru.user', 'kompetensi_keahlian', 'dudi')->get();
        } elseif (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();
            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }
            $kompetensiId = $kaprodi->kompetensi_keahlian_id;
            $pembimbing = Guru_pembimbing::with('guru.user', 'kompetensi_keahlian', 'dudi')
                ->where('kompetensi_keahlian_id', $kompetensiId)
                ->get();
        } else {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        // Data tambahan
        $guru = Guru::with('user')->get();
        $kompetensi = Kompetensi_keahlian::all();
        $dudiList = Dudi::all();

        return view('home.guru_pembimbing.index', compact('pembimbing', 'guru', 'kompetensi', 'dudiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
            'dudi_id' => 'required|array',
            'dudi_id.*' => 'exists:dudi,id',
        ]);

        $sudahDipilih = Guru_pembimbing::whereIn('dudi_id', $request->dudi_id)
            ->where('guru_id', '!=', $request->guru_id)
            ->pluck('dudi_id')
            ->toArray();

        if (!empty($sudahDipilih)) {
            $dudiTerpakai = Dudi::whereIn('id', $sudahDipilih)->pluck('nama_dudi')->toArray();
            return redirect()->back()
                ->withInput()
                ->with('error', 'DUDI berikut sudah dipilih oleh guru lain: ' . implode(', ', $dudiTerpakai));
        }

        foreach ($request->dudi_id as $dudiId) {
            Guru_pembimbing::firstOrCreate([
                'guru_id' => $request->guru_id,
                'kompetensi_keahlian_id' => $request->kompetensi_keahlian_id,
                'dudi_id' => $dudiId,
            ]);
        }

        return redirect()->back()->with('success', 'Guru pembimbing berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $data = Guru_pembimbing::with(['guru.user', 'dudi'])->findOrFail($id);
        $kompetensi = Kompetensi_keahlian::all();
        return view('home.guru_pembimbing.edit', compact('data', 'kompetensi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kompetensi_keahlian_id' => 'required|exists:kompetensi_keahlian,id',
            'dudi_id' => 'required|exists:dudi,id',
        ]);
        $data = Guru_pembimbing::findOrFail($id);
        $data->update([
            'guru_id' => $request->guru_id,
            'kompetensi_keahlian_id' => $request->kompetensi_keahlian_id,
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
