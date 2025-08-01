@extends('layouts.master')
@section('title', 'Surat DUDI')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Daftar Surat DUDI</h1>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama DUDI</th>
                            <th>Jumlah Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dudiList as $index => $dudi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $dudi->nama_dudi }}</td>
                            <td>{{ $dudi->tempat_pkl_count }}</td>
                            <td class="text-center">
                                <a href="{{ route('surat.permohonan', $dudi->id) }}" class="btn btn-info btn-sm" target="_blank">
                                    <i class="fas fa-file-alt"></i> Surat Permohonan
                                </a>
                                <a href="{{ route('surat.pengantar', $dudi->id) }}" class="btn btn-success btn-sm" target="_blank">
                                    <i class="fas fa-envelope-open-text"></i> Surat Pengantar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

@endsection
