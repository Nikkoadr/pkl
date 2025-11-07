<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
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
        $pengaturan = Pengaturan::first();
        return view('home.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $validated = $request->validate([
            'nama_sekolah'        => 'nullable|string|max:150',
            'alamat_sekolah'      => 'nullable|string',
            'no_telp_sekolah'     => 'nullable|string|max:25',
            'kepala_sekolah'      => 'nullable|string|max:100',
            'ketua_pkl'           => 'nullable|string|max:100',
            'sekretaris_pkl'      => 'nullable|string|max:100',
            'tanggal_mulai_pkl'   => 'nullable|date',
            'tanggal_selesai_pkl' => 'nullable|date|after_or_equal:tanggal_mulai_pkl',
        ]);

        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->update($validated);

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
