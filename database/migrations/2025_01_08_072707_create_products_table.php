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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('img_url')->nullable();
            $table->string('product_name');
            $table->string('quantity')->nullable();
            $table->string('cost_price');
            $table->string('sell_price');
            $table->string('status');
            $table->json('product_code');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('products');
    }
};
