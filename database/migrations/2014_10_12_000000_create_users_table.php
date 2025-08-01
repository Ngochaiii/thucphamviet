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
       Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->integer('role')->default(0)->comment('0=customer, 1=admin');
            $table->boolean('is_active')->default(true);
            $table->string('last_name');
            $table->string('first_name');
            $table->string('display_name');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Indexes
            $table->index(['email']);
            $table->index(['is_active']);
            $table->index(['role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
