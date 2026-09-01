<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchases_id');
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('transaction_id')->nullable();
            $table->date('purchase_due_collection_date')->nullable();
            $table->unsignedBigInteger('purchase_order_details_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('purchase_order_details_id')->references('id')->on('purchase_order_details')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('purchases_id')->references('id')->on('purchases')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('purchase_payment_details');
    }
};
