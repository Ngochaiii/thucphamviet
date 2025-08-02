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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Primary key auto increment

            // User identification - support cả logged user và guest
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID user đã login, NULL nếu guest');
            $table->string('session_id', 255)->nullable()->comment('Session ID cho guest user');

            // Không cần section info vì chưa có bảng sections

            // Cart totals
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Tổng tiền trước thuế');
            $table->integer('total_item')->default(0)->comment('Tổng số lượng sản phẩm');

            // Cart status
            $table->enum('status', ['active', 'abandoned', 'completed'])
                  ->default('active')
                  ->comment('Trạng thái giỏ hàng');

            // Timestamps
            $table->timestamps();

            // Indexes để tối ưu performance
            $table->index('user_id', 'idx_user_id');
            $table->index('session_id', 'idx_session_id');
            $table->index('status', 'idx_status');
            $table->index('created_at', 'idx_created_at');

            // Foreign key constraints (nếu có bảng users)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
