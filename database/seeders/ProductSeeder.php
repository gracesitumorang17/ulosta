<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Ulos Ragi Hotang',
                'description' => 'Ulos tradisional dengan motif ulos Ragi Hotang yang indah',
                'price' => 800000,
                'original_price' => 1000000,
                'tag' => 'Ragi Hotang',
                'category' => 'Pernikahan',
                'image' => 'Ulos Ragi Hotang.jpg',
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Sibolang',
                'description' => 'Ulos tradisional dengan motif khas',
                'price' => 450000,
                'original_price' => 600000,
                'tag' => 'Sibolang',
                'category' => 'Kematian',
                'image' => 'Ulos Sibolang Rasta Pamontari.jpg',
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Mangiring',
                'description' => 'Ulos tradisional dengan motif halus',
                'price' => 380000,
                'original_price' => 500000,
                'tag' => 'Mangiring',
                'category' => 'Syukuran',
                'image' => 'Ulos Mangiring.jpg',
                'stock' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Sadum',
                'description' => 'Tenunan berkualitas tinggi',
                'price' => 600000,
                'original_price' => 750000,
                'tag' => 'Sadum',
                'category' => 'Pernikahan',
                'image' => 'Ulos Sadum.jpeg',
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Bintang Maratur',
                'description' => 'Motif tradisional khas Batak',
                'price' => 490000,
                'original_price' => 650000,
                'tag' => 'Bintang Maratur',
                'category' => 'Pernikahan',
                'image' => 'Ulos Bintang Maratur.jpg',
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Ragi Hidup',
                'description' => 'Kerajinan dari pengrajin lokal',
                'price' => 350000,
                'original_price' => 450000,
                'tag' => 'Ragidup',
                'category' => 'Pernikahan',
                'image' => 'Ulos Ragi Hotang.jpg',
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Ragi Idup',
                'description' => 'Ulos khusus untuk upacara kelahiran bayi',
                'price' => 420000,
                'original_price' => 550000,
                'tag' => 'Ragi Idup',
                'category' => 'Kelahiran',
                'image' => 'Ulos Ragi Hotang.jpg',
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Ulos Tumtuman',
                'description' => 'Ulos untuk pemberkatan bayi yang baru lahir',
                'price' => 380000,
                'original_price' => 480000,
                'tag' => 'Tumtuman',
                'category' => 'Kelahiran',
                'image' => 'Ulos Sibolang Rasta Pamontari.jpg',
                'stock' => 18,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            // Generate a unique slug for seeded products to support edit routes
            $product['slug'] = Str::slug($product['name']) . '-' . Str::random(6);
            Product::create($product);
        }
    }
}
