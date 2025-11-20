<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->string('tag')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price'); // store in smallest currency unit if needed
            $table->unsignedBigInteger('original_price')->nullable();
            $table->timestamps();
            $table->unique(['user_id','product_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
