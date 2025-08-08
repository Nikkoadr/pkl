<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai_pkl;

class Nilai_pklController extends Controller
{
    public function index()
    {
        $nilai_pkl = Nilai_pkl::with('peserta.user')->get();
        return view('home.nilai_pkl.index', compact('nilai_pkl'));
    }
}
