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
        if (!Schema::hasTable('stock_repair_executions')) {
            Schema::create('stock_repair_executions', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_unicode_ci';

                $table->id();
                $table->string('repair_key', 100)->unique('uq_stock_repair_executions_key');
                $table->string('repair_reference', 120)->unique('uq_stock_repair_executions_reference');
                $table->string('authorized_approver', 150);
                $table->date('verification_date');
                $table->string('forms_reference', 255);
                $table->char('manifest_sha256', 64);
                $table->string('target_db', 100);
                $table->string('target_host', 150);
                $table->unsignedInteger('target_port');
                $table->integer('pre_sum_9');
                $table->integer('post_sum_9');
                $table->integer('pre_sum_34');
                $table->integer('post_sum_34');
                $table->json('updated_rows_json');
                $table->timestamp('executed_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_repair_executions');
    }
};
