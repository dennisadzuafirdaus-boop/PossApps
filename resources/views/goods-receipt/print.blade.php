<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penerimaan Barang - {{ $goodsReceipt->kode_penerimaan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info .label {
            width: 150px;
            font-weight: bold;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
        }
        table.items th, table.items td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table.items th {
            background-color: #f0f0f0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
        }
        .signature {
            width: 200px;
            float: left;
            text-align: center;
        }
        .signature-right {
            float: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PENERIMAAN BARANG</h2>
        <p>{{ config('app.name', 'POS Application') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label">Kode Penerimaan</td>
                <td>: {{ $goodsReceipt->kode_penerimaan }}</td>
                <td class="label">User</td>
                <td>: {{ $goodsReceipt->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $goodsReceipt->tanggal->format('d/m/Y') }}</td>
                <td class="label">Status</td>
                <td>: {{ ucfirst($goodsReceipt->status) }}</td>
            </tr>
            <tr>
                <td class="label">Supplier</td>
                <td>: {{ $goodsReceipt->supplier->nama_supplier ?? '-' }}</td>
                <td class="label">No. Invoice</td>
                <td>: {{ $goodsReceipt->nomor_invoice_supplier ?: '-' }}</td>
            </tr>
            @if($goodsReceipt->keterangan)
            <tr>
                <td class="label">Keterangan</td>
                <td colspan="3">: {{ $goodsReceipt->keterangan }}</td>
            </tr>
            @endif
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Produk</th>
                <th>SKU</th>
                <th class="text-center">Stok Sebelum</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Stok Sesudah</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($goodsReceipt->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->nama_produk ?? '-' }}</td>
                    <td>{{ $item->product->sku ?? '-' }}</td>
                    <td class="text-center">{{ $item->stok_sebelum }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">{{ $item->stok_sesudah }}</td>
                    <td class="text-right">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->qty * $item->harga_beli, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total:</th>
                <th class="text-center">{{ $goodsReceipt->total_qty }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Dibuat oleh,</p>
            <br><br><br>
            <p>{{ $goodsReceipt->user->name ?? '-' }}</p>
        </div>
        <div class="signature signature-right">
            <p>Diterima oleh,</p>
            <br><br><br>
            <p>_______________________</p>
        </div>
    </div>

    <p style="text-align: center; margin-top: 50px; font-size: 10px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </p>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
