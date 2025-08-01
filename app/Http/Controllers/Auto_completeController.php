<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\User;
use App\Models\Peserta;

class Auto_completeController extends Controller
{
    public function autoCompleteDudi(Request $request)
    {
        $term = $request->get('term');
        $dudi = Dudi::where('nama_dudi', 'like', '%' . $term . '%')->get();
        $results = $dudi->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->nama_dudi,
                'alamat' => $item->alamat_dudi,
                'pimpinan' => $item->nama_pimpinan_dudi,
            ];
        });
        return response()->json($results);
    }

    public function autoCompleteGuru(Request $request)
    {
        $term = $request->get('term');

        $guru = Guru::with('user')
            ->whereHas('user', function ($query) use ($term) {
                $query->where('nama', 'like', '%' . $term . '%');
            })
            ->get();

        $results = $guru->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->user->nama,
            ];
        });

        return response()->json($results);
    }

    public function autoCompletePeserta(Request $request)
    {
        $term = $request->get('term');

        $peserta = Peserta::with('user')
            ->whereHas('user', function ($query) use ($term) {
                $query->where('nama', 'like', '%' . $term . '%');
            })
            ->get();

        $results = $peserta->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->user->nama,
            ];
        });

        return response()->json($results);
    }

    public function autoCompleteUser(Request $request)
    {
        $term = $request->get('term');

        $excludeIds = array_merge(
            Guru::pluck('user_id')->toArray(),
            Peserta::pluck('user_id')->toArray()
        );

        $users = User::whereNotIn('id', $excludeIds)
            ->where('nama', 'like', '%' . $term . '%')
            ->get();

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'label' => $user->nama,
            ];
        });

        return response()->json($results);
    }
}
