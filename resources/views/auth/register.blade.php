<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registrasi Akun | Manajemen PKL</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    </head>
<body class="hold-transition register-page">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow w-100" style="max-width: 700px;">
            <div class="card-body register-card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/dist/img/logo.png') }}" alt="logo SMK" style="width: 12%;">
                    <h3 class="mt-2"><b>Manajemen</b> PKL</h3>
                    <p class="text-muted">Formulir Pendaftaran Akun</p>
                </div>

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- NISN -->
                            <div class="mb-3">
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                                        value="{{ old('nisn') }}" placeholder="NISN" required>
                                @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <!-- NIS -->
                            <div class="mb-3">
                                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                                        value="{{ old('nis') }}" placeholder="NIS" required>
                                @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Nama -->
                            <div class="mb-3">
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Kelas -->
                            <div class="mb-3">
                                <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
                                        value="{{ old('kelas') }}" placeholder="Kelas" required>
                                @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">-- Jenis Kelamin --</option>
                            <option value="1" {{ old('jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="2" {{ old('jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Nama DUDI -->
                        <div class="mb-3">
                            <input type="text" name="nama_dudi" class="form-control @error('nama_dudi') is-invalid @enderror"
                                    value="{{ old('nama_dudi') }}" placeholder="Nama DUDI" required>
                            @error('nama_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Alamat DUDI -->
                        <div class="mb-3">
                            <input type="text" name="alamat_dudi" class="form-control @error('alamat_dudi') is-invalid @enderror"
                                    value="{{ old('alamat_dudi') }}" placeholder="Alamat DUDI" required>
                            @error('alamat_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Nama Pimpinan DUDI -->
                        <div class="mb-3">
                            <input type="text" name="nama_pimpinan_dudi" class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror"
                                    value="{{ old('nama_pimpinan_dudi') }}" placeholder="Nama Pemimpin DUDI" required>
                            @error('nama_pimpinan_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Email" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Konfirmasi Password" required>
                    </div>

                    <!-- Tombol -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                        <div class="col-md-6">
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-block">Sudah Punya Akun</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
