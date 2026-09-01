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
        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases', 'return_adjustment_amount')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->decimal('return_adjustment_amount', 10, 2)->default(0)->after('grand_subtotal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases', 'return_adjustment_amount')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('return_adjustment_amount');
            });
        }
    }
};
