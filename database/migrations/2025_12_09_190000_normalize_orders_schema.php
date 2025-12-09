<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_code') && !Schema::hasColumn('orders', 'order_number')) {
                $table->renameColumn('order_code', 'order_number');
            }
            if (Schema::hasColumn('orders', 'total_price') && !Schema::hasColumn('orders', 'total_amount')) {
                $table->renameColumn('total_price', 'total_amount');
            }
        });

        if (Schema::hasColumn('orders', 'status')) {
            DB::table('orders')->where('status', 'Menunggu')->update(['status' => 'pending']);
            DB::table('orders')->where('status', 'Diproses')->update(['status' => 'processing']);
            DB::table('orders')->where('status', 'Dikirim')->update(['status' => 'shipped']);
            DB::table('orders')->where('status', 'Selesai')->update(['status' => 'delivered']);
            DB::table('orders')->where('status', 'Dibatalkan')->update(['status' => 'cancelled']);
        }

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status', 30)->default('pending')->change();
            });
        } catch (\Throwable $e) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'status_tmp')) {
                    $table->string('status_tmp', 30)->default('pending')->nullable();
                }
            });
            DB::statement('UPDATE orders SET status_tmp = status');
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status', 30)->default('pending');
            });
            DB::statement('UPDATE orders SET status = status_tmp');
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('status_tmp');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_number') && !Schema::hasColumn('orders', 'order_code')) {
                $table->renameColumn('order_number', 'order_code');
            }
            if (Schema::hasColumn('orders', 'total_amount') && !Schema::hasColumn('orders', 'total_price')) {
                $table->renameColumn('total_amount', 'total_price');
            }
        });
    }
};
