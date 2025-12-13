<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Skip: order_code is still needed in the system
        // SQLite doesn't support dropping columns with indexes easily
        // Keep order_code column for now
    }

    public function down(): void
    {
        // No action needed
    }
};
