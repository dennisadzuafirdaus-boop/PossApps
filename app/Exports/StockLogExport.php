<?php

namespace App\Exports;

use App\Models\StockLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockLogExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = StockLog::with(['product', 'user']);

        // Apply filters
        if (!empty($this->filters['start_date'])) {
            $query->where('tanggal', '>=', $this->filters['start_date']);
        }
        if (!empty($this->filters['end_date'])) {
            $query->where('tanggal', '<=', $this->filters['end_date']);
        }
        if (!empty($this->filters['tipe']) && $this->filters['tipe'] != 'semua') {
            $query->where('tipe', $this->filters['tipe']);
        }
        if (!empty($this->filters['product_id'])) {
            $query->where('product_id', $this->filters['product_id']);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'No. Transaksi',
            'Produk',
            'SKU',
            'Tipe',
            'Qty',
            'Stok Sebelum',
            'Stok Sesudah',
            'User',
            'Keterangan',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->tanggal->format('d/m/Y'),
            $row->nomor_transaksi,
            $row->product->nama_produk ?? '-',
            $row->product->sku ?? '-',
            ucfirst($row->tipe),
            $row->qty,
            $row->stok_sebelum,
            $row->stok_sesudah,
            $row->user->name ?? '-',
            $row->keterangan ?? '-',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
