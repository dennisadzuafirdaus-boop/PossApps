@extends('layouts.app')
@section('content_tittle', 'Tambah Penerimaan Barang')
@section('content')
    <!-- Notifikasi Stok Menipis -->
    @if($stokMenipis->count() > 0)
        <div class="alert alert-warning">
            <strong><i class="fas fa-exclamation-triangle"></i> Peringatan Stok Menipis!</strong>
            <ul class="mb-0">
                @foreach($stokMenipis as $product)
                    <li>{{ $product->nama_produk }} - Stok: {{ $product->stok }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Form Penerimaan Barang</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.goods-receipt.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Kode Penerimaan</label>
                            <input type="text" class="form-control" value="{{ $kodePenerimaan }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>No. Invoice Supplier</label>
                            <input type="text" name="nomor_invoice_supplier" class="form-control" value="{{ old('nomor_invoice_supplier') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Dokumen (Invoice/Foto)</label>
                            <input type="file" name="dokumen" class="form-control" accept="image/*,.pdf">
                            <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                        </div>
                    </div>
                </div>

                <!-- Barcode Scanner -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Scan Barcode / Input SKU</label>
                        <div class="input-group">
                            <input type="text" id="barcode" class="form-control" placeholder="Scan atau ketik SKU...">
                            <button type="button" id="btnScan" class="btn btn-primary">
                                <i class="fas fa-barcode"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label>Cari Produk</label>
                        <select id="product_select" class="form-control">
                            <option value="">Ketik untuk mencari produk...</option>
                        </select>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="table-responsive mb-3">
                    <table class="table table-bordered" id="itemsTable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Produk</th>
                                <th width="10%">Stok</th>
                                <th width="12%">Qty <span class="text-danger">*</span></th>
                                <th width="15%">Harga Beli <span class="text-danger">*</span></th>
                                <th width="15%">Subtotal</th>
                                <th width="10%">Keterangan</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items akan ditambahkan via JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total Item:</th>
                                <th id="totalItem">0</th>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">Total Qty:</th>
                                <th id="totalQty">0</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('transaksi.goods-receipt.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        let items = [];
        let itemIndex = 0;
        let findByBarcodeUrl = '{{ route('transaksi.goods-receipt.find-by-barcode') }}';
        let getProductUrl = '{{ route('transaksi.goods-receipt.get-product') }}';

        // Initialize Select2 for product
        $('#product_select').select2({
            theme: 'bootstrap',
            placeholder: 'Ketik untuk mencari produk...',
            ajax: {
                url: getProductUrl,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { search: params.term };
                },
                processResults: function(data) {
                    return { results: data.results };
                }
            },
            minimumInputLength: 2
        });

        // When product selected
        $('#product_select').on('select2:select', function(e) {
            let product = e.params.data;
            addItem(product);
            $(this).val(null).trigger('change');
        });

        // Scan barcode - Button click
        $(document).on('click', '#btnScan', function(e) {
            e.preventDefault();
            let barcode = $('#barcode').val().trim();
            if (!barcode) {
                alert('Masukkan SKU atau scan barcode terlebih dahulu!');
                return;
            }

            $.ajax({
                url: findByBarcodeUrl,
                type: 'GET',
                data: { barcode: barcode },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        addItem(res.product);
                        $('#barcode').val('');
                    } else {
                        alert(res.message || 'Produk tidak ditemukan');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mencari produk');
                }
            });
        });

        // Enter key on barcode input
        $(document).on('keypress', '#barcode', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#btnScan').trigger('click');
            }
        });

        // Add item to table
        function addItem(product) {
            // Check if already exists
            if (items.find(i => i.id == product.id)) {
                alert('Produk sudah ada di daftar!');
                return;
            }

            let item = {
                id: product.id,
                nama_produk: product.nama_produk,
                sku: product.sku,
                stok: product.stok,
                harga_beli: product.harga_beli || 0
            };
            items.push(item);

            let row = `
                <tr data-index="${itemIndex}">
                    <td>${itemIndex + 1}</td>
                    <td>
                        ${item.nama_produk} (${item.sku})
                        <input type="hidden" name="items[${itemIndex}][product_id]" value="${item.id}">
                    </td>
                    <td>${item.stok}</td>
                    <td>
                        <input type="number" name="items[${itemIndex}][qty]" class="form-control form-control-sm qty-input" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" name="items[${itemIndex}][harga_beli]" class="form-control form-control-sm harga-input" value="${item.harga_beli}" min="0" required>
                    </td>
                    <td class="subtotal">${item.harga_beli}</td>
                    <td>
                        <input type="text" name="items[${itemIndex}][keterangan]" class="form-control form-control-sm">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#itemsBody').append(row);
            itemIndex++;
            calculateTotal();
        }

        // Remove item
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
            items = items.filter(i => i.id != $(this).closest('tr').find('input[name$="[product_id]"]').val());
            reindexRows();
            calculateTotal();
        });

        // Calculate subtotal and total
        $(document).on('input', '.qty-input, .harga-input', function() {
            let row = $(this).closest('tr');
            let qty = parseFloat(row.find('.qty-input').val()) || 0;
            let harga = parseFloat(row.find('.harga-input').val()) || 0;
            row.find('.subtotal').text((qty * harga).toLocaleString('id-ID'));
            calculateTotal();
        });

        // Calculate total
        function calculateTotal() {
            let totalItem = 0;
            let totalQty = 0;

            $('#itemsBody tr').each(function() {
                totalItem++;
                totalQty += parseFloat($(this).find('.qty-input').val()) || 0;
            });

            $('#totalItem').text(totalItem);
            $('#totalQty').text(totalQty);
        }

        // Reindex rows
        function reindexRows() {
            $('#itemsBody tr').each(function(i) {
                $(this).find('td:first').text(i + 1);
                $(this).find('input').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, `[${i}]`);
                        $(this).attr('name', name);
                    }
                });
            });
            itemIndex = $('#itemsBody tr').length;
        }

        // Form validation
        $('form').submit(function(e) {
            if ($('#itemsBody tr').length == 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 produk yang ditambahkan!');
            }
        });
    });
</script>
@endpush
