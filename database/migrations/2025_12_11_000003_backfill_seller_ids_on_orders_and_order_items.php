<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Backfill order_items.seller_id from products.seller_id
        if (Schema::hasTable('order_items') && Schema::hasTable('products')) {
            // Update in chunks to avoid long transactions
            $items = DB::table('order_items')->whereNull('seller_id')->whereNotNull('product_id');
            // Use raw update join if DB supports it
            try {
                $driver = Schema::getConnection()->getDriverName();
                if (in_array($driver, ['mysql', 'pgsql'])) {
                    DB::statement('UPDATE order_items oi JOIN products p ON p.id = oi.product_id SET oi.seller_id = p.seller_id WHERE oi.seller_id IS NULL AND oi.product_id IS NOT NULL');
                } else {
                    // Fallback: PHP loop
                    DB::table('order_items')->whereNull('seller_id')->whereNotNull('product_id')->orderBy('id')->chunk(200, function ($rows) {
                        foreach ($rows as $r) {
                            $p = DB::table('products')->where('id', $r->product_id)->first();
                            if ($p && $p->seller_id) {
                                DB::table('order_items')->where('id', $r->id)->update(['seller_id' => $p->seller_id]);
                            }
                        }
                    });
                }
            } catch (\Throwable $e) {
                // Last-resort: PHP loop
                DB::table('order_items')->whereNull('seller_id')->whereNotNull('product_id')->orderBy('id')->chunk(200, function ($rows) {
                    foreach ($rows as $r) {
                        $p = DB::table('products')->where('id', $r->product_id)->first();
                        if ($p && $p->seller_id) {
                            DB::table('order_items')->where('id', $r->id)->update(['seller_id' => $p->seller_id]);
                        }
                    }
                });
            }
        }

        // Backfill orders.seller_id from order_items -> product.seller_id (first found)
        if (Schema::hasTable('orders') && Schema::hasTable('order_items')) {
            // For DBs supporting subqueries in update
            try {
                $driver = Schema::getConnection()->getDriverName();
                if (in_array($driver, ['mysql', 'pgsql'])) {
                    // MySQL: update orders set seller_id = (select p.seller_id from order_items oi join products p on p.id=oi.product_id where oi.order_id = orders.id and p.seller_id is not null limit 1) where seller_id is null
                    if ($driver === 'mysql') {
                        DB::statement("UPDATE orders o SET seller_id = (SELECT p.seller_id FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = o.id AND p.seller_id IS NOT NULL LIMIT 1) WHERE o.seller_id IS NULL");
                    } else {
                        // Postgres uses distinct syntax
                        DB::statement("UPDATE orders SET seller_id = sub.seller_id FROM (SELECT oi.order_id, p.seller_id FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE p.seller_id IS NOT NULL) AS sub WHERE orders.id = sub.order_id AND orders.seller_id IS NULL");
                    }
                } else {
                    // PHP loop fallback
                    DB::table('orders')->whereNull('seller_id')->orderBy('id')->chunk(200, function ($orders) {
                        foreach ($orders as $o) {
                            $row = DB::table('order_items')->where('order_id', $o->id)->whereNotNull('product_id')->first();
                            if ($row) {
                                $p = DB::table('products')->where('id', $row->product_id)->first();
                                if ($p && $p->seller_id) {
                                    DB::table('orders')->where('id', $o->id)->update(['seller_id' => $p->seller_id]);
                                }
                            }
                        }
                    });
                }
            } catch (\Throwable $e) {
                // PHP fallback
                DB::table('orders')->whereNull('seller_id')->orderBy('id')->chunk(200, function ($orders) {
                    foreach ($orders as $o) {
                        $row = DB::table('order_items')->where('order_id', $o->id)->whereNotNull('product_id')->first();
                        if ($row) {
                            $p = DB::table('products')->where('id', $row->product_id)->first();
                            if ($p && $p->seller_id) {
                                DB::table('orders')->where('id', $o->id)->update(['seller_id' => $p->seller_id]);
                            }
                        }
                    }
                });
            }
        }
    }

    public function down()
    {
        // no-op: we don't revert data backfills
    }
};
