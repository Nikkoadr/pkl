<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;



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
        if (Gate::allows('admin')) {
            $jumlahDudi = Dudi::count();
            $jumlahPeserta = User::where('role_id', 4)->count();
            return view('home.dashboard.admin.index', compact('jumlahDudi', 'jumlahPeserta'));
        } elseif (Gate::allows('peserta')) {
            $user = Auth::user();
            $namaDudi = $user->peserta?->tempat_pkl?->dudi?->nama_dudi;
            return view('home.dashboard.peserta.index', compact('namaDudi'));
        } else {
            abort(403, 'Unauthorized');
        }
    }
}
