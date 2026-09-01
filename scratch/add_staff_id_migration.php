<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('expenses', 'staff_id')) {
    Schema::table('expenses', function (Blueprint $table) {
        $table->unsignedBigInteger('staff_id')->nullable()->after('expense_type_id');
        $table->foreign('staff_id')->references('id')->on('users')->onDelete('set null');
    });
    echo "SUCCESS: Added staff_id column to expenses table.\n";
} else {
    echo "INFO: staff_id column already exists in expenses table.\n";
}
