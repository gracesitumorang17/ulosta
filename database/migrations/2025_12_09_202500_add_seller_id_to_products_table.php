<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'seller_id')) {
                // Add the column as nullable first to avoid FK violations on existing rows
                $table->unsignedBigInteger('seller_id')->nullable()->after('id');
                $table->index('seller_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'seller_id')) {
                // In case a FK was added later, drop it first; ignore if absent
                try {
                    $table->dropForeign(['seller_id']);
                } catch (\Throwable $e) {
                }
                $table->dropIndex(['seller_id']);
                $table->dropColumn('seller_id');
            }
        });
    }
};
