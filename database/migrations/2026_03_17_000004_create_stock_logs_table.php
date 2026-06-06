<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('nomor_transaksi');
            $table->enum('tipe', ['masuk', 'keluar', 'penyesuaian'])->default('masuk');
            $table->integer('qty');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'tanggal']);
            $table->index(['tipe', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
