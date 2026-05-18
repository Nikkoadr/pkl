<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Peserta;
use App\Models\Kelas;
use App\Models\Kompetensi_keahlian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use Illuminate\Support\Facades\Gate;
use App\Models\Kaprodi;
use App\Models\Guru;
use App\Models\Guru_pembimbing;
use App\Models\Pengaturan;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class LogbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tahunAktif = tahunAktif();

        if (!$tahunAktif) {
            return redirect()
                ->route('home.dashboard')
                ->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        // ================= QUERY DASAR =================
        $query = Logbook::whereHas('peserta_pkl.peserta', function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran_id', $tahunAktif->id);
        });

        // ================= ROLE =================
        $kaprodi = null;

        if (Gate::allows('prodi')) {
            $user = Auth::user();
            $kaprodi = Kaprodi::where('guru_id', $user->guru->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda bukan Kaprodi');
            }

            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            });
        } elseif (Gate::allows('guru')) {
            $guru = Guru::where('user_id', Auth::id())->first();

            if (!$guru) {
                abort(403, 'Anda bukan Guru');
            }

            $dudiIds = Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $query->whereHas('peserta_pkl', function ($q) use ($dudiIds) {
                $q->whereIn('dudi_id', $dudiIds);
            });
        } elseif (Gate::allows('peserta')) {
            $peserta = Peserta::where('user_id', Auth::id())
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->first();

            if (!$peserta) {
                abort(403, 'Anda bukan Peserta aktif');
            }

            $pesertaPkl = Peserta_pkl::where('peserta_id', $peserta->id)->first();

            if (!$pesertaPkl) {
                return redirect()
                    ->route('home.dashboard')
                    ->with('error', 'Anda belum mengikuti PKL.');
            }

            $query->where('peserta_pkl_id', $pesertaPkl->id);
        }

        // ================= FILTER =================

        // Filter Kompetensi
        if ($request->filled('kompetensi')) {
            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($request) {
                $q->where('kompetensi_keahlian_id', $request->kompetensi);
            });
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('peserta_pkl.peserta.kelas', function ($q) use ($request) {
                $q->where('id', $request->kelas);
            });
        }

        // ================= LOAD DATA =================
        $logbook = $query->with([
            'peserta_pkl.peserta.user',
            'peserta_pkl.peserta.kelas',
            'peserta_pkl.dudi'
        ])->latest()->get();

        // ================= DROPDOWN =================

        // Kompetensi
        if (Gate::allows('prodi')) {
            $listKompetensi = Kompetensi_keahlian::where(
                'id',
                $kaprodi->kompetensi_keahlian_id
            )->get();
        } else {
            $listKompetensi = Kompetensi_keahlian::orderBy('nama_kompetensi')->get();
        }

        // Kelas (dependent)
        $listKelas = collect();
        if ($request->filled('kompetensi')) {
            $listKelas = Kelas::where('kompetensi_keahlian_id', $request->kompetensi)
                ->orderBy('nama_kelas')
                ->get();
        }

        return view('home.logbook.index', compact(
            'logbook',
            'listKompetensi',
            'listKelas'
        ));
    }


    public function create()
    {
        $userId = Auth::id();
        $pesertaPkl = Peserta_pkl::with(['peserta.user', 'dudi'])
            ->whereHas('peserta', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        return view('home.logbook.create', [
            'nama_peserta' => $pesertaPkl->peserta->user->nama,
            'nama_dudi'    => $pesertaPkl->dudi->nama_dudi,
        ]);
    }

    public function store_siswa(Request $request)
    {
        $pesertaPkl = Peserta_pkl::with(['peserta', 'dudi'])
            ->whereHas('peserta.user', function ($query) {
                $query->where('id', Auth::id());
            })
            ->first();

        if (!$pesertaPkl) {
            return back()->with('error', 'Data peserta PKL tidak ditemukan.');
        }

        $request->validate([
            'keterangan' => 'required|string|max:255',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $sudahAda = Logbook::where('peserta_pkl_id', $pesertaPkl->id)
            ->whereDate('tanggal', now()->toDateString())
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anda sudah mengisi logbook hari ini.');
        }

        $data = [
            'peserta_pkl_id' => $pesertaPkl->id,
            'tanggal'       => now()->toDateString(),
            'jam'           => now()->format('H:i'),
            'keterangan'    => $request->keterangan,
        ];

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.jpg';

            $image = Image::read($file);

            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $path = storage_path('app/public/bukti_logbook/' . $filename);
            $image->encodeByExtension('jpg', 35)->save($path);

            $data['foto_bukti'] = $filename;
        }

        Logbook::create($data);

        return redirect()
            ->route('logbook.index')
            ->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_pkl_id' => 'required|exists:peserta_pkl,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'required|string|max:255',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $sudahAda = Logbook::where('peserta_pkl_id', $request->peserta_pkl_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Peserta sudah mengisi logbook pada tanggal ini.');
        }

        $data = $request->only([
            'peserta_pkl_id',
            'tanggal',
            'jam',
            'keterangan',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.jpg';

            $image = Image::read($file);

            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $path = storage_path('app/public/bukti_logbook/' . $filename);
            $image->encodeByExtension('jpg', 35)->save($path);

            $data['foto_bukti'] = $filename;
        }

        Logbook::create($data);

        return redirect()
            ->back()
            ->with('success', 'Logbook berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $logbook = Logbook::with(['peserta_pkl.peserta.user', 'peserta_pkl.dudi'])->findOrFail($id);
        return view('home.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $logbook = Logbook::findOrFail($id);

        $data = $request->only([
            'tanggal',
            'jam',
            'keterangan',
        ]);

        if ($request->hasFile('foto_bukti')) {

            if (
                $logbook->foto_bukti &&
                Storage::disk('public')->exists('bukti_logbook/' . $logbook->foto_bukti)
            ) {
                Storage::disk('public')->delete('bukti_logbook/' . $logbook->foto_bukti);
            }

            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.jpg';

            $image = Image::read($file);

            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $path = storage_path('app/public/bukti_logbook/' . $filename);
            $image->encodeByExtension('jpg', 35)->save($path);

            $data['foto_bukti'] = $filename;
        }

        $logbook->update($data);

        return redirect()
            ->route('logbook.index')
            ->with('success', 'Logbook berhasil diperbarui.');
    }

    public function cetak_rekap()
    {
        $user = Auth::user();

        if (!Gate::allows('peserta')) {
            return redirect()->route('home.dashboard')
                ->with('error', 'Akses ditolak. Hanya peserta yang dapat mengunduh rekap logbook.');
        }

        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->route('home.dashboard')
                ->with('error', 'Anda tidak terdaftar sebagai Peserta.');
        }

        $peserta_pkl = Peserta_pkl::with('dudi')
            ->where('peserta_id', $peserta->id)
            ->first();

        if (!$peserta_pkl) {
            return redirect()->route('home.dashboard')
                ->with('error', 'Anda belum mengikuti PKL.');
        }

        $logbooks = Logbook::where('peserta_pkl_id', $peserta_pkl->id)
            ->orderBy('tanggal', 'asc')
            ->get();

        $tanggal_mulai = Pengaturan::first()->tanggal_mulai_pkl;
        $tanggal_selesai = Pengaturan::first()->tanggal_selesai_pkl;

        return view('home.logbook.rekap', [
            'peserta' => $peserta,
            'peserta_pkl' => $peserta_pkl,
            'logbooks' => $logbooks,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'tahun_ajaran' => '2025 / 2026'
        ]);
    }

    public function destroy($id)
    {
        $logbook = Logbook::findOrFail($id);

        if (
            $logbook->foto_bukti &&
            Storage::disk('public')->exists('bukti_logbook/' . $logbook->foto_bukti)
        ) {
            Storage::disk('public')->delete('bukti_logbook/' . $logbook->foto_bukti);
        }

        $logbook->delete();

        return redirect()
            ->back()
            ->with('success', 'Logbook berhasil dihapus.');
    }
}
