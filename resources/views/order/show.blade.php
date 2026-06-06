@extends('layouts.app')
@section('content_tittle', 'Detail Order')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Order - {{ $order->order_number }}</h4>
                    <div>
                        <span class="badge bg-{{ $order->status_badge }} fs-6">{{ ucfirst($order->status) }}</span>
                        <span class="badge bg-{{ $order->payment_status_badge }} fs-6">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    <h5 class="mb-3">Produk yang Dipesan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>SKU</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product_sku }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                    <td><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="5" class="text-end"><strong>TOTAL:</strong></td>
                                    <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="mt-3">
                            <h5>Catatan:</h5>
                            <p class="text-muted">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Info Customer</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Nama</td>
                            <td><strong>{{ $order->customer_name }}</strong></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $order->customer_email }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>{{ $order->customer_phone }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $order->customer_address }}</td>
                        </tr>
                        <tr>
                            <td>Kota</td>
                            <td>{{ $order->customer_city }}</td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>{{ $order->customer_postal_code ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Order Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Info Order</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>No. Order</td>
                            <td><strong>{{ $order->order_number }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Metode Bayar</td>
                            <td>{{ strtoupper($order->payment_method) }}</td>
                        </tr>
                        @if($order->confirmed_at)
                            <tr>
                                <td>Dikonfirmasi</td>
                                <td>{{ $order->confirmed_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Oleh</td>
                                <td>{{ $order->confirmer->name ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    @if($order->status == 'pending')
                        <form action="{{ route('order.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi order ini? Stok akan berkurang.')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-check"></i> Konfirmasi Order
                            </button>
                        </form>
                    @endif

                    @if($order->status != 'cancelled')
                        <form action="{{ route('order.update-status', $order->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $order->status == 'confirmed' ? 'processing' : ($order->status == 'processing' ? 'shipped' : ($order->status == 'shipped' ? 'completed' : '')) }}">
                            @if($order->status == 'confirmed')
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-cog"></i> Proses Order
                                </button>
                            @elseif($order->status == 'processing')
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fas fa-shipping-fast"></i> Kirim Order
                                </button>
                            @elseif($order->status == 'shipped')
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check-circle"></i> Selesaikan Order
                                </button>
                            @endif
                        </form>
                    @endif

                    @if($order->payment_status == 'pending' && $order->status != 'cancelled')
                        <form action="{{ route('order.update-payment', $order->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_status" value="paid">
                            <button type="submit" class="btn btn-warning btn-block">
                                <i class="fas fa-money-bill"></i> Tandai Sudah Bayar
                            </button>
                        </form>
                    @endif

                    @if(in_array($order->status, ['pending', 'confirmed']))
                        <form action="{{ route('order.update-status', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan order ini? {{ $order->status == 'confirmed' ? 'Stok akan dikembalikan.' : '' }}')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-times"></i> Batalkan Order
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('order.print', $order->id) }}" target="_blank" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-print"></i> Print Invoice
                    </a>

                    <a href="{{ route('order.index') }}" class="btn btn-outline-secondary btn-block mt-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
