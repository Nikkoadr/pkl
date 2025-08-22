<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Kelas;
use App\Models\Peserta_pkl;
use App\Models\Kaprodi;
use App\Models\Kompetensi_keahlian;
use App\Models\Peserta;



class HomeController extends Controller
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
            $jumlahDudi = Dudi::count();
            $jumlahPeserta = User::where('role_id', 4)->count();

            // Statistik per kompetensi keahlian (berdasarkan peserta_pkl)
            $kompetensiStats = Kompetensi_keahlian::withCount([
                // Peserta yang sudah punya relasi ke peserta_pkl
                'peserta as sudah_terserap' => function ($q) {
                    $q->whereHas('peserta_pkl');
                },
                // Peserta yang belum punya relasi ke peserta_pkl
                'peserta as belum_terserap' => function ($q) {
                    $q->whereDoesntHave('peserta_pkl');
                }
            ])->get();
            return view('home.dashboard.admin.index', compact('jumlahDudi', 'jumlahPeserta', 'kompetensiStats'));
        } elseif (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('user_id', $user->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            // Hitung semua peserta di prodi tsb
            $totalPeserta = Peserta::whereHas('kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })->count();

            // Hitung peserta terserap (sudah ada di peserta_pkl)
            $tersarap = Peserta_pkl::whereHas('peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })->count();

            // Hitung belum terserap
            $belum = $totalPeserta - $tersarap;

            return view('home.dashboard.prodi.index', compact('totalPeserta', 'tersarap', 'belum'));
        } elseif (Gate::allows('guru_pembimbing')) {
            $user = Auth::user();
            $namaDudi = $user->peserta?->peserta_pkl?->dudi?->nama_dudi;

            return view('home.dashboard.peserta.index', compact('namaDudi'));
        } elseif (Gate::allows('peserta')) {
            $user = Auth::user();
            $namaDudi = $user->peserta?->peserta_pkl?->dudi?->nama_dudi;

            return view('home.dashboard.peserta.index', compact('namaDudi'));
        }

        abort(403, 'Unauthorized');
    }


    public function profil()
    {
        $kelas = Kelas::all();

        return view('home.profil.index', compact('kelas'));
    }

    public function update_profil(Request $request)
    {
        $user = $request->user()->load('peserta');

        $rules = [
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'nullable|in:Laki-laki,Perempuan',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'password'       => 'nullable|string|min:6|confirmed',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'foto_profil'    => 'nullable|image|max:2048',
        ];

        if ($user->peserta) {
            $rules = array_merge($rules, [
                'nis' => 'nullable|string|max:50',
                'nisn' => 'nullable|string|max:50',
                'kelas_id' => 'nullable|exists:kelas,id',
            ]);
        }

        $validated = $request->validate($rules);

        $user->fill([
            'nama'          => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? $user->jenis_kelamin,
            'email'         => $validated['email'],
            'tempat_lahir'  => $validated['tempat_lahir'] ?? $user->tempat_lahir,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? $user->tanggal_lahir,
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto_profil')) {
            $ext = $request->file('foto_profil')->getClientOriginalExtension();
            $filename = Str::slug($user->nama) . '.' . $ext;

            if (!empty($user->foto_profil) && Storage::disk('public')->exists('foto_profil/' . $user->foto_profil)) {
                Storage::disk('public')->delete('foto_profil/' . $user->foto_profil);
            }

            $request->file('foto_profil')->storeAs('foto_profil', $filename, 'public');
            $user->foto_profil = $filename;
        }

        $user->save();

        if ($user->peserta) {
            $user->peserta()->update([
                'nis' => $validated['nis'] ?? $user->peserta->nis,
                'nisn' => $validated['nisn'] ?? $user->peserta->nisn,
                'kelas_id' => $validated['kelas_id'] ?? $user->peserta->kelas_id,
            ]);
        }

        return redirect()->route('home.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
