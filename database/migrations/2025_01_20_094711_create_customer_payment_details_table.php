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
        Schema::create('customer_payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('paid_amount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('previous_due_amount')->nullable();
            $table->date('due_collection_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('customer_payment_details');
    }
};
