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
        Schema::create('order_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('transaction_id', 50)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('due_collection_date')->nullable();
            $table->string('payment_status', 50)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('order_id')->references('id')->on('orders')
            ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')
            ->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_details');
    }
};
