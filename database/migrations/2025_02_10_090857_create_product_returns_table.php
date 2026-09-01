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
        Schema::create('product_returns', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('discount_amount');
            $table->string('due_amount');
            $table->string('date');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('product_returns');
    }
};
