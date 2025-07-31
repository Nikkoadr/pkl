<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Kelas;

class PersertaController extends Controller
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
        $peserta = Peserta::with(['user', 'kelas'])->get();
        return view('home.peserta.index', compact('peserta'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('peserta')->where('role_id', 3)->get(); // hanya user yang belum jadi peserta
        $kelas = Kelas::all();
        return view('home.peserta.create', compact('users', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nis' => 'nullable|string',
            'nisn' => 'nullable|string',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peserta = Peserta::findOrFail($id);
        $users = User::where('role_id', 3)->get();
        $kelas = Kelas::all();

        return view('peserta.edit', compact('peserta', 'users', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nis' => 'nullable|string',
            'nisn' => 'nullable|string',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
