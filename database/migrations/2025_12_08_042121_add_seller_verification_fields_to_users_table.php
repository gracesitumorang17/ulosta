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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->enum('verification_status', ['pending', 'approved', 'rejected'])->nullable()->after('role');
            }
            
            if (!Schema::hasColumn('users', 'ktp_number')) {
                $table->string('ktp_number', 16)->nullable()->after('verification_status');
            }
            
            if (!Schema::hasColumn('users', 'ktp_photo_path')) {
                $table->string('ktp_photo_path')->nullable()->after('ktp_number');
            }
            
            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable()->after('ktp_photo_path');
            }
            
            if (!Schema::hasColumn('users', 'store_address')) {
                $table->text('store_address')->nullable()->after('store_name');
            }
            
            if (!Schema::hasColumn('users', 'store_photo_path')) {
                $table->string('store_photo_path')->nullable()->after('store_address');
            }
            
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('store_photo_path');
            }
            
            if (!Schema::hasColumn('users', 'bank_account_number')) {
                $table->string('bank_account_number')->nullable()->after('bank_name');
            }
            
            if (!Schema::hasColumn('users', 'bank_account_name')) {
                $table->string('bank_account_name')->nullable()->after('bank_account_number');
            }
            
            if (!Schema::hasColumn('users', 'selfie_with_ktp_path')) {
                $table->string('selfie_with_ktp_path')->nullable()->after('bank_account_name');
            }
            
            if (!Schema::hasColumn('users', 'verification_submitted_at')) {
                $table->timestamp('verification_submitted_at')->nullable()->after('selfie_with_ktp_path');
            }
            
            if (!Schema::hasColumn('users', 'verification_approved_at')) {
                $table->timestamp('verification_approved_at')->nullable()->after('verification_submitted_at');
            }
            
            if (!Schema::hasColumn('users', 'verification_rejected_at')) {
                $table->timestamp('verification_rejected_at')->nullable()->after('verification_approved_at');
            }
            
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('verification_rejected_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'ktp_number',
                'ktp_photo_path',
                'store_name',
                'store_address', 
                'store_photo_path',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'selfie_with_ktp_path',
                'verification_submitted_at',
                'verification_approved_at',
                'verification_rejected_at',
                'rejection_reason'
            ]);
        });
    }
};
