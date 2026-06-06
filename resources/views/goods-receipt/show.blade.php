@extends('layouts.app')
@section('content_tittle', 'Detail Penerimaan Barang')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Detail Penerimaan Barang</h4>
            <div>
                <a href="{{ route('transaksi.goods-receipt.print', $goodsReceipt->id) }}" target="_blank" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Print
                </a>
                <a href="{{ route('transaksi.goods-receipt.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Kode Penerimaan</strong></td>
                            <td>: {{ $goodsReceipt->kode_penerimaan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>: {{ $goodsReceipt->tanggal->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Supplier</strong></td>
                            <td>: {{ $goodsReceipt->supplier->nama_supplier ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Invoice Supplier</strong></td>
                            <td>: {{ $goodsReceipt->nomor_invoice_supplier ?: '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>User</strong></td>
                            <td>: {{ $goodsReceipt->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <span class="badge bg-success">{{ ucfirst($goodsReceipt->status) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan</strong></td>
                            <td>: {{ $goodsReceipt->keterangan ?: '-' }}</td>
                        </tr>
                        @if($goodsReceipt->dokumen)
                        <tr>
                            <td><strong>Dokumen</strong></td>
                            <td>:
                                <a href="{{ asset('storage/' . $goodsReceipt->dokumen) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Lihat Dokumen
                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <h5>Detail Item</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>SKU</th>
                            <th>Stok Sebelum</th>
                            <th>Qty</th>
                            <th>Stok Sesudah</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($goodsReceipt->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->nama_produk ?? '-' }}</td>
                                <td>{{ $item->product->sku ?? '-' }}</td>
                                <td>{{ $item->stok_sebelum }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->stok_sesudah }}</td>
                                <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ number_format($item->qty * $item->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>{{ $goodsReceipt->total_qty }}</th>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
