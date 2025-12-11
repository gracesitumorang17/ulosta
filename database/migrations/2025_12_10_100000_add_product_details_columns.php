<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'material')) {
                $table->string('material')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'size')) {
                $table->string('size')->nullable()->after('material');
            }
            if (!Schema::hasColumn('products', 'weight')) {
                $table->integer('weight')->nullable()->after('size');
            }
            if (!Schema::hasColumn('products', 'origin')) {
                $table->string('origin')->nullable()->after('weight');
            }
            // Clarify semantic usage: 'tag' as jenis, 'category' as fungsi already exist
            // Ensure columns exist
            if (!Schema::hasColumn('products', 'tag')) {
                $table->string('tag')->nullable()->after('original_price');
            }
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('tag');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'material')) {
                $table->dropColumn('material');
            }
            if (Schema::hasColumn('products', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('products', 'weight')) {
                $table->dropColumn('weight');
            }
            if (Schema::hasColumn('products', 'origin')) {
                $table->dropColumn('origin');
            }
        });
    }
};
