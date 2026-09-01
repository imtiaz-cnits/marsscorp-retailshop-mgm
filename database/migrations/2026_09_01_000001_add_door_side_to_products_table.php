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
        if (!Schema::hasColumn('products', 'door_side')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('door_side', 50)->nullable()->after('category_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'door_side')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('door_side');
            });
        }
    }
};
