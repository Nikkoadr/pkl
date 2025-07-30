<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;

class DudiController extends Controller
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
        $dudi = Dudi::all();
        return view('home.dudi.index', compact('dudi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dudi' => 'required|string|max:255',
            'alamat_dudi' => 'nullable|string|max:255',
            'no_telp_dudi' => 'nullable|string|max:20',
            'nomor_kepegawaian' => 'nullable|string|max:50',
            'nama_pimpinan_dudi' => 'nullable|string|max:255',
        ]);
        Dudi::create(
            $request->all()
        );
        return redirect()->route('dudi.index')->with('success', 'DUDI berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Dudi::findOrFail($id);
        return view('home.dudi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        Dudi::findOrFail($id)->update($request->all());
        return redirect()->route('dudi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Dudi::destroy($id);
        return redirect()->route('dudi.index')->with('success', 'Data berhasil dihapus');
    }
}
