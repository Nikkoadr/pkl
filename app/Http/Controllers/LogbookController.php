<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Peserta;
use App\Models\Dudi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Peserta_pkl;
use Illuminate\Support\Facades\Gate;

class LogbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('admin')) {
            // Admin → semua logbook
            $logbook = Logbook::with([
                'peserta_pkl.peserta.user',
                'peserta_pkl.dudi'
            ])->latest()->get();
        } elseif (Gate::allows('peserta')) {
            // Peserta → hanya logbook dirinya
            $logbook = Logbook::with([
                'peserta_pkl.peserta.user',
                'peserta_pkl.dudi'
            ])
                ->whereHas('peserta_pkl.peserta', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->latest()
                ->get();
        } elseif (Gate::allows('prodi')) {
            // Prodi → logbook peserta sesuai kompetensi keahlian kaprodinya
            $user = Auth::user();
            $kaprodi = \App\Models\Kaprodi::where('user_id', $user->id)->first();

            if (!$kaprodi) {
                abort(403, 'Anda tidak terdaftar sebagai Kaprodi');
            }

            $logbook = Logbook::whereHas('peserta_pkl.peserta.kelas', function ($q) use ($kaprodi) {
                $q->where('kompetensi_keahlian_id', $kaprodi->kompetensi_keahlian_id);
            })
                ->with([
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.dudi'
                ])
                ->latest()
                ->get();
        } elseif (Gate::allows('guru_pembimbing')) {
            // Guru pembimbing → logbook peserta di DUDI yang dibimbingnya
            $user = Auth::user();
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();

            if (!$guru) {
                abort(403, 'Anda tidak terdaftar sebagai Guru');
            }

            $dudi_ids = \App\Models\Guru_pembimbing::where('guru_id', $guru->id)->pluck('dudi_id');

            $logbook = Logbook::whereHas('peserta_pkl', function ($q) use ($dudi_ids) {
                $q->whereIn('dudi_id', $dudi_ids);
            })
                ->with([
                    'peserta_pkl.peserta.user',
                    'peserta_pkl.dudi'
                ])
                ->latest()
                ->get();
        } else {
            $logbook = collect();
        }

        $peserta = Peserta::all();
        $dudi = Dudi::all();

        return view('home.logbook.index', compact('logbook', 'peserta', 'dudi'));
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
            return redirect()->back()->with('error', 'Data peserta PKL tidak ditemukan.');
        }

        $request->validate([
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sudahAda = Logbook::where('peserta_pkl_id', $pesertaPkl->id)
            ->whereDate('tanggal', now()->toDateString())
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Anda sudah mengisi logbook hari ini.');
        }

        $data = [
            'peserta_pkl_id' => $pesertaPkl->id,
            'tanggal'    => now()->toDateString(),
            'jam'        => now()->format('H:i'),
            'keterangan' => $request->keterangan
        ];

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_logbook', $filename, 'public');
            $data['foto_bukti'] = $filename;
        }

        Logbook::create($data);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil ditambahkan.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'peserta_pkl_id' => 'required|exists:peserta,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sudahAda = Logbook::where('peserta_pkl_id', $request->peserta_pkl_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Peserta sudah mengisi logbook pada tanggal ini.');
        }

        $data = $request->only([
            'peserta_pkl_id',
            'tanggal',
            'jam',
            'keterangan'
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_logbook', $filename, 'public');
            $data['foto_bukti'] = $filename;
        }

        Logbook::create($data);

        return redirect()->back()->with('success', 'Logbook berhasil ditambahkan.');
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
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logbook = Logbook::findOrFail($id);

        $data = $request->only(['tanggal', 'jam', 'keterangan']);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $path = $file->store('foto_bukti', 'public');
            $data['foto_bukti'] = $path;
        }

        $logbook->update($data);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $logbook = Logbook::findOrFail($id);
        $logbook->delete();

        return redirect()->back()->with('success', 'Logbook berhasil dihapus.');
    }
}
