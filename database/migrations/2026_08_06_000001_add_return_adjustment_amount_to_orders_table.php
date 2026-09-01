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
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'return_adjustment_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('return_adjustment_amount', 10, 2)->default(0)->after('sub_total');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'return_adjustment_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('return_adjustment_amount');
            });
        }
    }
};
