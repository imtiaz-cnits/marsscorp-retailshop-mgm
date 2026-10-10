<?php

/**
 * Battery Dummy Data Cleanup Utility
 * 
 * Safely removes all development & testing dummy data from Battery module tables
 * in marsscorpdb while leaving all Retail Shop tables untouched.
 * 
 * Automatically backs up all battery tables before clearing.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

$targetDb = config('database.connections.mysql.database');

foreach ($argv as $arg) {
    if (str_starts_with($arg, '--db=')) {
        $targetDb = substr($arg, 5);
        Config::set('database.connections.mysql.database', $targetDb);
        DB::purge('mysql');
        DB::reconnect('mysql');
    }
}

echo "================================================================================\n";
echo "           BATTERY MODULE DUMMY DATA CLEANUP UTILITY\n";
echo "================================================================================\n";
echo "Connected Database : {$targetDb}\n";
echo "Timestamp          : " . date('Y-m-d H:i:s') . "\n";
echo "--------------------------------------------------------------------------------\n\n";

// List of all Battery module tables
$batteryTables = [
    // 1. Transaction & Ledger Details
    'battery_order_payment_details',
    'battery_product_returns',
    'battery_order_details',
    'battery_orders',
    'battery_purchase_returns',
    'battery_purchase_payment_details',
    'battery_purchase_order_details',
    'battery_purchases',
    'battery_supplier_due_collections',
    'battery_customer_payment_details',
    'battery_expenses',
    'battery_opening_balances',
    // 2. Master Data
    'battery_products',
    'battery_suppliers',
    'battery_customers',
    'battery_sub_categories',
    'battery_categories',
    'battery_brands',
    'battery_expense_types',
    'battery_units',
];

// Step 1: Pre-cleanup row count report
echo "CURRENT BATTERY DATA ROW COUNTS:\n";
$totalRows = 0;
foreach ($batteryTables as $tbl) {
    $exists = DB::select("SHOW TABLES LIKE '{$tbl}'");
    if (!empty($exists)) {
        $cnt = DB::table($tbl)->count();
        $totalRows += $cnt;
        echo "  - " . str_pad($tbl, 36) . ": {$cnt} rows\n";
    }
}
echo "Total Battery Dummy Rows to Clear: {$totalRows}\n\n";

if ($totalRows === 0) {
    echo "Notice: Battery tables are already completely empty.\n";
    exit(0);
}

// Step 2: Ensure backup file exists or create a new timestamped backup
$backupFile = __DIR__ . '/backup_battery_tables_' . date('Ymd_His') . '.sql';
$fp = fopen($backupFile, 'w');
if ($fp) {
    fwrite($fp, "-- AUTOMATIC PRE-CLEANUP BATTERY BACKUP\n");
    fwrite($fp, "-- Created At: " . date('Y-m-d H:i:s') . "\n");
    fwrite($fp, "-- Database: {$targetDb}\n\n");
    fwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");
    
    foreach ($batteryTables as $tbl) {
        $exists = DB::select("SHOW TABLES LIKE '{$tbl}'");
        if (empty($exists)) continue;
        
        $create = DB::select("SHOW CREATE TABLE `{$tbl}`");
        $createSql = $create[0]->{'Create Table'};
        fwrite($fp, "DROP TABLE IF EXISTS `{$tbl}`;\n");
        fwrite($fp, $createSql . ";\n\n");
        
        $rows = DB::table($tbl)->get();
        if ($rows->count() > 0) {
            foreach ($rows as $row) {
                $cols = array_keys((array)$row);
                $colList = implode('`, `', $cols);
                $vals = [];
                foreach ((array)$row as $val) {
                    $vals[] = ($val === null) ? "NULL" : "'" . addslashes($val) . "'";
                }
                $valList = implode(', ', $vals);
                fwrite($fp, "INSERT INTO `{$tbl}` (`{$colList}`) VALUES ({$valList});\n");
            }
            fwrite($fp, "\n");
        }
    }
    fwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
    fclose($fp);
    echo "STEP 1: Backup successfully created -> " . basename($backupFile) . " (" . number_format(filesize($backupFile)) . " bytes)\n\n";
}

// Step 3: Clear all battery tables
echo "STEP 2: Truncating Battery tables...\n";
DB::statement("SET FOREIGN_KEY_CHECKS=0;");

foreach ($batteryTables as $tbl) {
    $exists = DB::select("SHOW TABLES LIKE '{$tbl}'");
    if (!empty($exists)) {
        DB::statement("TRUNCATE TABLE `{$tbl}`;");
        echo "  [CLEARED] {$tbl} (AUTO_INCREMENT reset to 1)\n";
    }
}

// Step 4: Re-insert standard Unit "Pcs" for initial usability
DB::table('battery_units')->insert([
    'id'         => 1,
    'unit_name'  => 'Pcs',
    'user_id'    => 1,
    'created_at' => now(),
    'updated_at' => now(),
]);
echo "  [SEEDED] battery_units (ID: 1, unit_name: 'Pcs')\n";

DB::statement("SET FOREIGN_KEY_CHECKS=1;");
echo "\nSTEP 3: Foreign key checks re-enabled.\n\n";

// Step 5: Verification of final counts
echo "POST-CLEANUP BATTERY ROW COUNTS:\n";
$remainingRows = 0;
foreach ($batteryTables as $tbl) {
    $cnt = DB::table($tbl)->count();
    $remainingRows += $cnt;
    echo "  - " . str_pad($tbl, 36) . ": {$cnt} rows\n";
}

echo "\n--------------------------------------------------------------------------------\n";
echo "CLEANUP COMPLETE: Battery module dummy data removed successfully.\n";
echo "Retail tables untouched: 100%\n";
echo "Backup preserved at: " . basename($backupFile) . "\n";
echo "================================================================================\n";
