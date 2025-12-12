<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class DemoOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Find a demo product created earlier
        $product = Product::where('name', 'like', '%Ulos Demo%')->first();
        if (!$product) {
            $this->command?->error('Demo product not found. Run create_demo_product or ProductSellerSeeder first.');
            return;
        }

        // Find or create a demo buyer
        $buyer = User::where('email', 'buyer@example.test')->first();
        if (!$buyer) {
            $buyer = User::create([
                'name' => 'Demo Buyer',
                'email' => 'buyer@example.test',
                'password' => bcrypt('password'),
            ]);
        }

        // Create an order for that buyer and seller
        $order = Order::create([
            'user_id' => $buyer->id,
            'seller_id' => $product->seller_id,
            'order_number' => date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $product->price,
            'shipping_cost' => 15000,
            'total_amount' => $product->price + 15000,
            'total_price' => $product->price + 15000,
            'shipping_first_name' => 'Demo Buyer',
            'shipping_phone' => '081234567890',
            'shipping_address_1' => 'Alamat Demo',
            'shipping_city' => 'Medan',
            'shipping_postal_code' => '20111',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_image' => $product->image,
            'quantity' => 1,
            'price' => $product->price,
            'subtotal' => $product->price,
            'total' => $product->price,
        ]);

        $this->command?->info('Created demo order id=' . $order->id . ' for product id=' . $product->id);
    }
}
