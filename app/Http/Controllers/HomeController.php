<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



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
            $namaDudi = $user->peserta?->peserta_pkl?->dudi?->nama_dudi;
            return view('home.dashboard.peserta.index', compact('namaDudi'));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function profil()
    {
        return view('home.profil.index');
    }

    public function update_profil(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048'
        ]);

        $user->nama = $validated['nama'];
        $user->jenis_kelamin = $validated['jenis_kelamin'] ?? $user->jenis_kelamin;
        $user->email = $validated['email'];
        $user->tempat_lahir = $validated['tempat_lahir'] ?? null;
        $user->tanggal_lahir = $validated['tanggal_lahir'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('profile', 'public');

            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('home.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
