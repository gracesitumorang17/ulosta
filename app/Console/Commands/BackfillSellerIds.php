<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackfillSellerIds extends Command
{
    protected $signature = 'ulosta:backfill-seller-ids {--dry-run : Tampilkan rencana perubahan tanpa menyimpan}';
    protected $description = 'Mengisi nilai seller_id yang hilang pada products dan cart_items.';

    public function handle()
    {
        $dry = $this->option('dry-run');

        $productsFixed = 0;
        $cartFixed = 0;

        // Backfill products: jika ada produk tanpa seller_id tetapi memiliki relasi penjual default, lewati (tidak ada info), hanya hitung.
        $productsMissing = \App\Models\Product::whereNull('seller_id')->count();

        // Backfill cart_items: isi seller_id dari product terkait jika tersedia
        $carts = \App\Models\CartItem::whereNull('seller_id')->whereNotNull('product_id')->get();
        foreach ($carts as $ci) {
            $prod = \App\Models\Product::find($ci->product_id);
            if ($prod && $prod->seller_id) {
                if (!$dry) {
                    $ci->seller_id = $prod->seller_id;
                    $ci->save();
                }
                $cartFixed++;
            }
        }

        $this->info("Produk tanpa seller_id: {$productsMissing} (tidak diubah karena tidak ada sumber data).");
        $this->info("cart_items diperbaiki: {$cartFixed}");

        if ($dry) {
            $this->warn('Dry-run: tidak ada perubahan yang disimpan.');
        } else {
            $this->info('Backfill selesai.');
        }

        return 0;
    }
}
