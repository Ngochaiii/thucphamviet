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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('province', 100);
            $table->string('city', 100)->nullable();
            $table->string('zone_name', 100);
            $table->decimal('base_fee', 10, 2)->default(0);
            $table->string('delivery_days', 50)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['province', 'city']);
            $table->index(['province']);
            $table->index(['zone_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
