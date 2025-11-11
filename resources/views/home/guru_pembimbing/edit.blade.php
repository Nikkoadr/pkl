@extends('layouts.master')
@section('title', 'Edit Guru Pembimbing')
@section('link')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Guru Pembimbing</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-body">
                    <form action="{{ route('guru_pembimbing.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_guru">Nama Guru</label>
                            <input type="text" class="form-control @error('guru_id') is-invalid @enderror" id="nama_guru" value="{{ $data->guru->user->nama }}">
                            <input type="hidden" name="guru_id" id="guru_id" value="{{ $data->guru_id }}">
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kompetensi_keahlian">Kompetensi Keahlian <span class="text-danger">*</span></label>
                            <select name="kompetensi_keahlian_id" id="kompetensi_keahlian" class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror" required>
                                <option value="{{ $data->kompetensi_keahlian->id }}" selected>{{ $data->kompetensi_keahlian->nama_kompetensi }}</option>

                                @foreach($kompetensi as $komp)
                                    @if($komp->id != $data->kompetensi_keahlian_id)
                                        <option value="{{ $komp->id }}">{{ $komp->nama_kompetensi }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('kompetensi_keahlian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_dudi">Nama DUDI</label>
                            <input type="text" class="form-control" id="nama_dudi" value="{{ $data->dudi->nama_dudi }}">
                            <input type="hidden" name="dudi_id" id="dudi_id" value="{{ $data->dudi_id }}">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('guru_pembimbing.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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

    setupAutocomplete("#nama_guru", "#guru_id", "/autocomplete/guru");
    setupAutocomplete("#nama_dudi", "#dudi_id", "/autocomplete/dudi");
});
</script>
@endsection
