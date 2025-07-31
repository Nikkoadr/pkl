@extends('layouts.master')
@section('title', 'Edit Guru')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Guru</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="nama">Nama Guru</label>
                            <input type="text" class="form-control" value="{{ $guru->user->nama }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $guru->keterangan }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
