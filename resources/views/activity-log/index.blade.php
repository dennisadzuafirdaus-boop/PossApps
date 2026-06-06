@extends('layouts.app')
@section('content_tittle', 'Laporan Activity Log')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Laporan Activity Log</h4>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.activity-log.index') }}" class="mb-4">
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
                        <label>Tipe Log</label>
                        <select name="log_type" class="form-control">
                            <option value="">Semua</option>
                            <option value="stock" {{ request('log_type') == 'stock' ? 'selected' : '' }}>Stock</option>
                            <option value="transaksi" {{ request('log_type') == 'transaksi' ? 'selected' : '' }}>Transaksi</option>
                            <option value="user" {{ request('log_type') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="product" {{ request('log_type') == 'product' ? 'selected' : '' }}>Product</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari pesan..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('laporan.activity-log.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                        <a href="{{ route('laporan.activity-log.export-excel', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export
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
                            <th>Tipe Log</th>
                            <th>User</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $index => $log)
                            <tr>
                                <td>{{ $activityLogs->firstItem() + $index }}</td>
                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($log->log_type == 'stock')
                                        <span class="badge bg-info">Stock</span>
                                    @elseif($log->log_type == 'transaksi')
                                        <span class="badge bg-primary">Transaksi</span>
                                    @elseif($log->log_type == 'user')
                                        <span class="badge bg-warning">User</span>
                                    @elseif($log->log_type == 'product')
                                        <span class="badge bg-success">Product</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($log->log_type) }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->user->name ?? '-' }}</td>
                                <td>{{ $log->pesan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $activityLogs->links() }}
        </div>
    </div>
@endsection
