<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { color: #666; }
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-box { width: 48%; }
        .info-box h4 { background: #f0f0f0; padding: 8px; margin-bottom: 10px; }
        .info-box p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .total-row { background: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 11px; }
        .status { display: inline-block; padding: 3px 10px; border-radius: 3px; color: #fff; }
        .status-pending { background: #ffc107; color: #000; }
        .status-confirmed { background: #17a2b8; }
        .status-completed { background: #28a745; }
        .status-cancelled { background: #dc3545; }
        @media print { body { padding: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>{{ config('app.name', 'POS Application') }}</p>
    </div>

    <div class="info">
        <div class="info-box">
            <h4>Informasi Order</h4>
            <p><strong>No. Order:</strong> {{ $order->order_number }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Status:</strong> <span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Metode Bayar:</strong> {{ strtoupper($order->payment_method) }}</p>
        </div>
        <div class="info-box">
            <h4>Informasi Customer</h4>
            <p><strong>{{ $order->customer_name }}</strong></p>
            <p>{{ $order->customer_phone }}</p>
            <p>{{ $order->customer_email }}</p>
            <p>{{ $order->customer_address }}</p>
            <p>{{ $order->customer_city }} {{ $order->customer_postal_code }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>SKU</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_sku }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right"><strong>Ongkos Kirim:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></td>
            </tr>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    @if($order->notes)
        <div style="margin-bottom: 20px;">
            <strong>Catatan:</strong>
            <p>{{ $order->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah berbelanja di {{ config('app.name', 'POS Application') }}</p>
        <p>Invoice ini dicetak pada {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
