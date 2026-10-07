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
        Schema::create('battery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('due_amount', 15, 2)->nullable();
            $table->decimal('previous_due_amount', 15, 2)->nullable();
            $table->decimal('return_adjustment_amount', 10, 2)->default(0);
            $table->longText('order_note')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('customer_id')->references('id')->on('battery_customers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_orders');
    }
};
