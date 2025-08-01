<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Tahun_ajaran;
use App\Models\Tempat_pkl;
use Illuminate\Support\Facades\Hash;

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


    public function index(Request $request)
    {
        $semua_tahun_ajaran = Tahun_ajaran::orderBy('id', 'desc')->get();
        $tahun_terbaru = $semua_tahun_ajaran->first();

        $tahun_ajaran_id = $request->tahun_ajaran_id ?? $tahun_terbaru->id;

        $peserta = Peserta::with(['tahun_ajaran', 'kelas', 'user'])
            ->where('tahun_ajaran_id', $tahun_ajaran_id)
            ->get();

        return view('home.peserta.index', compact('peserta', 'semua_tahun_ajaran'));
    }


    public function create()
    {
        $tahun_ajaran = Tahun_ajaran::all();
        $users = User::whereDoesntHave('peserta')->where('role_id', 3)->get();
        $kelas = Kelas::all();
        return view('home.peserta.create', compact('users', 'kelas', 'tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:1,2',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',

            'nis' => 'required|string|max:20|unique:peserta,nis',
            'nisn' => 'required|string|max:20|unique:peserta,nisn',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'dudi_id' => 'required|exists:dudi,id',
        ]);

        $user = User::create([
            'role_id' => 4,
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $peserta_baru = Peserta::create([
            'user_id' => $user->id,
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'kelas_id' => $validated['kelas_id'],
            'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
        ]);

        Tempat_pkl::create([
            'dudi_id' => $validated['dudi_id'],
            'peserta_id' => $peserta_baru->id,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peserta = Peserta::with(['user', 'tempat_pkl.dudi'])->findOrFail($id);
        $kelas = Kelas::all();
        $tahun_ajaran = Tahun_ajaran::all();

        return view('home.peserta.edit', compact('peserta', 'kelas', 'tahun_ajaran'));
    }


    public function update(Request $request, $id)
    {
        $peserta = Peserta::with(['user'])->findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:1,2',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|string|max:50',
            'nisn' => 'required|string|max:50',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);
        // Update User
        $peserta->user->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        // Update Peserta
        $peserta->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
