<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // ID => nama file gambar
            1 => 'Kemaja_pria_formal.png', // Blouse & Kemeja - pakai kemeja sebagai placeholder
            2 => 'NB530.png',
            3 => 'Kemaja_pria_formal.png',
            4 => 'Kaos_boxy.png',
            5 => 'Celana_Chino_pria.png',
            6 => 'Jacket_bomber_pria.png',
            7 => 'Polo_Tshirt_pria.png',
            8 => 'dres-casual_wanita.png', // Blouse Wanita Elegant - pakai dress sebagai placeholder
            9 => 'dres-casual_wanita.png',
            10 => 'Rok_plisket.png',
            11 => 'dres-casual_wanita.png', // Cardigan Wanita - pakai dress sebagai placeholder
            12 => 'Celana_Palazo_Wanita.png',
            13 => 'Celana_Baggy_pria.png',
        ];

        foreach ($products as $id => $image) {
            \App\Models\Product::where('id', $id)->update(['image' => $image]);
        }
    }
}
