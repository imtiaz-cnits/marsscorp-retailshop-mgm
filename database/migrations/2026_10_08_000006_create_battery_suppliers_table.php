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
        Schema::create('battery_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_id');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('mobile');
            $table->string('address')->nullable();
            $table->string('img_url')->nullable();
            $table->decimal('purchase_payable_amount', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('battery_suppliers');
    }
};
