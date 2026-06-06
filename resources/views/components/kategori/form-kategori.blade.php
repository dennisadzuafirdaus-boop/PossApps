<!-- Button trigger modal -->
<button type="button" class="btn {{ $id ? ' btn-sm btn-primary' : 'btn-success btn-sm' }}" data-toggle="modal"
    data-target="#formkategori{{ $id ?? '' }}">
    @if ($id)
        <i class="fas fa-edit"></i>            
    @else
        Tambah Kategori
    @endif
</button>

<!-- Modal Kategori -->
<div class="modal fade" id="formkategori{{ $id ?? '' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('master-data.kategori.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? '' }}">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $id ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori{{ $id ?? '' }}">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori{{ $id ?? '' }}" name="nama_kategori"
                            value="{{ $nama_kategori ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi{{ $id ?? '' }}">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi{{ $id ?? '' }}" name="deskripsi" rows="3">{{ $deskripsi ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">{{ $id ? 'Update' : 'Tambah' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
