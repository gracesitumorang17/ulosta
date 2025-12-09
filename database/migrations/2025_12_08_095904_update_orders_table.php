<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom baru ke tabel orders.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code')->unique()->after('id');
            }

            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('order_code');
            }

            if (!Schema::hasColumn('orders', 'seller_id')) {
                $table->foreignId('seller_id')->constrained('users')->onDelete('cascade')->after('user_id');
            }

            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 15, 2)->after('seller_id');
            }

            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', ['Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'])
                    ->default('Menunggu')
                    ->after('total_price');
            }
        });
    }

    /**
     * Kembalikan perubahan jika rollback.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_code')) $table->dropColumn('order_code');
            if (Schema::hasColumn('orders', 'user_id')) $table->dropForeign(['user_id']);
            if (Schema::hasColumn('orders', 'seller_id')) $table->dropForeign(['seller_id']);
            if (Schema::hasColumn('orders', 'user_id')) $table->dropColumn('user_id');
            if (Schema::hasColumn('orders', 'seller_id')) $table->dropColumn('seller_id');
            if (Schema::hasColumn('orders', 'total_price')) $table->dropColumn('total_price');
            if (Schema::hasColumn('orders', 'status')) $table->dropColumn('status');
        });
    }
};
