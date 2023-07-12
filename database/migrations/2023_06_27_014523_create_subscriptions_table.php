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
            $table->integer('package_name')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->string('coupon_code')->nullable();
            $table->string('coupon_promoter_name')->nullable();
            $table->foreignId('activation_code_id')->nullable()->constrained();
            $table->string('activation_code')->nullable();
            
            $table->integer('plan_net_amount');
            $table->integer('plan_tax')->default(0);

            $table->dateTime('started_at');
            $table->dateTime('expires_at');
            $table->integer('duration_in_days');
            $table->integer('gross_price');
            $table->integer('discount_amount')->default(0);
            $table->integer('net_amount');
            $table->integer('tax')->default(0);
            $table->integer('price');
            
            $table->string('payment_method');
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
