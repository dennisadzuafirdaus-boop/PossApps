<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Support\Str;

class FashionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori Fashion Pria
        $pria = Kategori::create([
            'nama_kategori' => 'Fashion Pria',
            'slug' => Str::slug('Fashion Pria'),
            'deskripsi' => 'Pakaian dan aksesoris fashion untuk pria'
        ]);

        // Kategori Fashion Wanita
        $wanita = Kategori::create([
            'nama_kategori' => 'Fashion Wanita',
            'slug' => Str::slug('Fashion Wanita'),
            'deskripsi' => 'Pakaian dan aksesoris fashion untuk wanita'
        ]);

        // Produk Fashion Pria
        $produkPria = [
            [
                'nama_produk' => 'Kemeja Pria Formal',
                'harga_beli_pokok' => 150000,
                'harga_jual' => 250000,
                'stok' => 50,
                'stok_minimum' => 10
            ],
            [
                'nama_produk' => 'Kaos Polos Pria',
                'harga_beli_pokok' => 50000,
                'harga_jual' => 85000,
                'stok' => 100,
                'stok_minimum' => 20
            ],
            [
                'nama_produk' => 'Celana Chino Pria',
                'harga_beli_pokok' => 120000,
                'harga_jual' => 200000,
                'stok' => 40,
                'stok_minimum' => 10
            ],
            [
                'nama_produk' => 'Jaket Bomber Pria',
                'harga_beli_pokok' => 200000,
                'harga_jual' => 350000,
                'stok' => 25,
                'stok_minimum' => 5
            ],
            [
                'nama_produk' => 'Polo Shirt Pria',
                'harga_beli_pokok' => 80000,
                'harga_jual' => 130000,
                'stok' => 60,
                'stok_minimum' => 15
            ]
        ];

        foreach ($produkPria as $produk) {
            Product::create([
                'kategori_id' => $pria->id,
                'nama_produk' => $produk['nama_produk'],
                'sku' => Product::nomorSKU(),
                'harga_beli_pokok' => $produk['harga_beli_pokok'],
                'harga_jual' => $produk['harga_jual'],
                'stok' => $produk['stok'],
                'stok_minimum' => $produk['stok_minimum'],
                'is_active' => true
            ]);
        }

        // Produk Fashion Wanita
        $produkWanita = [
            [
                'nama_produk' => 'Blouse Wanita Elegant',
                'harga_beli_pokok' => 100000,
                'harga_jual' => 180000,
                'stok' => 45,
                'stok_minimum' => 10
            ],
            [
                'nama_produk' => 'Dress Casual Wanita',
                'harga_beli_pokok' => 180000,
                'harga_jual' => 300000,
                'stok' => 30,
                'stok_minimum' => 8
            ],
            [
                'nama_produk' => 'Rok Plisket Wanita',
                'harga_beli_pokok' => 90000,
                'harga_jual' => 150000,
                'stok' => 55,
                'stok_minimum' => 12
            ],
            [
                'nama_produk' => 'Cardigan Wanita',
                'harga_beli_pokok' => 130000,
                'harga_jual' => 220000,
                'stok' => 35,
                'stok_minimum' => 8
            ],
            [
                'nama_produk' => 'Celana Palazzo Wanita',
                'harga_beli_pokok' => 110000,
                'harga_jual' => 190000,
                'stok' => 40,
                'stok_minimum' => 10
            ]
        ];

        foreach ($produkWanita as $produk) {
            Product::create([
                'kategori_id' => $wanita->id,
                'nama_produk' => $produk['nama_produk'],
                'sku' => Product::nomorSKU(),
                'harga_beli_pokok' => $produk['harga_beli_pokok'],
                'harga_jual' => $produk['harga_jual'],
                'stok' => $produk['stok'],
                'stok_minimum' => $produk['stok_minimum'],
                'is_active' => true
            ]);
        }
    }
}
