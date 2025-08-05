<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EsertifikatController extends Controller
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
        $this->authorize('admin');
        return redirect()->route('home.dashboard')->with('error', 'Halaman E-Sertifikat tidak tersedia.');
    }
}
