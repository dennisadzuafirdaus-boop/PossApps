@extends('layouts.app')
@section('content_tittle', 'Laporan Stock Log')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Laporan Stock Log</h4>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.stock-log.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-2">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Tipe</label>
                        <select name="tipe" class="form-control">
                            <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Produk</label>
                        <select name="product_id" class="form-control">
                            <option value="">Semua Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari produk/SKU..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('laporan.stock-log.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                        <a href="{{ route('laporan.stock-log.export-excel', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="{{ route('laporan.stock-log.print', request()->all()) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No. Transaksi</th>
                            <th>Produk</th>
                            <th>SKU</th>
                            <th>Tipe</th>
                            <th>Qty</th>
                            <th>Stok Sebelum</th>
                            <th>Stok Sesudah</th>
                            <th>User</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockLogs as $index => $log)
                            <tr>
                                <td>{{ $stockLogs->firstItem() + $index }}</td>
                                <td>{{ $log->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $log->nomor_transaksi }}</td>
                                <td>{{ $log->product->nama_produk ?? '-' }}</td>
                                <td>{{ $log->product->sku ?? '-' }}</td>
                                <td>
                                    @if($log->tipe == 'masuk')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-danger">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $log->qty }}</td>
                                <td>{{ $log->stok_sebelum }}</td>
                                <td>{{ $log->stok_sesudah }}</td>
                                <td>{{ $log->user->name ?? '-' }}</td>
                                <td>{{ $log->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $stockLogs->links() }}
        </div>
    </div>
@endsection
