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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('package_id')->nullable()->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->foreignId('activation_code_id')->nullable()->constrained();
            $table->dateTime('started_at');
            $table->dateTime('expires_at');
            $table->string('payment_method');
            $table->integer('gross_amount');
            $table->integer('discount_amount')->default(0);
            $table->integer('net_amount');
            $table->integer('tax')->default(0);
            $table->integer('price');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
