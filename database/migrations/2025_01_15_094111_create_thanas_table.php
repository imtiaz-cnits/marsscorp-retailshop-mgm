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
        Schema::create('thanas', function (Blueprint $table) {
            $table->id();
            $table->string('Thana_name');
            $table->string('status');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('upazila_id')->references('id')->on('upazilas')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('thanas');
    }
};
