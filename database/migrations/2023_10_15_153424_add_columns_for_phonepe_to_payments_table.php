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
            // Change long_url to text
            $table->text('longurl')->nullable()->change();
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
            // Change long_url back to string
            $table->string('longurl')->nullable()->change();
        });
    }
};
