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
        Schema::create('supplier_due_collections', function (Blueprint $table) {
            $table->id();
            $table->string('paid_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('purchase_payable_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->date('due_collection_date')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('supplier_due_collections');
    }
};
