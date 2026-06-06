@extends('layouts.app')
@section('content_tittle', 'Dashboard')
@section('content')
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-primary welcome-card animate-fadeInUp">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-2">
                                <i class="fas fa-hand-sparkles mr-2"></i>
                                Selamat Datang, <strong>{{ ucwords(auth()->user()->name) }}</strong>!
                            </h2>
                            <p class="text-white mb-3">
                                <i class="fas fa-calendar-day mr-2"></i>
                                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </p>
                            <div class="d-flex align-items-center">
                                <span class="text-white mr-2">Login sebagai:</span>
                                <span class="badge {{ auth()->user()->role == 'admin' ? 'badge-danger' : 'badge-info' }} px-3 py-2">
                                    <i class="fas {{ auth()->user()->role == 'admin' ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                                    {{ strtoupper(auth()->user()->role) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center d-none d-md-block">
                            <div class="animate-float">
                                <i class="fas fa-store fa-5x text-white opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info animate-fadeInUp" style="animation-delay: 0.1s;">
                <div class="inner">
                    <h3><i class="fas fa-box mr-2 opacity-50"></i>{{ $totalProduk }}</h3>
                    <p>Total Produk</p>
                </div>
                <div class="icon animate-float"><i class="fas fa-box-open"></i></div>
                <a href="{{ route('master-data.product.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning animate-fadeInUp" style="animation-delay: 0.2s;">
                <div class="inner">
                    <h3><i class="fas fa-exclamation-triangle mr-2 opacity-50"></i>{{ $stokMenipis }}</h3>
                    <p>Stok Menipis</p>
                </div>
                <div class="icon animate-float"><i class="fas fa-exclamation-circle"></i></div>
                <a href="{{ route('master-data.product.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success animate-fadeInUp" style="animation-delay: 0.3s;">
                <div class="inner">
                    <h3><i class="fas fa-arrow-down mr-2 opacity-50"></i>{{ $barangMasuk }}</h3>
                    <p>Barang Masuk</p>
                </div>
                <div class="icon animate-float"><i class="fas fa-truck-loading"></i></div>
                <a href="{{ route('transaksi.goods-receipt.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger animate-fadeInUp" style="animation-delay: 0.4s;">
                <div class="inner">
                    <h3><i class="fas fa-arrow-up mr-2 opacity-50"></i>{{ $barangKeluar }}</h3>
                    <p>Barang Keluar</p>
                </div>
                <div class="icon animate-float"><i class="fas fa-shipping-fast"></i></div>
                <a href="{{ route('laporan.stock-log.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Financial Stats -->
    <div class="row">
        <div class="col-md-4">
            <div class="card animate-fadeInUp" style="animation-delay: 0.5s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><i class="fas fa-shopping-cart mr-2 text-info"></i>Total Penjualan</p>
                            <h3 class="font-weight-bold mb-0">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                            <small class="text-success"><i class="fas fa-calendar mr-1"></i>Bulan Ini</small>
                        </div>
                        <div class="p-3 rounded-circle bg-gradient-info text-white">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card animate-fadeInUp" style="animation-delay: 0.6s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><i class="fas fa-chart-line mr-2 text-success"></i>Total Keuntungan</p>
                            <h3 class="font-weight-bold mb-0 text-success">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</h3>
                            <small class="text-success"><i class="fas fa-calendar mr-1"></i>Bulan Ini</small>
                        </div>
                        <div class="p-3 rounded-circle bg-gradient-success text-white">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card animate-fadeInUp" style="animation-delay: 0.7s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1"><i class="fas fa-balance-scale mr-2 {{ $selisihKeuntungan >= 0 ? 'text-primary' : 'text-danger' }}"></i>
                                {{ $selisihKeuntungan >= 0 ? 'Selisih Keuntungan' : 'Selisih Kerugian' }}
                            </p>
                            <h3 class="font-weight-bold mb-0 {{ $selisihKeuntungan >= 0 ? 'text-primary' : 'text-danger' }}">
                                Rp {{ number_format(abs($selisihKeuntungan), 0, ',', '.') }}
                            </h3>
                            <small class="{{ $selisihKeuntungan >= 0 ? 'text-success' : 'text-danger' }}">
                                <i class="fas {{ $selisihKeuntungan >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                {{ $selisihKeuntungan >= 0 ? 'Untung' : 'Rugi' }}
                            </small>
                        </div>
                        <div class="p-3 rounded-circle {{ $selisihKeuntungan >= 0 ? 'bg-gradient-primary' : 'bg-gradient-danger' }} text-white">
                            <i class="fas {{ $selisihKeuntungan >= 0 ? 'fa-coins' : 'fa-chart-pie' }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card animate-fadeInUp" style="animation-delay: 0.8s;">
                <div class="card-header border-0 bg-transparent">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-chart-bar text-primary mr-2"></i>
                        Penjualan & Penerimaan
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">7 Hari Terakhir</span>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <canvas id="chartPenjualan" style="min-height: 280px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card animate-fadeInUp" style="animation-delay: 0.9s;">
                <div class="card-header border-0 bg-transparent">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-chart-line text-success mr-2"></i>
                        Keuntungan vs Pengeluaran
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-success">7 Hari Terakhir</span>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <canvas id="chartKeuntungan" style="min-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card animate-fadeInUp" style="animation-delay: 1s;">
                <div class="card-header border-0 bg-transparent">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-bolt text-warning mr-2"></i>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('master-data.product.index') }}" class="btn btn-block bg-gradient-primary btn-lg">
                                <i class="fas fa-box mr-2"></i>Kelola Produk
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('transaksi.goods-receipt.create') }}" class="btn btn-block bg-gradient-success btn-lg">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Stok
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('master-data.kategori.index') }}" class="btn btn-block bg-gradient-info btn-lg">
                                <i class="fas fa-tags mr-2"></i>Kategori
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-block bg-gradient-dark btn-lg">
                                <i class="fas fa-users mr-2"></i>Kelola User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Penjualan & Penerimaan
    var ctx1 = document.getElementById('chartPenjualan').getContext('2d');
    var gradient1 = ctx1.createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, 'rgba(102, 126, 234, 0.5)');
    gradient1.addColorStop(1, 'rgba(102, 126, 234, 0.0)');

    var gradient2 = ctx1.createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, 'rgba(17, 153, 142, 0.5)');
    gradient2.addColorStop(1, 'rgba(17, 153, 142, 0.0)');

    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($chartData['penjualan']),
                backgroundColor: gradient1,
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }, {
                label: 'Penerimaan (Qty)',
                data: @json($chartData['penerimaan']),
                backgroundColor: gradient2,
                borderColor: 'rgba(17, 153, 142, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });

    // Chart Keuntungan vs Pengeluaran
    var ctx2 = document.getElementById('chartKeuntungan').getContext('2d');
    var gradient3 = ctx2.createLinearGradient(0, 0, 0, 300);
    gradient3.addColorStop(0, 'rgba(0, 230, 118, 0.4)');
    gradient3.addColorStop(1, 'rgba(0, 230, 118, 0.0)');

    var gradient4 = ctx2.createLinearGradient(0, 0, 0, 300);
    gradient4.addColorStop(0, 'rgba(255, 8, 68, 0.4)');
    gradient4.addColorStop(1, 'rgba(255, 8, 68, 0.0)');

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: @json($chartKeuntungan['labels']),
            datasets: [{
                label: 'Keuntungan (Rp)',
                data: @json($chartKeuntungan['keuntungan']),
                borderColor: 'rgba(0, 230, 118, 1)',
                backgroundColor: gradient3,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: 'rgba(0, 230, 118, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }, {
                label: 'Pengeluaran (Rp)',
                data: @json($chartKeuntungan['pengeluaran']),
                borderColor: 'rgba(255, 8, 68, 1)',
                backgroundColor: gradient4,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: 'rgba(255, 8, 68, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });
</script>
@endpush