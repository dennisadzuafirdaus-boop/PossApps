<!-- Button trigger modal -->
<button type="button"
    class="btn {{ $id ? 'btn-sm btn-primary' : 'btn-success btn-sm' }}"
    data-toggle="modal"
    data-target="#formProduct{{ $id ?? '' }}">
    @if ($id)
        <i class="fas fa-edit"></i>
    @else
        Tambah Product
    @endif
</button>

<!-- Modal Product -->
<div class="modal fade" id="formProduct{{ $id ?? '' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('master-data.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? '' }}">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $id ? 'Edit Product' : 'Product Baru' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_produk{{ $id ?? '' }}">Nama Product</label>
                        <input type="text" class="form-control" id="nama_produk{{ $id ?? '' }}" name="nama_produk"
                            value="{{ $id ? $nama_produk : old('nama_produk') }}">
                    </div>
                    <div class="form-group">
                        <label for="kategori_id{{ $id ?? '' }}">Kategori Product</label>
                        <select name="kategori_id" id="kategori_id{{ $id ?? '' }}" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('kategori_id') == $item->id || $kategori_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image{{ $id ?? '' }}">Gambar Product</label>
                        <input type="file" class="form-control" id="image{{ $id ?? '' }}" name="image" accept="image/*">
                        @if(isset($image) && $image)
                            <small class="text-muted">Gambar saat ini: {{ $image }}</small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="harga_beli_pokok{{ $id ?? '' }}">Harga Beli Pokok</label>
                        <input type="number" class="form-control" id="harga_beli_pokok{{ $id ?? '' }}" name="harga_beli_pokok"
                            value="{{ $id ? $harga_beli_pokok : old('harga_beli_pokok') }}">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual{{ $id ?? '' }}">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual{{ $id ?? '' }}" name="harga_jual"
                            value="{{ $id ? $harga_jual : old('harga_jual') }}">
                    </div>
                    <div class="form-group">
                        <label for="stok{{ $id ?? '' }}">Stok</label>
                        <input type="number" class="form-control" id="stok{{ $id ?? '' }}" name="stok"
                            value="{{ $id ? $stok : old('stok') }}">
                    </div>
                    <div class="form-group">
                        <label for="stok_minimum{{ $id ?? '' }}">Stok Minimum</label>
                        <input type="number" class="form-control" id="stok_minimum{{ $id ?? '' }}" name="stok_minimum"
                            value="{{ $id ? $stok_minimum : old('stok_minimum') }}">
                    </div>
                    <div class="form-group">
                        <label for="is_active{{ $id ?? '' }}">Aktif</label>
                        <select name="is_active" id="is_active{{ $id ?? '' }}" class="form-control">
                            <option value="Y" {{ old('is_active') == 'Y' || (isset($product) && $product->is_active == 'Y') ? 'selected' : '' }}>Ya</option>
                            <option value="N" {{ old('is_active') == 'N' || (isset($product) && $product->is_active == 'N') ? 'selected' : '' }}>Tidak</option>
                        </select>
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
