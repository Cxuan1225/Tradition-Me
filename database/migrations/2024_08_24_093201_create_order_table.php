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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->index('user_id_idx');
            $table->foreignId('user_address_id')->constrained('user_addresses')->onDelete('cascade')->index('user_address_id_idx');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['pending', 'complete', 'shipping', 'delivered', 'cancel', 'refunded'])->default('pending');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->index('order_id_idx');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->index('product_id_idx');
            $table->string('color');
            $table->string('size');
            $table->integer('quantity')->default(1);
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('user_cards');
    }
};
