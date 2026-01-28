<div class="modal fade" id="modalImportFoto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('peserta.import_foto_peserta') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Foto Peserta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="zip_foto">File input</label>
                        <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="zip_foto" name="zip_foto" required accept=".zip">
                            <label class="custom-file-label" for="zip_foto">Choose file</label>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>