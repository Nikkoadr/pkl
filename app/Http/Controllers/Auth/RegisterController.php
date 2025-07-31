<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Dudi;
use App\Models\Peserta;
use App\Models\Tempat_pkl;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $kelas = Kelas::all();
        return view('auth.register', compact('kelas'));
    }

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
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'kelas_id' => ['required', 'exists:kelas,id'],
            'dudi_id' => ['required', 'exists:dudi,id'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'nisn' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:1,2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'role_id' => 4,
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $peserta_baru = Peserta::create([
            'user_id' => $user->id,
            'nis' => $data['nis'],
            'nisn' => $data['nisn'],
            'kelas_id' => $data['kelas_id'],
        ]);

        Tempat_pkl::create([
            'dudi_id' => $data['dudi_id'],
            'peserta_id' => $peserta_baru->id,
        ]);

        return $user;
    }
}
