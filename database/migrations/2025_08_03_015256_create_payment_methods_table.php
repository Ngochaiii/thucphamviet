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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('type', ['cod', 'bank_transfer', 'credit_card', 'momo', 'zalopay', 'paypal']);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('card_number_masked', 20)->nullable();
            $table->string('card_holder_name')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('processing_fee', 5, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['user_id']);
            $table->index(['type']);
            $table->index(['is_active']);
            $table->index(['sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
