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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_type_id');
            $table->decimal('expense_amount', 10, 2);
            $table->longText('expense_details')->nullable();
            $table->string('date');
            $table->unsignedBigInteger('user_id');
            $table->foreign('expense_type_id')->references('id')->on('expense_types')
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
        Schema::dropIfExists('expenses');
    }
};
