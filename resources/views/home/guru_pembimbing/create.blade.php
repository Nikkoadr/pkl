<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('guru_pembimbing.store') }}" method="POST">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Guru Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Guru</label>
                        <input type="text"
                               class="form-control"
                               id="nama_guru"
                               placeholder="Ketik nama guru...">
                        <input type="hidden" name="guru_id" id="guru_id">
                    </div>

                    <div class="form-group">
                        <label>Kompetensi Keahlian</label>
                        <select name="kompetensi_keahlian_id"
                                class="form-control" required>
                            <option value="" disabled selected>
                                -- Pilih Kompetensi Keahlian --
                            </option>
                            @foreach ($kompetensi as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kompetensi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label>Pilih DUDI</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="datatable-dudi">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>Nama DUDI</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dudiList as $dudi)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox"
                                               name="dudi_id[]"
                                               value="{{ $dudi->id }}">
                                    </td>
                                    <td>{{ $dudi->nama_dudi }}</td>
                                    <td>{{ $dudi->alamat }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary"
                            data-dismiss="modal">Batal</button>
                    <button type="submit"
                            class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>