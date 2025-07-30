@extends('layouts.master')
@section('title', 'Manajemen DUDI')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Data DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session("success") }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            @endif

            <!-- Tombol Tambah DUDI -->
            <div class="mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah DUDI</button>
            </div>

            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-xl" role="document">
                <form action="{{ route('dudi.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header bg-secondary">
                        <h5 class="modal-title">Tambah DUDI</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body row">
                          <div class="form-group col-md-12">
                              <label>Nama DUDI</label>
                              <input type="text" name="nama_dudi" class="form-control" required>
                          </div>
                          <div class="form-group col-md-12">
                              <label>Alamat DUDI</label>
                              <input type="text" name="alamat_dudi" class="form-control">
                          </div>
                          <div class="form-group col-md-12">
                              <label>No. Telp</label>
                              <input type="text" name="no_telp_dudi" class="form-control">
                          </div>
                          <div class="form-group col-md-12">
                              <label>Nomor Kepegawaian</label>
                              <input type="text" name="nomor_kepegawaian" class="form-control">
                          </div>
                          <div class="form-group col-md-12">
                              <label>Nama Pimpinan</label>
                              <input type="text" name="nama_pimpinan_dudi" class="form-control">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                </form>
              </div>
            </div>

            <!-- Tabel -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar DUDI</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Alamat</th>
                                <th>Pimpinan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_dudi }}</td>
                                <td>{{ $item->alamat_dudi }}</td>
                                <td>{{ $item->nama_pimpinan_dudi }}</td>
                                <td>

                                    <!-- Edit -->
                                    <a href="{{ route('dudi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <!-- Delete -->
                                    <form action="{{ route('dudi.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
