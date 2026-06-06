@extends('layouts.app')
@section('content_tittle', 'Data Kategori')
@section('content')
    <div class="card">
        <div class="p-2 d-flex justify-content-between border-bottom">
            <h4 class="h5">Daftar Kategori</h4>
            @if(auth()->user()->role === 'admin')
            <div>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#formkategori">
                    Tambah Kategori
                </button>
            </div>
            @endif
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <small>{{ $error }}</small>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    <small>{{ session('success') }}</small>
                </div>
            @endif
            <table class="table table-sm table-striped" id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        @if(auth()->user()->role === 'admin')
                        <th>Opsi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formkategori{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route ('master-data.kategori.destroy', $item->id) }}" data-confirm-delete="true" class="btn btn-sm btn-danger ml-1">
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
    <!-- Modal Tambah Kategori - di luar card -->
    <div class="modal fade" id="formkategori" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('master-data.kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Kategori Baru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
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

    <!-- Modal Edit Kategori - di luar card -->
    @foreach ($kategori as $item)
        <div class="modal fade" id="formkategori{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('master-data.kategori.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Kategori</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kategori{{ $item->id }}">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori{{ $item->id }}" name="nama_kategori" value="{{ $item->nama_kategori }}">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi{{ $item->id }}">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi{{ $item->id }}" name="deskripsi" rows="3">{{ $item->deskripsi }}</textarea>
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
