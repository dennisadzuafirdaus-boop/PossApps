<!-- Modal Pusat Bantuan -->
<div class="modal fade" id="modalPusatBantuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-question-circle"></i> Pusat Bantuan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Accordion FAQ -->
                <div class="accordion" id="accordionFAQ">
                    <!-- Getting Started -->
                    <div class="card">
                        <div class="card-header" id="heading1">
                            <h2 class="mb-0">
                                <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse1">
                                    <i class="fas fa-play-circle text-primary mr-2"></i> Memulai Aplikasi
                                </button>
                            </h2>
                        </div>
                        <div id="collapse1" class="collapse show" data-parent="#accordionFAQ">
                            <div class="card-body">
                                <ol>
                                    <li><strong>Setup Master Data</strong> - Mulai dengan mengisi data Kategori, Supplier, dan Product</li>
                                    <li><strong>Buat User</strong> - Tambahkan user lain jika diperlukan</li>
                                    <li><strong>Transaksi</strong> - Catat penerimaan barang dari supplier</li>
                                    <li><strong>Monitoring</strong> - Pantau stok dan aktivitas melalui Dashboard dan Laporan</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Master Data -->
                    <div class="card">
                        <div class="card-header" id="heading2">
                            <h2 class="mb-0">
                                <button class="btn btn-link w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse2">
                                    <i class="fas fa-database text-success mr-2"></i> Master Data
                                </button>
                            </h2>
                        </div>
                        <div id="collapse2" class="collapse" data-parent="#accordionFAQ">
                            <div class="card-body">
                                <p><strong>Kategori:</strong> Kelompokkan produk berdasarkan jenisnya</p>
                                <p><strong>Supplier:</strong> Data pemasok barang</p>
                                <p><strong>Product:</strong> Daftar produk dengan info stok dan harga</p>
                                <p class="text-muted"><i class="fas fa-lightbulb text-warning"></i> SKU produk dibuat otomatis sistem</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div class="card">
                        <div class="card-header" id="heading3">
                            <h2 class="mb-0">
                                <button class="btn btn-link w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse3">
                                    <i class="fas fa-exchange-alt text-warning mr-2"></i> Transaksi Penerimaan Barang
                                </button>
                            </h2>
                        </div>
                        <div id="collapse3" class="collapse" data-parent="#accordionFAQ">
                            <div class="card-body">
                                <ol>
                                    <li>Pilih Supplier (opsional)</li>
                                    <li>Scan barcode atau cari produk</li>
                                    <li>Input quantity dan harga beli</li>
                                    <li>Tambahkan produk lain jika perlu</li>
                                    <li>Upload dokumen pendukung (opsional)</li>
                                    <li>Simpan transaksi</li>
                                </ol>
                                <p class="text-info"><i class="fas fa-info-circle"></i> Stok akan otomatis bertambah setelah transaksi disimpan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Laporan -->
                    <div class="card">
                        <div class="card-header" id="heading4">
                            <h2 class="mb-0">
                                <button class="btn btn-link w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse4">
                                    <i class="fas fa-chart-bar text-info mr-2"></i> Laporan
                                </button>
                            </h2>
                        </div>
                        <div id="collapse4" class="collapse" data-parent="#accordionFAQ">
                            <div class="card-body">
                                <p><strong>Stock Log:</strong> Riwayat perubahan stok (masuk/keluar)</p>
                                <p><strong>Activity Log:</strong> Semua aktivitas yang dilakukan di sistem</p>
                                <p><strong>Dashboard:</strong> Statistik dan ringkasan data</p>
                                <p class="text-muted"><i class="fas fa-lightbulb text-warning"></i> Gunakan filter untuk mencari data spesifik</p>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="card">
                        <div class="card-header" id="heading5">
                            <h2 class="mb-0">
                                <button class="btn btn-link w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse5">
                                    <i class="fas fa-key text-danger mr-2"></i> Password & Keamanan
                                </button>
                            </h2>
                        </div>
                        <div id="collapse5" class="collapse" data-parent="#accordionFAQ">
                            <div class="card-body">
                                <p><strong>Password Default:</strong> <code>CTR123</code></p>
                                <p><strong>Syarat Password Baru:</strong></p>
                                <ul>
                                    <li>Minimal 5 karakter</li>
                                    <li>Mengandung huruf besar dan kecil</li>
                                    <li>Mengandung angka</li>
                                </ul>
                                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Segera ganti password default setelah login pertama!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6><i class="fas fa-headset text-primary"></i> Butuh Bantuan Lebih?</h6>
                    <p class="mb-1 small">Hubungi administrator atau developer:</p>
                    <p class="mb-0 small">
                        <i class="fas fa-envelope mr-2"></i> dennis.adzua@example.com<br>
                        <i class="fas fa-phone mr-2"></i> +62 xxx-xxxx-xxxx
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
