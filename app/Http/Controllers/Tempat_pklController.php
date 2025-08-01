<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tempat_pkl;

class Tempat_pklController extends Controller
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
        $tempat_pkl = Tempat_pkl::with(['dudi', 'peserta.user'])->get();
        return view('home.tempat_pkl.index', compact('tempat_pkl'));
    }
}
