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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Primary key auto increment

            // Foreign keys
            $table->unsignedBigInteger('cart_id')->comment('ID giỏ hàng');
            $table->unsignedBigInteger('product_id')->comment('ID sản phẩm');

            // Item details
            $table->integer('quantity')->default(1)->comment('Số lượng sản phẩm');
            $table->decimal('unit_price', 10, 2)->comment('Giá đơn vị tại thời điểm add');
            $table->decimal('line_total', 10, 2)->comment('Tổng tiền dòng = quantity * unit_price');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['cart_id', 'product_id'], 'idx_cart_product');
            $table->index('cart_id', 'idx_cart_id');
            $table->index('product_id', 'idx_product_id');

            // Unique constraint - 1 sản phẩm chỉ xuất hiện 1 lần trong 1 cart
            $table->unique(['cart_id', 'product_id'], 'unique_cart_product');

            // Foreign key constraints
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
