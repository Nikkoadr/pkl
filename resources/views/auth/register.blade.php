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
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
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

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Tahun Ajaran -->
                            <div class="mb-3">
                                <select name="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                                    @if ($tahun_ajaran)
                                        <option value="{{ $tahun_ajaran->id }}" selected>
                                            {{ $tahun_ajaran->nama_tahun_ajaran }}
                                        </option>
                                    @else
                                        <option disabled>Belum ada tahun ajaran</option>
                                    @endif
                                </select>
                                @error('tahun_ajaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                            <div class="mb-3">
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir">
                                @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir" required>
                                @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Kelas -->
                            <div class="mb-3">
                                <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
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
                                <input type="text" id="nama_dudi" class="form-control @error('dudi_id') is-invalid @enderror"
                                        placeholder="Nama DUDI" required>
                                <input type="hidden" name="dudi_id" id="dudi_id" required>
                                @error('dudi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Alamat DUDI -->
                            <div class="mb-3">
                                <input type="text" name="alamat_dudi" class="form-control @error('alamat_dudi') is-invalid @enderror"
                                    placeholder="Alamat DUDI" readonly>
                                @error('alamat_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Nama Pimpinan DUDI -->
                            <div class="mb-3">
                                <input type="text" name="nama_pimpinan_dudi" class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror"
                                        placeholder="Nama Pemimpin DUDI" readonly>
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $("#nama_dudi").autocomplete({
                source: '/autocomplete/dudi',
                minLength: 2,
                select: function (event, ui) {
                    $('#nama_dudi').val(ui.item.label);
                    $('#dudi_id').val(ui.item.id);
                    $('input[name="alamat_dudi"]').val(ui.item.alamat);
                    $('input[name="nama_pimpinan_dudi"]').val(ui.item.pimpinan);
                    return false;
                }
            });

            $('form').on('submit', function(e) {
                if (!$('#dudi_id').val()) {
                    e.preventDefault();
                    alert('Silakan pilih Nama DUDI dari daftar yang muncul.');
                    $('#nama_dudi').focus();
                }
            });
        });
    </script>
</body>
</html>
