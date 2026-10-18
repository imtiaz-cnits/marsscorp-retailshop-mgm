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
        // 1. purchases table
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('purchases', 'discount_type')) {
                    $table->string('discount_type', 20)->default('fixed')->nullable()->after('discount_amount');
                }
                if (!Schema::hasColumn('purchases', 'discount_rate')) {
                    $table->decimal('discount_rate', 10, 2)->nullable()->default(null)->after('discount_type');
                }
            });
        }

        // 2. battery_purchases table
        if (Schema::hasTable('battery_purchases')) {
            Schema::table('battery_purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('battery_purchases', 'discount_type')) {
                    $table->string('discount_type', 20)->default('fixed')->nullable()->after('discount_amount');
                }
                if (!Schema::hasColumn('battery_purchases', 'discount_rate')) {
                    $table->decimal('discount_rate', 10, 2)->nullable()->default(null)->after('discount_type');
                }
            });
        }

        // 3. orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'discount_type')) {
                    $table->string('discount_type', 20)->default('fixed')->nullable()->after('discount_amount');
                }
                if (!Schema::hasColumn('orders', 'discount_rate')) {
                    $table->decimal('discount_rate', 10, 2)->nullable()->default(null)->after('discount_type');
                }
            });
        }

        // 4. battery_orders table
        if (Schema::hasTable('battery_orders')) {
            Schema::table('battery_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('battery_orders', 'discount_type')) {
                    $table->string('discount_type', 20)->default('fixed')->nullable()->after('discount_amount');
                }
                if (!Schema::hasColumn('battery_orders', 'discount_rate')) {
                    $table->decimal('discount_rate', 10, 2)->nullable()->default(null)->after('discount_type');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                if (Schema::hasColumn('purchases', 'discount_rate')) {
                    $table->dropColumn('discount_rate');
                }
                if (Schema::hasColumn('purchases', 'discount_type')) {
                    $table->dropColumn('discount_type');
                }
            });
        }

        if (Schema::hasTable('battery_purchases')) {
            Schema::table('battery_purchases', function (Blueprint $table) {
                if (Schema::hasColumn('battery_purchases', 'discount_rate')) {
                    $table->dropColumn('discount_rate');
                }
                if (Schema::hasColumn('battery_purchases', 'discount_type')) {
                    $table->dropColumn('discount_type');
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'discount_rate')) {
                    $table->dropColumn('discount_rate');
                }
                if (Schema::hasColumn('orders', 'discount_type')) {
                    $table->dropColumn('discount_type');
                }
            });
        }

        if (Schema::hasTable('battery_orders')) {
            Schema::table('battery_orders', function (Blueprint $table) {
                if (Schema::hasColumn('battery_orders', 'discount_rate')) {
                    $table->dropColumn('discount_rate');
                }
                if (Schema::hasColumn('battery_orders', 'discount_type')) {
                    $table->dropColumn('discount_type');
                }
            });
        }
    }
};
