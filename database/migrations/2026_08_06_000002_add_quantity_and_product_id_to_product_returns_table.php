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
        if (Schema::hasTable('product_returns')) {
            Schema::table('product_returns', function (Blueprint $table) {
                if (!Schema::hasColumn('product_returns', 'quantity')) {
                    $table->integer('quantity')->default(1)->after('due_amount');
                }
                if (!Schema::hasColumn('product_returns', 'product_id')) {
                    $table->unsignedBigInteger('product_id')->nullable()->after('order_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_returns')) {
            Schema::table('product_returns', function (Blueprint $table) {
                if (Schema::hasColumn('product_returns', 'quantity')) {
                    $table->dropColumn('quantity');
                }
                if (Schema::hasColumn('product_returns', 'product_id')) {
                    $table->dropColumn('product_id');
                }
            });
        }
    }
};
