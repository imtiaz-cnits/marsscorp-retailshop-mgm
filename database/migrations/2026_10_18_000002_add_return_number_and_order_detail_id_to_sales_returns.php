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
        // 1. Retail Sales Returns
        if (Schema::hasTable('product_returns')) {
            Schema::table('product_returns', function (Blueprint $table) {
                if (!Schema::hasColumn('product_returns', 'return_number')) {
                    $table->string('return_number', 50)->nullable()->index()->after('id');
                }
                if (!Schema::hasColumn('product_returns', 'order_detail_id')) {
                    $table->unsignedBigInteger('order_detail_id')->nullable()->index()->after('order_id');
                }
                if (!Schema::hasColumn('product_returns', 'unit_price')) {
                    $table->decimal('unit_price', 12, 2)->default(0)->after('quantity');
                }
            });
        }

        // 2. Battery Sales Returns
        if (Schema::hasTable('battery_product_returns')) {
            Schema::table('battery_product_returns', function (Blueprint $table) {
                if (!Schema::hasColumn('battery_product_returns', 'return_number')) {
                    $table->string('return_number', 50)->nullable()->index()->after('id');
                }
                if (!Schema::hasColumn('battery_product_returns', 'order_detail_id')) {
                    $table->unsignedBigInteger('order_detail_id')->nullable()->index()->after('order_id');
                }
                if (!Schema::hasColumn('battery_product_returns', 'unit_price')) {
                    $table->decimal('unit_price', 12, 2)->default(0)->after('quantity');
                }
            });
        }

        // 3. Retail Purchase Returns
        if (Schema::hasTable('purchase_returns')) {
            Schema::table('purchase_returns', function (Blueprint $table) {
                if (!Schema::hasColumn('purchase_returns', 'return_number')) {
                    $table->string('return_number', 50)->nullable()->index()->after('id');
                }
                if (!Schema::hasColumn('purchase_returns', 'purchase_order_detail_id')) {
                    $table->unsignedBigInteger('purchase_order_detail_id')->nullable()->index()->after('purchase_id');
                }
                if (!Schema::hasColumn('purchase_returns', 'unit_price')) {
                    $table->decimal('unit_price', 12, 2)->default(0)->after('quantity');
                }
            });
        }

        // 4. Battery Purchase Returns
        if (Schema::hasTable('battery_purchase_returns')) {
            Schema::table('battery_purchase_returns', function (Blueprint $table) {
                if (!Schema::hasColumn('battery_purchase_returns', 'return_number')) {
                    $table->string('return_number', 50)->nullable()->index()->after('id');
                }
                if (!Schema::hasColumn('battery_purchase_returns', 'purchase_order_detail_id')) {
                    $table->unsignedBigInteger('purchase_order_detail_id')->nullable()->index()->after('purchase_id');
                }
                if (!Schema::hasColumn('battery_purchase_returns', 'unit_price')) {
                    $table->decimal('unit_price', 12, 2)->default(0)->after('quantity');
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
                $cols = [];
                if (Schema::hasColumn('product_returns', 'return_number')) $cols[] = 'return_number';
                if (Schema::hasColumn('product_returns', 'order_detail_id')) $cols[] = 'order_detail_id';
                if (Schema::hasColumn('product_returns', 'unit_price')) $cols[] = 'unit_price';
                if (!empty($cols)) $table->dropColumn($cols);
            });
        }

        if (Schema::hasTable('battery_product_returns')) {
            Schema::table('battery_product_returns', function (Blueprint $table) {
                $cols = [];
                if (Schema::hasColumn('battery_product_returns', 'return_number')) $cols[] = 'return_number';
                if (Schema::hasColumn('battery_product_returns', 'order_detail_id')) $cols[] = 'order_detail_id';
                if (Schema::hasColumn('battery_product_returns', 'unit_price')) $cols[] = 'unit_price';
                if (!empty($cols)) $table->dropColumn($cols);
            });
        }

        if (Schema::hasTable('purchase_returns')) {
            Schema::table('purchase_returns', function (Blueprint $table) {
                $cols = [];
                if (Schema::hasColumn('purchase_returns', 'return_number')) $cols[] = 'return_number';
                if (Schema::hasColumn('purchase_returns', 'purchase_order_detail_id')) $cols[] = 'purchase_order_detail_id';
                if (Schema::hasColumn('purchase_returns', 'unit_price')) $cols[] = 'unit_price';
                if (!empty($cols)) $table->dropColumn($cols);
            });
        }

        if (Schema::hasTable('battery_purchase_returns')) {
            Schema::table('battery_purchase_returns', function (Blueprint $table) {
                $cols = [];
                if (Schema::hasColumn('battery_purchase_returns', 'return_number')) $cols[] = 'return_number';
                if (Schema::hasColumn('battery_purchase_returns', 'purchase_order_detail_id')) $cols[] = 'purchase_order_detail_id';
                if (Schema::hasColumn('battery_purchase_returns', 'unit_price')) $cols[] = 'unit_price';
                if (!empty($cols)) $table->dropColumn($cols);
            });
        }
    }
};
