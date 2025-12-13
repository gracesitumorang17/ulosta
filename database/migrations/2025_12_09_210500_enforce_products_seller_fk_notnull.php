<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Skip for SQLite - column already exists with proper constraints
        // This migration was designed for MySQL but SQLite handles it differently
        if (config('database.default') === 'sqlite') {
            return;
        }

        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'seller_id')) {
            return;
        }

        // Pastikan tidak ada produk tanpa seller_id
        $nullCount = DB::table('products')->whereNull('seller_id')->count();
        if ($nullCount > 0) {
            throw new \RuntimeException('Masih ada ' . $nullCount . ' produk tanpa seller_id. Jalankan ProductSellerSeeder lalu ulangi migrate.');
        }

        // MySQL specific operations
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable(false)->change();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'seller_id')) {
            return;
        }
        // Lepas constraint terlebih dahulu (cek via information_schema)
        $fk = DB::selectOne(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE " .
                "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' " .
                "AND COLUMN_NAME = 'seller_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1"
        );
        if ($fk && isset($fk->CONSTRAINT_NAME)) {
            $constraint = str_replace('`', '', $fk->CONSTRAINT_NAME);
            DB::statement("ALTER TABLE `products` DROP FOREIGN KEY `{$constraint}`");
        }
        // Kembalikan menjadi nullable agar aman rollback
        DB::statement('ALTER TABLE products MODIFY seller_id BIGINT UNSIGNED NULL');
    }
};
