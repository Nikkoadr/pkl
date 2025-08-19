@extends('layouts.master')
@section('title', 'Edit Tempat PKL')
@section('link')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Tempat PKL</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Tempat PKL</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('peserta_pkl.update', $data->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nama_peserta">Nama Peserta</label>
                                    <input type="text" class="form-control" id="nama_peserta" 
                                        value="{{ $data->peserta->user->nama }}">
                                    <input type="hidden" name="peserta_id" id="peserta_id" 
                                        value="{{ $data->peserta_id }}">
                                </div>

                                <div class="form-group">
                                    <label for="nama_dudi">Nama DUDI</label>
                                    <input type="text" class="form-control" id="nama_dudi" 
                                        value="{{ $data->dudi->nama_dudi }}">
                                    <input type="hidden" name="dudi_id" id="dudi_id" 
                                        value="{{ $data->dudi_id }}">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('peserta_pkl.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
    function setupAutocomplete(selector, hiddenSelector, url) {
        $(selector).autocomplete({
            source: url,
            minLength: 2,
            select: function(event, ui) {
                $(selector).val(ui.item.label);
                $(hiddenSelector).val(ui.item.id);
                return false;
            }
        });
    }

    setupAutocomplete("#nama_peserta", "#peserta_id", "/autocomplete/peserta");
    setupAutocomplete("#nama_dudi", "#dudi_id", "/autocomplete/dudi");
});
</script>
@endsection
