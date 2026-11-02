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
        if (!Schema::hasTable('battery_migration_mappings')) {
            Schema::create('battery_migration_mappings', function (Blueprint $table) {
                $table->id();
                $table->string('migration_batch_id', 64)->index();
                $table->string('source_module', 32)->default('retail');
                $table->string('source_table', 64);
                $table->unsignedBigInteger('source_id');
                $table->string('destination_table', 64);
                $table->unsignedBigInteger('destination_id');
                $table->json('metadata')->nullable();
                $table->timestamps();

                $table->unique(['source_module', 'source_table', 'source_id'], 'unique_source_mapping');
                $table->index(['destination_table', 'destination_id'], 'idx_destination');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_migration_mappings');
    }
};

