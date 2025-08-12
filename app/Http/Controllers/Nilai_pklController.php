<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai_pkl;
use Illuminate\Support\Facades\Storage;

class Nilai_pklController extends Controller
{
    public function index()
    {
        $nilai_pkl = Nilai_pkl::with('peserta_pkl.peserta.user')->get();
        return view('home.nilai_pkl.index', compact('nilai_pkl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_pkl_id' => 'required|exists:peserta_pkl,id',
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_prilaku' => 'required|integer|min:0|max:100',
            'nilai_sidang_pkl' => 'nullable|integer|min:0|max:100',
            'komentar' => 'nullable|string',
            'foto_bukti_nilai_pkl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'peserta_pkl_id',
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_prilaku',
            'nilai_sidang_pkl',
            'komentar'
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

    public function edit($id)
    {
        $nilai_pkl = Nilai_pkl::findOrFail($id);
        return view('home.nilai_pkl.edit', compact('nilai_pkl'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peserta_pkl_id' => 'required|exists:peserta_pkl,id',
            'nilai_disiplin_kerja' => 'required|integer|min:0|max:100',
            'nilai_kemajuan_kerja' => 'required|integer|min:0|max:100',
            'nilai_kualitas_kerja' => 'required|integer|min:0|max:100',
            'nilai_inisiatif_kreatifitas' => 'required|integer|min:0|max:100',
            'nilai_prilaku' => 'required|integer|min:0|max:100',
            'nilai_sidang_pkl' => 'nullable|integer|min:0|max:100',
            'komentar' => 'nullable|string',
            'foto_bukti_nilai_pkl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'peserta_pkl_id',
            'nilai_disiplin_kerja',
            'nilai_kemajuan_kerja',
            'nilai_kualitas_kerja',
            'nilai_inisiatif_kreatifitas',
            'nilai_prilaku',
            'nilai_sidang_pkl',
            'komentar'
        ]);

        if ($request->hasFile('foto_bukti_nilai_pkl')) {
            $file = $request->file('foto_bukti_nilai_pkl');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti_nilai_pkl', $filename, 'public');
            $data['foto_bukti_nilai_pkl'] = $filename;
        }

        $nilai_pkl = Nilai_pkl::findOrFail($id);
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
