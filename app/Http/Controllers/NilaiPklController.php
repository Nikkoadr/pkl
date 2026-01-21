<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai_pkl;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Peserta;
use App\Models\Peserta_pkl;
use App\Models\Kaprodi;
use App\Models\Guru;
use App\Models\Guru_pembimbing;
use App\Models\Esertifikat;

class NilaiPklController extends Controller
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
        $user = Auth::user();
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()->route('home.dashboard')->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        if (Gate::allows('admin')) {
            $nilai_pkl = Nilai_pkl::whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->with('peserta_pkl.peserta.user', 'peserta_pkl.dudi')
                ->get();

            return view('home.nilai_pkl.index', compact('nilai_pkl'));
        } elseif (Gate::allows('prodi')) {
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $nilai_pkl = Nilai_pkl::whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi, $tahunAktif) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id)
                    ->where('tahun_ajaran_id', $tahunAktif->id);
            })
                ->with('peserta_pkl.peserta.user', 'peserta_pkl.dudi')
                ->get();

            return view('home.nilai_pkl.index', compact('nilai_pkl'));
        } elseif (Gate::allows('guru')) {
            $guru = Guru::where('user_id', $user->id)->first();

            if (!$guru) {
                abort(403, 'Anda tidak terdaftar sebagai Guru');
            }

            $dudi_ids = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $nilai_pkl = Nilai_pkl::whereHas('peserta_pkl', function ($q) use ($dudi_ids, $tahunAktif) {
                $q->whereIn('dudi_id', $dudi_ids)
                    ->whereHas('peserta', function ($qq) use ($tahunAktif) {
                        $qq->where('tahun_ajaran_id', $tahunAktif->id);
                    });
            })
                ->with('peserta_pkl.peserta.user', 'peserta_pkl.dudi')
                ->get();

            return view('home.nilai_pkl.index', compact('nilai_pkl'));

        } elseif (Gate::allows('peserta')) {
            $peserta = Peserta::where('user_id', $user->id)
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->first();

            if (!$peserta) {
                return redirect()->route('home.dashboard')
                    ->with('error', 'Anda belum terdaftar mengikuti PKL di tahun ajaran aktif.');
            }

            $pesertaPkl = Peserta_pkl::where('peserta_id', $peserta->id)->first();

            if (!$pesertaPkl) {
                return redirect()->route('home.dashboard')
                    ->with('error', 'Anda belum mengikuti PKL di tahun ajaran aktif.');
            }

            $nilai_pkl = Nilai_pkl::where('peserta_pkl_id', $pesertaPkl->id)
                ->with('peserta_pkl.peserta.user', 'peserta_pkl.dudi')
                ->first() ?? new Nilai_pkl();

            $esertifikat = Esertifikat::where('peserta_pkl_id', $pesertaPkl->id)->first();

            return view('home.nilai_pkl.index_peserta', compact('nilai_pkl', 'esertifikat'));
        }

        abort(403);
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_pkl_id' => 'required|exists:peserta_pkl,id',
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_perilaku' => 'required|integer|min:0|max:100',
            'foto_bukti_nilai_pkl' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->only([
            'peserta_pkl_id',
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_perilaku',
        ]);

        if ($request->hasFile('foto_bukti_nilai_pkl')) {
            $file = $request->file('foto_bukti_nilai_pkl');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_nilai_pkl', $filename, 'public');
            $data['foto_bukti_nilai_pkl'] = $filename;
        }

        Nilai_pkl::create($data);

        return redirect()->route('nilai_pkl.index')->with('success', 'Data nilai PKL berhasil ditambahkan.');
    }
    public function store_peserta(Request $request)
    {
        $request->validate([
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_perilaku' => 'required|integer|min:0|max:100',
            'foto_bukti_nilai_pkl' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'komentar' => 'nullable|string',
        ]);

        $peserta = Peserta::where('user_id', Auth::id())->first();
        if (!$peserta) {
            return back()->withErrors(['msg' => 'Data peserta tidak ditemukan.']);
        }

        $peserta_pkl = Peserta_pkl::where('peserta_id', $peserta->id)->latest()->first();
        if (!$peserta_pkl) {
            return back()->withErrors(['msg' => 'Anda belum terdaftar PKL.']);
        }

        $data = $request->only([
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_perilaku',
            'nilai_sidang_pkl',
            'komentar'
        ]);

        $data['peserta_pkl_id'] = $peserta_pkl->id;

        if ($request->hasFile('foto_bukti_nilai_pkl')) {
            $file = $request->file('foto_bukti_nilai_pkl');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_nilai_pkl', $filename, 'public');
            $data['foto_bukti_nilai_pkl'] = $filename;
        }

        Nilai_pkl::create($data);

        return redirect()->route('nilai_pkl.index')->with('success', 'Data nilai PKL berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $nilai_pkl = Nilai_pkl::findOrFail($id);
        return view('home.nilai_pkl.edit', compact('nilai_pkl'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_perilaku' => 'required|integer|min:0|max:100',
            'foto_bukti_nilai_pkl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $nilai_pkl = Nilai_pkl::findOrFail($id);

        $data = $request->only([
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_perilaku'
        ]);

        if ($request->hasFile('foto_bukti_nilai_pkl')) {
            if ($nilai_pkl->foto_bukti_nilai_pkl && Storage::disk('public')->exists('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl)) {
                Storage::disk('public')->delete('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl);
            }

            $file = $request->file('foto_bukti_nilai_pkl');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_nilai_pkl', $filename, 'public');
            $data['foto_bukti_nilai_pkl'] = $filename;
        }

        $nilai_pkl->update($data);

        return redirect()->route('nilai_pkl.index')->with('success', 'Data nilai PKL berhasil diperbarui.');
    }
    public function update_siswa(Request $request, $id)
    {
        $request->validate([
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_perilaku' => 'required|integer|min:0|max:100',
            'foto_bukti_nilai_pkl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $nilai_pkl = Nilai_pkl::findOrFail($id);

        $data = $request->only([
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_perilaku',
        ]);

        if ($request->hasFile('foto_bukti_nilai_pkl')) {
            if ($nilai_pkl->foto_bukti_nilai_pkl && Storage::disk('public')->exists('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl)) {
                Storage::disk('public')->delete('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl);
            }

            $file = $request->file('foto_bukti_nilai_pkl');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_nilai_pkl', $filename, 'public');
            $data['foto_bukti_nilai_pkl'] = $filename;
        }

        $nilai_pkl->update($data);

        return redirect()->route('nilai_pkl.index')->with('success', 'Data nilai PKL berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai_pkl = Nilai_pkl::findOrFail($id);

        if ($nilai_pkl->foto_bukti_nilai_pkl && Storage::disk('public')->exists('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl)) {
            Storage::disk('public')->delete('bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl);
        }

        $nilai_pkl->delete();

        return redirect()->route('nilai_pkl.index')->with('success', 'Data nilai PKL berhasil dihapus.');
    }
}
