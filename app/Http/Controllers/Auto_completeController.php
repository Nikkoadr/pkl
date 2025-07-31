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

        // Ambil user_id yang sudah jadi guru dan peserta
        $excludeIds = array_merge(
            Guru::pluck('user_id')->toArray(),
            Peserta::pluck('user_id')->toArray()
        );

        // Ambil user yang belum terdaftar di guru dan peserta
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

    public function autoCompleteUser(Request $request)
    {
        $term = $request->get('term');
        $users = User::where('nama', 'like', '%' . $term . '%')->get();

        $results = $users->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->nama,
            ];
        });

        return response()->json($results);
    }
}
