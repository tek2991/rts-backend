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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('gateway')->nullable()->default('instamojo');
            $table->string('phonepe_order_id')->nullable();
            $table->text('phonepe_longurl')->nullable();
            $table->string('phonepe_merchant_transaction_id')->nullable();
            $table->string('phonepe_transaction_id')->nullable();
            $table->string('phonepe_payment_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('gateway');
            $table->dropColumn('phonepe_order_id');
            $table->dropColumn('phonepe_longurl');
            $table->dropColumn('phonepe_merchant_transaction_id');
            $table->dropColumn('phonepe_transaction_id');
            $table->dropColumn('phonepe_payment_type');
        });
    }
};
