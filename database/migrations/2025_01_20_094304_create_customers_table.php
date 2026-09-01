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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('address_details')->nullable();
            $table->string('date')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('img_url')->nullable();
            $table->string('nid')->nullable();
            $table->string('previous_due_amount')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('upazila_id')->nullable();
            $table->unsignedBigInteger('thana_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('upazila_id')->references('id')->on('upazilas')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('thana_id')->references('id')->on('thanas')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('customers');
    }
};
