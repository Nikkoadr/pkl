<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->authorize('admin');
        $guru = Guru::with('user')->get();
        return view('home.guru.index', compact('guru'));
    }



    public function create()
    {
        return view('home.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'no_telp' => 'nullable|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'role_id' => 2,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,

        ]);

        Guru::create([
            'user_id' => $user->id,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import Guru Berhasil!');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('home.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|string|min:6|confirmed',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'no_telp' => 'nullable|string|max:15',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($guru->user_id);

        $dataUser = [
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
        ];

        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->password);
        }

        $user->update($dataUser);

        $guru->update([
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Guru berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        $userId = $guru->user_id;

        $guru->delete();

        User::where('id', $userId)->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }
}
