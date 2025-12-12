<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'seller_id')) {
                $table->unsignedBigInteger('seller_id')->nullable()->after('user_id')->index();
                $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'seller_id')) {
                // drop foreign first for SQLite compatibility
                try {
                    $table->dropForeign(['seller_id']);
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->dropColumn('seller_id');
            }
        });
    }
};
