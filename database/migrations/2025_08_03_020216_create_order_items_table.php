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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            // Product snapshot (lưu thông tin tại thời điểm order)
            $table->string('product_name');
            $table->string('product_jp_name')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('product_image', 500)->nullable();

            // Pricing và quantity
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('line_total', 10, 2);

            // Product metadata snapshot
            $table->decimal('product_weight', 8, 2)->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_unit', 50)->nullable();
            $table->string('product_unit_display', 100)->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['order_id']);
            $table->index(['product_id']);
            $table->unique(['order_id', 'product_id']); // Tránh duplicate trong cùng order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
