<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Relasi ke order dan produk
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null')->after('order_id');
            }

            // Kolom produk dan perhitungan
            if (!Schema::hasColumn('order_items', 'product_name')) $table->string('product_name')->after('product_id');
            if (!Schema::hasColumn('order_items', 'product_sku')) $table->string('product_sku')->nullable()->after('product_name');
            if (!Schema::hasColumn('order_items', 'product_image')) $table->string('product_image')->nullable()->after('product_sku');
            if (!Schema::hasColumn('order_items', 'quantity')) $table->integer('quantity')->default(1)->after('product_image');
            if (!Schema::hasColumn('order_items', 'price')) $table->decimal('price', 15, 2)->default(0)->after('quantity');
            if (!Schema::hasColumn('order_items', 'total')) $table->decimal('total', 15, 2)->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
        });
    }
};
