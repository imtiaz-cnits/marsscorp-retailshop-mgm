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
        Schema::create('opening_balances', function (Blueprint $table) {
           $table->id();
            $table->decimal('amount', 15, 2)->default(0); 
            $table->date('date'); 
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['date', 'user_id']); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_balances');
    }
};
