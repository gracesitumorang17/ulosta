<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'jenis')) {
                $table->string('jenis')->nullable()->after('tag');
            }
            if (!Schema::hasColumn('products', 'fungsi')) {
                $table->string('fungsi')->nullable()->after('jenis');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'jenis')) {
                $table->dropColumn('jenis');
            }
            if (Schema::hasColumn('products', 'fungsi')) {
                $table->dropColumn('fungsi');
            }
        });
    }
};
