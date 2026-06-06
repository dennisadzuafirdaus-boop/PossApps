<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stock Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
        }
        .text-center {
            text-align: center;
        }
        .badge-masuk {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .badge-keluar {
            background-color: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
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
        <h2>LAPORAN STOCK LOG</h2>
        <p>Periode: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : '-' }} s/d {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : '-' }}</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
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
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $log->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $log->nomor_transaksi }}</td>
                    <td>{{ $log->product->nama_produk ?? '-' }}</td>
                    <td>{{ $log->product->sku ?? '-' }}</td>
                    <td class="text-center">
                        @if($log->tipe == 'masuk')
                            <span class="badge-masuk">Masuk</span>
                        @else
                            <span class="badge-keluar">Keluar</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $log->qty }}</td>
                    <td class="text-center">{{ $log->stok_sebelum }}</td>
                    <td class="text-center">{{ $log->stok_sesudah }}</td>
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

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
