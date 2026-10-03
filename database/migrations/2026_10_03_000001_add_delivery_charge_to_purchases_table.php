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
        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases', 'delivery_charge')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->decimal('delivery_charge', 10, 2)->default(0)->nullable()->after('grand_subtotal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases', 'delivery_charge')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('delivery_charge');
            });
        }
    }
};
