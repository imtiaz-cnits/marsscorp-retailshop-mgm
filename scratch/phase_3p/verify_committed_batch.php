<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$batchId = $pdo->query("SELECT migration_batch_id FROM battery_migration_mappings ORDER BY id DESC LIMIT 1")->fetchColumn();
if (!$batchId) {
    fwrite(STDERR, "FATAL: No migration batch found!\n");
    exit(1);
}

$count = (int)$pdo->query("SELECT COUNT(*) FROM battery_migration_mappings WHERE migration_batch_id = '{$batchId}'")->fetchColumn();
$uniqueCount = (int)$pdo->query("SELECT COUNT(DISTINCT source_module, source_table, source_id) FROM battery_migration_mappings WHERE migration_batch_id = '{$batchId}'")->fetchColumn();

if ($count !== 37 || $count !== $uniqueCount) {
    fwrite(STDERR, "FATAL: Batch mapping count mismatch! Count: {$count}, Unique: {$uniqueCount}, Expected: 37\n");
    exit(1);
}

echo "COMMITTED_BATCH_VERIFIED|{$batchId}|{$count}";
exit(0);

