@extends('layouts.app')
@section('content_tittle', 'Penerimaan Barang')
@section('content')
    <div class="row">
        <!-- Statistik -->
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Transaksi Hari Ini</h5>
                    <h2>{{ $statsToday['total_transaksi'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Item Hari Ini</h5>
                    <h2>{{ $statsToday['total_produk'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total Qty Hari Ini</h5>
                    <h2>{{ $statsToday['total_qty'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Stok Menipis -->
    @if($stokMenipis->count() > 0)
        <div class="alert alert-warning mt-3">
            <strong><i class="fas fa-exclamation-triangle"></i> Peringatan Stok Menipis!</strong>
            <ul class="mb-0">
                @foreach($stokMenipis as $product)
                    <li>{{ $product->nama_produk }} - Stok: {{ $product->stok }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Daftar Penerimaan Barang</h4>
            <a href="{{ route('transaksi.goods-receipt.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Penerimaan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Penerimaan</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Qty</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($goodsReceipts as $index => $receipt)
                            <tr>
                                <td>{{ $goodsReceipts->firstItem() + $index }}</td>
                                <td>{{ $receipt->kode_penerimaan }}</td>
                                <td>{{ $receipt->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $receipt->supplier->nama_supplier ?? '-' }}</td>
                                <td>{{ $receipt->total_item }}</td>
                                <td>{{ $receipt->total_qty }}</td>
                                <td>{{ $receipt->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($receipt->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('transaksi.goods-receipt.show', $receipt->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transaksi.goods-receipt.print', $receipt->id) }}" target="_blank" class="btn btn-sm btn-secondary" title="Print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('transaksi.goods-receipt.destroy', $receipt->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $goodsReceipts->links() }}
        </div>
    </div>
@endsection
