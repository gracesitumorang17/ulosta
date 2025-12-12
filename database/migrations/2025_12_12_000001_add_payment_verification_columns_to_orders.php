<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_verified_by')) {
                $table->unsignedBigInteger('payment_verified_by')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_verified_by');
            }
            if (!Schema::hasColumn('orders', 'payment_proof_url')) {
                $table->string('payment_proof_url')->nullable()->after('payment_verified_at');
            }
            if (!Schema::hasColumn('orders', 'payment_proof_note')) {
                $table->text('payment_proof_note')->nullable()->after('payment_proof_url');
            }
            if (!Schema::hasColumn('orders', 'payment_proof_submitted_at')) {
                $table->timestamp('payment_proof_submitted_at')->nullable()->after('payment_proof_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach ([
                'payment_verified_by',
                'payment_verified_at',
                'payment_proof_url',
                'payment_proof_note',
                'payment_proof_submitted_at',
            ] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
