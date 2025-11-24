<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Peserta_pkl;
use App\Models\Tahun_ajaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Kaprodi;
use App\Jobs\ImportPesertaJob;
use App\Models\Dudi;

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
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()->route('home.dashboard')
                ->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        if (Gate::allows('admin')) {
            $peserta = Peserta::with(['tahun_ajaran', 'kelas.kompetensi', 'user'])
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->get();

            return view('home.peserta.index', compact('peserta', 'tahunAktif'));
        }

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) abort(403, 'Anda tidak terdaftar sebagai kaprodi');

            $peserta = Peserta::with(['tahun_ajaran', 'kelas.kompetensi', 'user'])
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->whereHas('kelas', function ($q) use ($kaprodi) {
                    $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                })
                ->get();

            return view('home.peserta.index', compact('peserta', 'tahunAktif'));
        }

        return redirect()->route('home.dashboard')
            ->with('error', 'Anda tidak memiliki akses.');
    }

    public function create()
    {
        $userLogin = Auth::user();

        $kompetensiId = Kaprodi::whereHas('guru', function ($q) use ($userLogin) {
            $q->where('user_id', $userLogin->id);
        })->value('kompetensi_keahlian_id');

        $tahun_ajaran = Tahun_ajaran::where('status', 'aktif')->first();

        $users = User::whereDoesntHave('peserta')
            ->where('role_id', 3)
            ->get();

        if (Gate::allows('prodi')) {
            $kelas = Kelas::where('kompetensi_keahlian_id', $kompetensiId)->get();
        } else {
            $kelas = Kelas::all();
        }

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

        Peserta_pkl::create([
            'dudi_id' => $validated['dudi_id'],
            'peserta_id' => $peserta_baru->id,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        $filename = 'peserta_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('imports', $filename, 'public');

        ImportPesertaJob::dispatch($path);

        return back()->with('success', 'Proses import sedang dijalankan di background.');
    }

    public function edit($id)
    {
        $peserta = Peserta::with(['user', 'peserta_pkl.dudi'])->findOrFail($id);
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
        $peserta->user->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        $peserta->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function request_dudi()
    {
        $peserta = Peserta::where('user_id', Auth::id())->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai peserta.');
        }

        if ($peserta->peserta_pkl) {
            return redirect()->back()->with('error', 'Anda sudah memiliki DUDI.');
        }

        return view('home.peserta.request_dudi');
    }

    public function store_request_dudi(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required|exists:dudi,id'
        ], [
            'dudi_id.required' => 'Silakan pilih DU/DI.',
            'dudi_id.exists'   => 'DU/DI tidak ditemukan.'
        ]);

        $user = Auth::user();

        if (!$user->peserta) {
            return redirect()->back()->with('error', 'Anda belum terdaftar sebagai peserta.');
        }

        $sudahTerdaftar = Peserta_pkl::where('peserta_id', $user->peserta->id)->exists();
        if ($sudahTerdaftar) {
            return redirect()->back()->with('error', 'Anda sudah memilih DU/DI sebelumnya.');
        }

        $dudi = Dudi::findOrFail($request->dudi_id);

        $jumlahPeserta = Peserta_pkl::where('dudi_id', $dudi->id)->count();

        if (!is_null($dudi->kuota) && $jumlahPeserta >= $dudi->kuota) {
            return redirect()->back()->with('error', 'Kuota DU/DI ' . $dudi->nama_dudi . ' sudah penuh.');
        }

        Peserta_pkl::create([
            'peserta_id' => $user->peserta->id,
            'dudi_id'    => $dudi->id,
        ]);

        return redirect()->route('home.dashboard')->with('success', 'Anda berhasil ditempatkan di DU/DI ' . $dudi->nama_dudi . '.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
