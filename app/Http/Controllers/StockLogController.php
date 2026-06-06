<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockLog;
use App\Models\Product;
use App\Exports\StockLogExport;
use Maatwebsite\Excel\Facades\Excel;

class StockLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockLog::with(['product', 'user']);

        // Filter berdasarkan tanggal
        if ($request->start_date) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        // Filter berdasarkan tipe
        if ($request->tipe && $request->tipe != 'semua') {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan produk
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $stockLogs = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $products = Product::where('is_active', true)->get();

        return view('stock-log.index', compact('stockLogs', 'products'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'tipe' => $request->tipe,
            'product_id' => $request->product_id,
        ];

        return Excel::download(new StockLogExport($filters), 'stock-log-' . date('Y-m-d-H-i-s') . '.xlsx');
    }

    /**
     * Print report
     */
    public function print(Request $request)
    {
        $query = StockLog::with(['product', 'user']);

        if ($request->start_date) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('tanggal', '<=', $request->end_date);
        }
        if ($request->tipe && $request->tipe != 'semua') {
            $query->where('tipe', $request->tipe);
        }
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $stockLogs = $query->orderBy('tanggal', 'desc')->get();

        return view('stock-log.print', compact('stockLogs'));
    }
}
