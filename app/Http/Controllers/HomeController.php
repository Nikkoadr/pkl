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
        // 1. Ambil ID Tahun Ajaran yang aktif terlebih dahulu
        $tahunAktif = \App\Models\Tahun_ajaran::where('status', 'aktif')->first();
        $tahunAktifId = $tahunAktif ? $tahunAktif->id : null;

        if (Gate::allows('admin')) {
            $jumlahDudi = Dudi::count();

            // Filter jumlah peserta hanya yang terdaftar di tahun ajaran aktif
            $jumlahPeserta = Peserta::where('tahun_ajaran_id', $tahunAktifId)->count();

            $kompetensiStats = Kompetensi_keahlian::withCount([
                'peserta as sudah_terserap' => function ($q) use ($tahunAktifId) {
                    $q->where('tahun_ajaran_id', $tahunAktifId)
                        ->whereHas('peserta_pkl');
                },
                'peserta as belum_terserap' => function ($q) use ($tahunAktifId) {
                    $q->where('tahun_ajaran_id', $tahunAktifId)
                        ->whereDoesntHave('peserta_pkl');
                }
            ])->get();

            return view('home.dashboard.admin.index', compact('jumlahDudi', 'jumlahPeserta', 'kompetensiStats', 'tahunAktif'));
        } elseif (Gate::allows('guru')) {
            $user = Auth::user();
            $guru = $user->guru;

            if ($guru && $guru->kaprodi) {
                $kaprodi = $guru->kaprodi;

                // Filter total peserta berdasarkan kompetensi DAN tahun ajaran aktif
                $totalPeserta = Peserta::where('tahun_ajaran_id', $tahunAktifId)
                    ->whereHas('kelas', function ($q) use ($kaprodi) {
                        $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                    })->count();

                // Filter peserta terserap di tahun ajaran aktif
                $tersarap = Peserta_pkl::whereHas('peserta', function ($q) use ($kaprodi, $tahunAktifId) {
                    $q->where('tahun_ajaran_id', $tahunAktifId)
                        ->whereHas('kelas', function ($k) use ($kaprodi) {
                            $k->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
                        });
                })->count();

                $belum = $totalPeserta - $tersarap;

                return view('home.dashboard.prodi.index', compact('totalPeserta', 'tersarap', 'belum', 'tahunAktif'));
            }

            if ($guru) {
                $pembimbing = $guru->guru_pembimbing()->with('dudi')->get();
                $dudis = $pembimbing->pluck('dudi')->filter()->values();
                if ($dudis->isNotEmpty()) {
                    return view('home.dashboard.guru_pembimbing.index', compact('dudis'));
                }
            }

            return view('home.dashboard.guru.index');
        } elseif (Gate::allows('peserta')) {
            $user = Auth::user();
            // Peserta biasanya hanya terikat ke satu tahun ajaran, jadi ini otomatis menyesuaikan data loginnya
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
            'foto_profil'    => 'nullable|image|max:5120',
        ];

        if ($user->peserta) {
            $rules = array_merge($rules, [
                'nis'      => 'nullable|string|max:50',
                'nisn'     => 'nullable|string|max:50',
                'kelas_id' => 'nullable|exists:kelas,id',
            ]);
        }

        $validated = $request->validate($rules);

        // ================= UPDATE USER =================
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

        // ================= FOTO PROFIL =================
        if ($request->hasFile('foto_profil')) {
            $ext = $request->file('foto_profil')->getClientOriginalExtension();

            // 🔥 PESERTA → NIS | NON PESERTA → slug + user_id
            if ($user->peserta && !empty($user->peserta->nis)) {
                $filename = $user->peserta->nis . '.' . $ext;
            } else {
                $filename = Str::slug($user->nama) . '-' . $user->id . '.' . $ext;
            }

            // hapus foto lama
            if (
                $user->foto_profil &&
                Storage::disk('public')->exists('foto_profil/' . $user->foto_profil)
            ) {
                Storage::disk('public')->delete('foto_profil/' . $user->foto_profil);
            }

            // simpan foto (konsisten)
            $request->file('foto_profil')
                ->storeAs('foto_profil', $filename, 'public');

            $user->foto_profil = $filename;
        }

        $user->save();

        // ================= UPDATE PESERTA =================
        if ($user->peserta) {
            $user->peserta()->update([
                'nis'      => $validated['nis'] ?? $user->peserta->nis,
                'nisn'     => $validated['nisn'] ?? $user->peserta->nisn,
                'kelas_id' => $validated['kelas_id'] ?? $user->peserta->kelas_id,
            ]);
        }

        return redirect()
            ->route('home.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
