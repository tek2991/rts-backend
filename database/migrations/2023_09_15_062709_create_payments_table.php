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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->nullable();
            $table->string('payment_request_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('currency')->nullable()->default('INR');
            $table->integer('amount_in_cents')->nullable();
            $table->integer('fees_in_cents')->nullable();
            $table->integer('taxes_in_cents')->nullable();
            $table->string('instrument_type')->nullable();
            $table->string('billing_instrument')->nullable();
            $table->string('failure_reason')->nullable();
            $table->string('failure_message')->nullable();
            $table->string('bank_reference_number')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->string('purpose')->nullable();
            $table->string('shorturl')->nullable();
            $table->string('longurl')->nullable();
            $table->string('mac')->nullable();
            $table->boolean('redirected')->default(false);
            $table->boolean('webhook_verified')->default(false);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Add payment_id to subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained('payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove payment_id from subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
        });

        Schema::dropIfExists('payments');
    }
};
