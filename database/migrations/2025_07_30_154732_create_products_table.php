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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('name');
            $table->string('jp_name')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('specification')->nullable()->comment('thông số kỹ thuật');
            $table->string('currency', 3)->default('JPY');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->decimal('discount', 5, 2)->default(0)->comment('% giảm giá');
            $table->string('image')->nullable();
            $table->json('images')->nullable()->comment('Danh sách ảnh bổ sung');
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            // Indexes
            $table->index(['slug', 'status']);
            $table->index(['category_id', 'status']);
            $table->index(['is_featured', 'status']);
            $table->index('rating_avg');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
