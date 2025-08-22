<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\Peserta_pkl;
use App\Models\Tahun_ajaran;
use App\Models\Dudi;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Halaman setelah registrasi berhasil.
     *
     * @var string
     */
    protected $redirectTo = '/home/dashboard';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        $kelas = Kelas::all();
        $tahun_ajaran = Tahun_ajaran::orderByDesc('id')->first();

        return view('auth.register', compact('kelas', 'tahun_ajaran'));
    }

    /**
     * Validasi input registrasi.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'dudi_id'         => ['required', 'exists:dudi,id'],
            'tempat_lahir'    => ['nullable', 'string', 'max:255'],
            'tanggal_lahir'   => ['required', 'date'],
            'nisn'            => ['required', 'string', 'max:10', 'unique:peserta,nisn'],
            'nis'             => ['required', 'string', 'max:13', 'unique:peserta,nis'],
            'nama'            => ['required', 'string', 'max:255'],
            'jenis_kelamin'   => ['required', 'in:Laki-laki,Perempuan'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nis.unique'   => 'NIS sudah terdaftar.',
            'nisn.unique'  => 'NISN sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);
    }

    /**
     * Membuat user baru setelah validasi berhasil.
     */
    protected function create(array $data)
    {
        // 1. Cek kuota DUDI
        $dudi = Dudi::findOrFail($data['dudi_id']);
        $jumlah_peserta = Peserta_pkl::where('dudi_id', $dudi->id)->count();

        if ($jumlah_peserta >= $dudi->kuota) {
            abort(redirect()->route('register')->with('error', 'Kuota DUDI sudah penuh.'));
        }

        // 2. Cek duplikat kombinasi Nama + Tanggal Lahir
        $cekNamaTgl = User::where('nama', $data['nama'])
            ->where('tanggal_lahir', $data['tanggal_lahir'])
            ->first();

        if ($cekNamaTgl) {
            abort(redirect()->route('register')->with('error', 'Peserta dengan nama dan tanggal lahir yang sama sudah terdaftar.'));
        }

        // 3. Simpan user baru
        $user = User::create([
            'role_id'       => 4, // role peserta
            'nama'          => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);

        // 4. Simpan ke tabel peserta
        $peserta = Peserta::create([
            'user_id'         => $user->id,
            'nis'             => $data['nis'],
            'nisn'            => $data['nisn'],
            'kelas_id'        => $data['kelas_id'],
            'tahun_ajaran_id' => $data['tahun_ajaran_id'],
        ]);

        // 5. Simpan ke tabel peserta_pkl
        Peserta_pkl::create([
            'dudi_id'    => $data['dudi_id'],
            'peserta_id' => $peserta->id,
        ]);

        return $user;
    }
}
