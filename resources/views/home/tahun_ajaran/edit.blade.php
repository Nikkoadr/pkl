@extends('layouts.master')
@section('title', 'Edit Tahun Ajaran')

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Tahun Ajaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tahun_ajaran.index') }}">Tahun Ajaran</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Form Card -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Tahun Ajaran</h3>
                </div>
                <form action="{{ route('tahun_ajaran.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_tahun_ajaran">Nama Tahun Ajaran</label>
                            <input type="text" name="nama_tahun_ajaran" class="form-control @error('nama_tahun_ajaran') is-invalid @enderror" id="nama_tahun_ajaran" value="{{ old('nama_tahun_ajaran', $item->nama_tahun_ajaran) }}" required>
                            @error('nama_tahun_ajaran')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('tahun_ajaran.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection
