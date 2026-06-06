<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Total Produk
        $totalProduk = Product::count();

        // Stok Menipis (di bawah stok_minimum)
        $stokMenipis = Product::whereColumn('stok', '<=', 'stok_minimum')->count();

        // Barang Masuk Bulan Ini (dari StockLog)
        $barangMasuk = StockLog::where('tipe', 'masuk')
            ->whereMonth('tanggal', now()->month)
            ->sum('qty');

        // Barang Keluar Bulan Ini (dari StockLog)
        $barangKeluar = StockLog::where('tipe', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->sum('qty');

        // Total Penjualan Bulan Ini
        $totalPenjualan = Penjualan::whereMonth('tanggal', now()->month)
            ->sum('total');

        // Total Keuntungan Bulan Ini
        $totalKeuntungan = Penjualan::whereMonth('tanggal', now()->month)
            ->sum('keuntungan');

        // Total Pengeluaran Bulan Ini
        $totalPengeluaran = Pengeluaran::whereMonth('tanggal', now()->month)
            ->sum('jumlah');

        // Selisih Keuntungan (Keuntungan - Pengeluaran)
        $selisihKeuntungan = $totalKeuntungan - $totalPengeluaran;

        // Chart Data - 7 Hari Terakhir
        $chartData = $this->getChartData();

        // Chart Keuntungan vs Pengeluaran
        $chartKeuntungan = $this->getChartKeuntungan();

        return view('dashboard.index', compact(
            'totalProduk',
            'stokMenipis',
            'barangMasuk',
            'barangKeluar',
            'totalPenjualan',
            'totalKeuntungan',
            'totalPengeluaran',
            'selisihKeuntungan',
            'chartData',
            'chartKeuntungan'
        ));
    }

    private function getChartData()
    {
        $labels = [];
        $penjualan = [];
        $penerimaan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');

            $penjualan[] = Penjualan::whereDate('tanggal', $date)->sum('total');
            $penerimaan[] = StockLog::whereDate('tanggal', $date)
                ->where('tipe', 'masuk')->sum('qty');
        }

        return [
            'labels' => $labels,
            'penjualan' => $penjualan,
            'penerimaan' => $penerimaan
        ];
    }

    private function getChartKeuntungan()
    {
        $labels = [];
        $keuntungan = [];
        $pengeluaran = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');

            $keuntungan[] = Penjualan::whereDate('tanggal', $date)->sum('keuntungan');
            $pengeluaran[] = Pengeluaran::whereDate('tanggal', $date)->sum('jumlah');
        }

        return [
            'labels' => $labels,
            'keuntungan' => $keuntungan,
            'pengeluaran' => $pengeluaran
        ];
    }
}
