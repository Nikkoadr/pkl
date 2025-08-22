@extends('layouts.master')
@section('title', 'Request DUDI')
@section('link')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Request DUDI</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request DUDI</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            {{-- Informasi --}}
            <div class="alert alert-info">
                Silakan cari dan pilih <b>DU/DI</b> tempat PKL yang tersedia. 
                Gunakan kolom pencarian di bawah untuk menemukan DUDI.
            </div>

            {{-- Form Request DUDI --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pilih DU/DI</h3>
                </div>
                <form action="{{ route('peserta.store_request_dudi') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_dudi">Nama DU/DI</label>
                            <input type="text" id="nama_dudi" class="form-control" placeholder="Ketik nama DUDI..." required>
                            <input type="hidden" id="dudi_id" name="dudi_id">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">Ajukan</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        $("#nama_dudi").autocomplete({
            source: '/autocomplete/dudi',
            minLength: 2,
            select: function (event, ui) {
                $('#nama_dudi').val(ui.item.label);
                $('#dudi_id').val(ui.item.id);
                return false;
            }
        });
        $('form').on('submit', function(e) {
            if (!$('#dudi_id').val()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih Nama DUDI dari daftar yang muncul.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#nama_dudi').focus();
                });
            }
        });
    });
</script>
<script>
    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endsection
