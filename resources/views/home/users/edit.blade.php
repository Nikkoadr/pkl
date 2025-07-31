@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Data User</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit</h3>
                </div>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="1" {{ $user->jenis_kelamin == '1' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="2" {{ $user->jenis_kelamin == '2' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $user->tempat_lahir }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $user->tanggal_lahir }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
