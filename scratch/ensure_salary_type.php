<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ExpenseType;
use App\Models\User;

$firstUser = User::first();
$userId = $firstUser ? $firstUser->id : 1;

$hasSalary = ExpenseType::where(function($query) {
    $query->where('type_name', 'LIKE', '%salary%')
          ->orWhere('type_name', 'LIKE', '%sallery%')
          ->orWhere('type_name', 'LIKE', '%বেতন%')
          ->orWhere('type_name', 'LIKE', '%সেলারী%')
          ->orWhere('type_name', 'LIKE', '%স্যালারি%')
          ->orWhere('type_name', 'LIKE', '%স্টাফ%');
})->exists();

if (!$hasSalary) {
    ExpenseType::create([
        'type_name' => 'Sallery',
        'status' => 'Active',
        'user_id' => $userId
    ]);
    echo "SUCCESS: Created default 'Sallery' expense type in database.\n";
} else {
    echo "INFO: Salary expense type already exists in database.\n";
}
