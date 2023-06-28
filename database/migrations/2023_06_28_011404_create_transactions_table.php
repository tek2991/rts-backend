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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained();
            $table->string('payment_method');
            $table->integer('amount');
            $table->string('status');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('package_id')->nullable()->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->foreignId('activation_code_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
