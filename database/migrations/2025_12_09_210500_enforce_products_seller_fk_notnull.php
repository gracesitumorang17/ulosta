<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'seller_id')) {
            return; // nothing to enforce
        }

        // Pastikan tidak ada produk tanpa seller_id
        $nullCount = DB::table('products')->whereNull('seller_id')->count();
        if ($nullCount > 0) {
            throw new \RuntimeException('Masih ada ' . $nullCount . ' produk tanpa seller_id. Jalankan ProductSellerSeeder lalu ulangi migrate.');
        }

        // Lepas FK lama jika ada untuk menghindari konflik (cek via information_schema)
        $fk = DB::selectOne(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE " .
                "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' " .
                "AND COLUMN_NAME = 'seller_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1"
        );
        if ($fk && isset($fk->CONSTRAINT_NAME)) {
            $constraint = str_replace('`', '', $fk->CONSTRAINT_NAME);
            DB::statement("ALTER TABLE `products` DROP FOREIGN KEY `{$constraint}`");
        }

        // Buat kolom sementara, salin data, jadikan NOT NULL, lalu ganti
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'seller_id_tmp')) {
                $table->unsignedBigInteger('seller_id_tmp')->nullable()->after('id');
            }
        });
        DB::statement('UPDATE products SET seller_id_tmp = seller_id');
        DB::statement('ALTER TABLE products MODIFY seller_id_tmp BIGINT UNSIGNED NOT NULL');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });
        DB::statement('ALTER TABLE products CHANGE seller_id_tmp seller_id BIGINT UNSIGNED NOT NULL');

        // Tambah index dan FK
        Schema::table('products', function (Blueprint $table) {
            $table->index('seller_id');
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
