<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // Informasi pesanan umum
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('payment_method');
            }

            // Perhitungan harga
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 15, 2)->default(0)->after('shipping_method');
            }
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 15, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'tax_amount')) {
                $table->decimal('tax_amount', 15, 2)->default(0)->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 15, 2)->default(0)->after('tax_amount');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->default(0)->after('discount_amount');
            }
            if (!Schema::hasColumn('orders', 'currency')) {
                $table->string('currency', 10)->default('IDR')->after('total_amount');
            }

            // Catatan & waktu
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }

            // Billing Address
            $billingColumns = [
                'billing_first_name',
                'billing_last_name',
                'billing_email',
                'billing_phone',
                'billing_address_1',
                'billing_address_2',
                'billing_city',
                'billing_state',
                'billing_postal_code',
                'billing_country'
            ];
            foreach ($billingColumns as $column) {
                if (!Schema::hasColumn('orders', $column)) {
                    $table->string($column)->nullable();
                }
            }

            // Shipping Address
            $shippingColumns = [
                'shipping_first_name',
                'shipping_last_name',
                'shipping_email',
                'shipping_phone',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_city',
                'shipping_state',
                'shipping_postal_code',
                'shipping_country'
            ];
            foreach ($shippingColumns as $column) {
                if (!Schema::hasColumn('orders', $column)) {
                    $table->string($column)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'order_number',
                'payment_status',
                'payment_method',
                'shipping_method',
                'subtotal',
                'shipping_cost',
                'tax_amount',
                'discount_amount',
                'total_amount',
                'currency',
                'notes',
                'shipped_at',
                'delivered_at',
                'billing_first_name',
                'billing_last_name',
                'billing_email',
                'billing_phone',
                'billing_address_1',
                'billing_address_2',
                'billing_city',
                'billing_state',
                'billing_postal_code',
                'billing_country',
                'shipping_first_name',
                'shipping_last_name',
                'shipping_email',
                'shipping_phone',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_city',
                'shipping_state',
                'shipping_postal_code',
                'shipping_country',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
