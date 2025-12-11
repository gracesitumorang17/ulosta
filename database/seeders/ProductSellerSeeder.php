<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSellerSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role seller
        $sellers = User::where('role', 'seller')->orderBy('id')->get(['id']);
        if ($sellers->isEmpty()) {
            $this->command?->warn('Tidak ada user dengan role seller. Lewati pengisian products.seller_id.');
            return;
        }

        $sellerIds = $sellers->pluck('id')->values();
        $count = $sellerIds->count();

        // Assign seller secara merata ke seluruh produk
        Product::orderBy('id')->chunk(200, function ($products) use ($sellerIds, $count) {
            foreach ($products as $index => $product) {
                $assignedSellerId = $sellerIds[$index % $count];
                // Hanya update jika belum terisi
                if (!$product->seller_id) {
                    $product->seller_id = $assignedSellerId;
                    $product->save();
                }
            }
        });

        $this->command?->info('Pengisian products.seller_id selesai.');
    }
}
