@extends('layouts.app')
@section('content_tittle', 'Data Supplier')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Data Supplier</h4>
            @if(auth()->user()->role === 'admin')
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSupplier" onclick="resetForm()">
                <i class="fas fa-plus"></i> Tambah Supplier
            </button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Kontak Person</th>
                            <th>Status</th>
                            @if(auth()->user()->role === 'admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                            <tr>
                                <td>{{ $suppliers->firstItem() + $index }}</td>
                                <td>{{ $supplier->kode_supplier }}</td>
                                <td>{{ $supplier->nama_supplier }}</td>
                                <td>{{ $supplier->telepon ?: '-' }}</td>
                                <td>{{ $supplier->email ?: '-' }}</td>
                                <td>{{ $supplier->kontak_person ?: '-' }}</td>
                                <td>
                                    @if($supplier->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role === 'admin')
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editSupplier({{ $supplier->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('master-data.supplier.toggle-status', $supplier->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $supplier->is_active ? 'secondary' : 'success' }}" title="{{ $supplier->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $supplier->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('master-data.supplier.destroy', $supplier->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $suppliers->links() }}
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <!-- Modal Supplier -->
    <div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('master-data.supplier.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="supplier_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kontak Person</label>
                            <input type="text" name="kontak_person" id="kontak_person" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@if(auth()->user()->role === 'admin')
@push('script')
<script>
    function resetForm() {
        document.getElementById('supplier_id').value = '';
        document.getElementById('nama_supplier').value = '';
        document.getElementById('alamat').value = '';
        document.getElementById('telepon').value = '';
        document.getElementById('email').value = '';
        document.getElementById('kontak_person').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Supplier';
    }

    function editSupplier(id) {
        fetch(`{{ route('master-data.supplier.edit', 0) }}`.replace('0', id))
            .then(response => response.json())
            .then(data => {
                document.getElementById('supplier_id').value = data.id;
                document.getElementById('nama_supplier').value = data.nama_supplier;
                document.getElementById('alamat').value = data.alamat || '';
                document.getElementById('telepon').value = data.telepon || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('kontak_person').value = data.kontak_person || '';
                document.getElementById('modalTitle').textContent = 'Edit Supplier';
                $('#modalSupplier').modal('show');
            });
    }
</script>
@endpush
@endif
