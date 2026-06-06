@extends('layouts.app')
@section('content_tittle', 'Data Produk')
@section('content')
    <div class="card">
        <div class="p-2 d-flex justify-content-between border-bottom ">
            <h4 class="h5">Daftar Produk</h4>
            @if(auth()->user()->role === 'admin')
            <div>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#formProduct">
                    Tambah Product
                </button>
            </div>
            @endif
        </div>
        <x-alert.sweetalert :errors="$errors" />
        <div class="card-body">
            <table class="table table-sm table-striped " id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sku</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Stok</th>
                        <th>Aktif</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Opsi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>Rp.{{ number_format($product->harga_jual) }}</td>
                            <td>Rp.{{ number_format($product->harga_beli_pokok) }}</td>
                            <td>{{ number_format($product->stok) }}</td>
                            <td>
                                <p class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </p>
                            </td>
                            @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formProduct{{ $product->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route ('master-data.product.destroy', $product->id) }}" data-confirm-delete="true" class="btn btn-sm btn-danger ml-1">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <!-- Modal Tambah Product - di luar card -->
    <div class="modal fade" id="formProduct" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('master-data.product.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Product Baru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_produk">Nama Product</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}">
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori Product</label>
                            <select name="kategori_id" id="kategori_id" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga_beli_pokok">Harga Beli Pokok</label>
                            <input type="number" class="form-control" id="harga_beli_pokok" name="harga_beli_pokok" value="{{ old('harga_beli_pokok') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok_minimum">Stok Minimum</label>
                            <input type="number" class="form-control" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum') }}">
                        </div>
                        <div class="form-group">
                            <label for="is_active">Aktif</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="Y" {{ old('is_active') == 'Y' ? 'selected' : '' }}>Ya</option>
                                <option value="N" {{ old('is_active') == 'N' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product - di luar card -->
    @foreach ($products as $product)
        <div class="modal fade" id="formProduct{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('master-data.product.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_produk{{ $product->id }}">Nama Product</label>
                                <input type="text" class="form-control" id="nama_produk{{ $product->id }}" name="nama_produk" value="{{ $product->nama_produk }}">
                            </div>
                            <div class="form-group">
                                <label for="kategori_id{{ $product->id }}">Kategori Product</label>
                                <select name="kategori_id" id="kategori_id{{ $product->id }}" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $item)
                                        <option value="{{ $item->id }}" {{ $product->kategori_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_beli_pokok{{ $product->id }}">Harga Beli Pokok</label>
                                <input type="number" class="form-control" id="harga_beli_pokok{{ $product->id }}" name="harga_beli_pokok" value="{{ $product->harga_beli_pokok }}">
                            </div>
                            <div class="form-group">
                                <label for="harga_jual{{ $product->id }}">Harga Jual</label>
                                <input type="number" class="form-control" id="harga_jual{{ $product->id }}" name="harga_jual" value="{{ $product->harga_jual }}">
                            </div>
                            <div class="form-group">
                                <label for="stok{{ $product->id }}">Stok</label>
                                <input type="number" class="form-control" id="stok{{ $product->id }}" name="stok" value="{{ $product->stok }}">
                            </div>
                            <div class="form-group">
                                <label for="stok_minimum{{ $product->id }}">Stok Minimum</label>
                                <input type="number" class="form-control" id="stok_minimum{{ $product->id }}" name="stok_minimum" value="{{ $product->stok_minimum }}">
                            </div>
                            <div class="form-group">
                                <label for="is_active{{ $product->id }}">Aktif</label>
                                <select name="is_active" id="is_active{{ $product->id }}" class="form-control">
                                    <option value="Y" {{ $product->is_active == 'Y' ? 'selected' : '' }}>Ya</option>
                                    <option value="N" {{ $product->is_active == 'N' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    @endif
@endsection
