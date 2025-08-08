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
            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('shipping_rate_id')->nullable()->constrained('shipping_rates');

            // Customer info
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone', 20)->nullable();

            // Delivery info
            $table->string('delivery_province', 100);
            $table->string('delivery_city', 100)->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_time_frame', 50)->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->string('shipping_zone_name', 100)->nullable();
            $table->decimal('processing_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Status
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipping', 'delivered', 'cancelled'])
                  ->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                  ->default('pending');
            $table->boolean('is_guest_order')->default(false);

            // Notes
            $table->text('order_notes')->nullable();
            $table->text('admin_notes')->nullable();

            // Timestamps
            $table->datetime('order_date')->default(now());
            $table->datetime('confirmed_at')->nullable();
            $table->datetime('shipped_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['order_number']);
            $table->index(['user_id']);
            $table->index(['payment_method_id']);
            $table->index(['status']);
            $table->index(['payment_status']);
            $table->index(['is_guest_order']);
            $table->index(['order_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
