<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Default Queue Connection: " . config('queue.default') . PHP_EOL;
echo "Queue Config for default connection: " . json_encode(config('queue.connections.' . config('queue.default')), JSON_PRETTY_PRINT) . PHP_EOL;

// Check if jobs table exists
$hasJobs = Illuminate\Support\Facades\Schema::hasTable('jobs');
$hasFailedJobs = Illuminate\Support\Facades\Schema::hasTable('failed_jobs');
$hasJobBatches = Illuminate\Support\Facades\Schema::hasTable('job_batches');
echo "jobs table exists: " . ($hasJobs ? 'YES' : 'NO') . PHP_EOL;
echo "failed_jobs table exists: " . ($hasFailedJobs ? 'YES' : 'NO') . PHP_EOL;
echo "job_batches table exists: " . ($hasJobBatches ? 'YES' : 'NO') . PHP_EOL;

if ($hasJobs) {
    echo "jobs count: " . Illuminate\Support\Facades\DB::table('jobs')->count() . PHP_EOL;
}
if ($hasFailedJobs) {
    echo "failed_jobs count: " . Illuminate\Support\Facades\DB::table('failed_jobs')->count() . PHP_EOL;
}

$refPause = new ReflectionClass(Illuminate\Queue\Console\PauseCommand::class);
echo "PauseCommand File: " . $refPause->getFileName() . PHP_EOL;

$refRestart = new ReflectionClass(Illuminate\Queue\Console\RestartCommand::class);
echo "RestartCommand File: " . $refRestart->getFileName() . PHP_EOL;
