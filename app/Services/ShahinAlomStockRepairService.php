<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use RuntimeException;
use Throwable;

class ShahinAlomStockRepairService
{
    public const PURCHASE_IDS = [23, 24];
    public const EXCLUDED_FOCUS_IDS = [408, 418, 717, 719];
    public const EXPECTED_TOTAL_SHAHIN_SKUS = 34;
    public const EXPECTED_PRE_ALL_34_SUM = 192;
    public const EXPECTED_PRE_CAT_A_SUM = 59;
    public const EXPECTED_POST_CAT_A_SUM = 44;
    public const EXPECTED_NET_DELTA = -15;
    public const HMAC_ENV_VAR = 'SHAHIN_REPAIR_MANIFEST_HMAC_SECRET';
    public const MIN_HMAC_SECRET_BYTES = 32;
    public const MAX_MANIFEST_FILE_BYTES = 65536;
    public const DEFAULT_MAX_VERIFICATION_AGE_DAYS = 30;

    /**
     * Exact Category A targets approved for V3.1 verification (HOLD until physical count sign-off).
     */
    public const CATEGORY_A_TARGETS = [
        ['id' => 704, 'name' => 'Ring Towel Rali',                'barcode' => '786117', 'old' => '10', 'new' => '9'],
        ['id' => 706, 'name' => '6" Push Basin weste',            'barcode' => '0034Q',  'old' => '6',  'new' => '4'],
        ['id' => 714, 'name' => 'Singel Liver Basin piller Cock', 'barcode' => '78620',  'old' => '3',  'new' => '1'],
        ['id' => 715, 'name' => '18"-Glass Self',                 'barcode' => 'GS-18',  'old' => '6',  'new' => '4'],
        ['id' => 721, 'name' => 'Angel Stop Cock',                'barcode' => '2026DX', 'old' => '10', 'new' => '7'],
        ['id' => 725, 'name' => 'Push Shower',                    'barcode' => '777N',   'old' => '6',  'new' => '4'],
        ['id' => 731, 'name' => 'Moving Piller Cock Besin',       'barcode' => 'S4C',    'old' => '6',  'new' => '5'],
        ['id' => 732, 'name' => 'Moving Sink Cock Liver',         'barcode' => 'S5L',    'old' => '6',  'new' => '5'],
        ['id' => 735, 'name' => 'Moving Sink Cock',               'barcode' => 'S5C',    'old' => '6',  'new' => '5'],
    ];

    /**
     * Exact baseline registry of all 34 Shahin Alom SKUs across Purchases #23 and #24.
     */
    public const ALL_34_SHAHIN_SKUS = [
        ['id' => 408, 'purchase_id' => 23, 'name' => 'Basin West',                     'barcode' => '0036'],
        ['id' => 418, 'purchase_id' => 23, 'name' => 'Satter Cilling Shower-6"',       'barcode' => 'J08'],
        ['id' => 704, 'purchase_id' => 23, 'name' => 'Ring Towel Rali',                'barcode' => '786117'],
        ['id' => 705, 'purchase_id' => 23, 'name' => 'Moving sink Mixer Star',         'barcode' => '0123S'],
        ['id' => 706, 'purchase_id' => 23, 'name' => '6" Push Basin weste',            'barcode' => '0034Q'],
        ['id' => 707, 'purchase_id' => 23, 'name' => 'Premimum Square Shower',         'barcode' => 'J25'],
        ['id' => 708, 'purchase_id' => 23, 'name' => 'Soap Case Steal',                'barcode' => '0050'],
        ['id' => 709, 'purchase_id' => 23, 'name' => 'Besin Mixer Oliver',             'barcode' => '6031OL'],
        ['id' => 710, 'purchase_id' => 23, 'name' => '3" Round Shower',                'barcode' => '131'],
        ['id' => 711, 'purchase_id' => 23, 'name' => 'Glass Self-24"',                 'barcode' => 'GS-24'],
        ['id' => 712, 'purchase_id' => 23, 'name' => 'Liver Big Cock',                 'barcode' => '6128OL'],
        ['id' => 713, 'purchase_id' => 23, 'name' => 'Round Moving Shower',            'barcode' => '134'],
        ['id' => 714, 'purchase_id' => 23, 'name' => 'Singel Liver Basin piller Cock', 'barcode' => '78620'],
        ['id' => 715, 'purchase_id' => 23, 'name' => '18"-Glass Self',                 'barcode' => 'GS-18'],
        ['id' => 716, 'purchase_id' => 23, 'name' => '1" Shower Mixer',                'barcode' => '78690ST'],
        ['id' => 717, 'purchase_id' => 23, 'name' => '12" Top Piller Cock',            'barcode' => '2225'],
        ['id' => 718, 'purchase_id' => 23, 'name' => '24" Tawel Rail',                 'barcode' => '0035'],
        ['id' => 719, 'purchase_id' => 23, 'name' => 'Push Shower Royal Pro',          'barcode' => '777H'],
        ['id' => 720, 'purchase_id' => 23, 'name' => 'Premimum Soap Case',             'barcode' => '0099'],
        ['id' => 721, 'purchase_id' => 23, 'name' => 'Angel Stop Cock',                'barcode' => '2026DX'],
        ['id' => 722, 'purchase_id' => 23, 'name' => '4" Square Moving Shower',        'barcode' => '0054A'],
        ['id' => 723, 'purchase_id' => 23, 'name' => 'Moving Piller Cock Oliver',      'barcode' => '6089OL'],
        ['id' => 724, 'purchase_id' => 23, 'name' => 'Moving Sink Cock Oliver',        'barcode' => '6013OL'],
        ['id' => 725, 'purchase_id' => 23, 'name' => 'Push Shower',                    'barcode' => '777N'],
        ['id' => 726, 'purchase_id' => 24, 'name' => '18*32" Handmade Sink',           'barcode' => 'HKS-207'],
        ['id' => 727, 'purchase_id' => 24, 'name' => '18*36" Handmade Sink',           'barcode' => 'HKS-210'],
        ['id' => 728, 'purchase_id' => 24, 'name' => 'Moving Shower',                  'barcode' => 'MS1'],
        ['id' => 729, 'purchase_id' => 24, 'name' => 'Angel Stop Cock-S2C',            'barcode' => 'S2C'],
        ['id' => 730, 'purchase_id' => 24, 'name' => 'Moving Piller Cock liver',       'barcode' => 'S4L'],
        ['id' => 731, 'purchase_id' => 24, 'name' => 'Moving Piller Cock Besin',       'barcode' => 'S4C'],
        ['id' => 732, 'purchase_id' => 24, 'name' => 'Moving Sink Cock Liver',         'barcode' => 'S5L'],
        ['id' => 733, 'purchase_id' => 24, 'name' => 'Liver Big Cock-S1L',             'barcode' => 'S1L'],
        ['id' => 734, 'purchase_id' => 24, 'name' => 'Big Cock Crown',                 'barcode' => 'S1C'],
        ['id' => 735, 'purchase_id' => 24, 'name' => 'Moving Sink Cock',               'barcode' => 'S5C'],
    ];

    private string $lockStorageDir;
    private string $repairKey;
    private ?string $hmacSecret;
    private int $maxVerificationAgeDays;

    public function __construct(
        ?string $lockStorageDir = null,
        string $repairKey = 'shahin_alam_cat_a_v3_repair',
        ?string $hmacSecret = null,
        int $maxVerificationAgeDays = self::DEFAULT_MAX_VERIFICATION_AGE_DAYS
    ) {
        $this->lockStorageDir = $lockStorageDir ?? storage_path('app/repair-locks');
        $this->repairKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $repairKey) ?: 'shahin_alam_cat_a_v3_repair';
        $this->hmacSecret = $hmacSecret;
        $this->maxVerificationAgeDays = max(1, $maxVerificationAgeDays);
    }

    /**
     * Compute canonical JSON string over the 8 signed manifest fields (excluding 'signature').
     */
    public static function canonicalManifestPayload(array $manifest): string
    {
        $items = [];
        if (isset($manifest['items']) && is_array($manifest['items'])) {
            foreach ($manifest['items'] as $item) {
                if (!is_array($item)) {
                    continue;
                }
                $items[] = [
                    'id' => $item['id'] ?? null,
                    'product_name' => $item['product_name'] ?? null,
                    'barcode' => $item['barcode'] ?? null,
                    'old_qty' => $item['old_qty'] ?? null,
                    'approved_physical_count' => $item['approved_physical_count'] ?? null,
                    'new_qty' => $item['new_qty'] ?? null,
                ];
            }
        }

        $canonical = [
            'repair_reference' => $manifest['repair_reference'] ?? null,
            'verification_date' => $manifest['verification_date'] ?? null,
            'authorized_approver' => $manifest['authorized_approver'] ?? null,
            'forms_reference' => $manifest['forms_reference'] ?? null,
            'target_db' => $manifest['target_db'] ?? null,
            'target_host' => $manifest['target_host'] ?? null,
            'target_port' => $manifest['target_port'] ?? null,
            'items' => $items,
        ];

        return json_encode($canonical, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    public static function computeManifestSignature(array $manifest, string $secret): string
    {
        return hash_hmac('sha256', self::canonicalManifestPayload($manifest), $secret);
    }

    public static function computeManifestSha256(array $manifest): string
    {
        return hash('sha256', self::canonicalManifestPayload($manifest));
    }

    /**
     * Build a canonical unsigned Category A approval manifest template from authoritative targets.
     */
    public static function buildManifestPayload(
        string $repairReference,
        string $verificationDate,
        string $authorizedApprover,
        array|string $formsReference,
        string $targetDb,
        string $targetHost,
        int $targetPort
    ): array {
        if ($targetPort < 1 || $targetPort > 65535) {
            throw new RuntimeException("Target port must be an integer between 1 and 65535; got {$targetPort}.");
        }

        $items = [];
        foreach (self::CATEGORY_A_TARGETS as $target) {
            $items[] = [
                'id' => $target['id'],
                'product_name' => $target['name'],
                'barcode' => $target['barcode'],
                'old_qty' => $target['old'],
                'approved_physical_count' => (int) $target['new'],
                'new_qty' => $target['new'],
            ];
        }

        return [
            'repair_reference' => $repairReference,
            'verification_date' => $verificationDate,
            'authorized_approver' => $authorizedApprover,
            'forms_reference' => $formsReference,
            'target_db' => $targetDb,
            'target_host' => $targetHost,
            'target_port' => $targetPort,
            'items' => $items,
        ];
    }

    /**
     * Deterministically sign an approval manifest using a strict non-blank external HMAC-SHA256 secret.
     */
    public static function signManifest(array $unsignedManifest, string $secret): array
    {
        self::assertValidSecretFormat($secret);
        unset($unsignedManifest['signature']);
        $signed = $unsignedManifest;
        $signed['signature'] = self::computeManifestSignature($unsignedManifest, $secret);
        return $signed;
    }

    private static function assertValidSecretFormat(string $secret): void
    {
        if ($secret === '' || trim($secret) === '') {
            throw new RuntimeException(
                'Manifest HMAC verification failed: external signing secret (' . self::HMAC_ENV_VAR . ') is missing or blank.'
            );
        }
        if ($secret !== trim($secret) || preg_match('/^\s|\s$/', $secret)) {
            throw new RuntimeException(
                'Manifest HMAC verification failed: external signing secret (' . self::HMAC_ENV_VAR . ') must not contain leading or trailing whitespace.'
            );
        }
        if (strlen($secret) < self::MIN_HMAC_SECRET_BYTES) {
            throw new RuntimeException(
                'Manifest HMAC verification failed: external signing secret (' . self::HMAC_ENV_VAR . ') is shorter than ' . self::MIN_HMAC_SECRET_BYTES . ' bytes.'
            );
        }
    }

    /**
     * Strictly read-only dry-run verification. Executes ZERO UPDATE statements and always rolls back.
     */
    public function runDryRun(
        string $expectedDb,
        ?string $expectedHost = null,
        ?int $expectedPort = null,
        ?string $connectionName = null
    ): array {
        if ($expectedPort !== null && ($expectedPort < 1 || $expectedPort > 65535)) {
            throw new RuntimeException("Expected MySQL port must be between 1 and 65535; got {$expectedPort}.");
        }

        $conn = DB::connection($connectionName);
        $pdo = $conn->getPdo();
        $meta = $this->assertDatabaseIdentity($pdo, $expectedDb, $expectedHost, $expectedPort, requireWritable: false, requireHostPort: false);

        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
            $pdo->exec('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
        }

        $pdo->beginTransaction();

        try {
            $snapshot = $this->lockAndValidatePreconditions($pdo, lockForUpdate: false);
            $dbLedgerReady = $this->hasStockRepairTable($pdo);
            $alreadyExecuted = $dbLedgerReady ? $this->hasDbExecutionRecord($pdo) : false;

            $pdo->rollBack();

            return [
                'mode' => 'dry-run',
                'committed' => false,
                'db_ledger_ready' => $dbLedgerReady,
                'already_executed' => $alreadyExecuted,
                'db_meta' => $meta,
                'purchase_count' => $snapshot['purchase_count'],
                'total_34_count' => $snapshot['total_34_count'],
                'pre_sum_34' => $snapshot['pre_sum_34'],
                'planned_post_sum_34' => $snapshot['pre_sum_34'] + self::EXPECTED_NET_DELTA,
                'pre_sum_9' => $snapshot['pre_sum_9'],
                'planned_post_sum_9' => self::EXPECTED_POST_CAT_A_SUM,
                'planned_delta' => self::EXPECTED_NET_DELTA,
                'targets' => $snapshot['targets_preview'],
                'excluded_focus_skus' => $snapshot['excluded_before'],
            ];
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    /**
     * Load and strictly validate an external JSON approval manifest file against expected target, types, and HMAC signature.
     */
    public function readManifestJsonFile(string $manifestPath): array
    {
        if (trim($manifestPath) === '') {
            throw new RuntimeException('Approval manifest file path must not be empty.');
        }

        if (is_link($manifestPath)) {
            throw new RuntimeException("Approval manifest path must not be a symbolic link: '{$manifestPath}'.");
        }

        if (!is_file($manifestPath) || !is_readable($manifestPath)) {
            throw new RuntimeException("Approval manifest file not found or is not a readable regular file: '{$manifestPath}'.");
        }

        $fileSize = @filesize($manifestPath);
        if ($fileSize === false || $fileSize <= 0 || $fileSize > self::MAX_MANIFEST_FILE_BYTES) {
            throw new RuntimeException(
                "Approval manifest file size out of allowed bounds (1.." . self::MAX_MANIFEST_FILE_BYTES . " bytes): '{$manifestPath}'."
            );
        }

        $raw = @file_get_contents($manifestPath);
        if ($raw === false) {
            throw new RuntimeException("Failed reading approval manifest file: '{$manifestPath}'.");
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded) || array_is_list($decoded) || json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Approval manifest file is not a valid JSON object: '{$manifestPath}'.");
        }

        return $decoded;
    }

    public function loadAndValidateManifestFile(
        string $manifestPath,
        string $expectedDb,
        string $expectedHost,
        int $expectedPort
    ): array {
        $decoded = $this->readManifestJsonFile($manifestPath);
        return $this->validateApprovalManifest($decoded, $expectedDb, $expectedHost, $expectedPort);
    }

    public function executeApprovedRepairFromFile(
        string $manifestPath,
        string $expectedDb,
        bool $physicalVerificationConfirmed = false,
        ?string $expectedHost = null,
        ?int $expectedPort = null,
        ?string $connectionName = null,
        ?callable $beforeCommitHook = null
    ): array {
        $decoded = $this->readManifestJsonFile($manifestPath);
        return $this->executeApprovedRepair(
            $expectedDb,
            $physicalVerificationConfirmed,
            $expectedHost,
            $expectedPort,
            $decoded,
            $connectionName,
            $beforeCommitHook
        );
    }

    /**
     * Validate approval manifest payload (strict types, bounded verification_date, HMAC signature, and 9 SKU exact values).
     */
    public function validateApprovalManifest(
        array $manifest,
        string $expectedDb,
        string $expectedHost,
        int $expectedPort
    ): array {
        foreach (['repair_reference', 'verification_date', 'authorized_approver', 'forms_reference', 'target_db', 'target_host', 'target_port', 'items', 'signature'] as $reqField) {
            if (!array_key_exists($reqField, $manifest)) {
                throw new RuntimeException("Approval manifest missing required field '{$reqField}'.");
            }
        }

        if (!is_string($manifest['repair_reference'])) {
            throw new RuntimeException('Approval manifest repair_reference must be a string.');
        }
        $repairRef = trim($manifest['repair_reference']);
        if ($repairRef === '' || strlen($repairRef) > 120) {
            throw new RuntimeException('Approval manifest repair_reference must be 1..120 characters.');
        }

        if (!is_string($manifest['authorized_approver'])) {
            throw new RuntimeException('Approval manifest authorized_approver must be a string.');
        }
        $approver = trim($manifest['authorized_approver']);
        if ($approver === '' || strlen($approver) > 150) {
            throw new RuntimeException('Approval manifest authorized_approver must be 1..150 characters.');
        }

        if (!is_string($manifest['verification_date'])) {
            throw new RuntimeException('Approval manifest verification_date must be a strict YYYY-MM-DD string.');
        }
        $verifDateRaw = trim($manifest['verification_date']);
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $verifDateRaw, $dateMatches)) {
            throw new RuntimeException("Approval manifest verification_date '{$verifDateRaw}' must use strict YYYY-MM-DD format.");
        }
        if (!checkdate((int) $dateMatches[2], (int) $dateMatches[3], (int) $dateMatches[1])) {
            throw new RuntimeException("Approval manifest verification_date '{$verifDateRaw}' is not a valid calendar date.");
        }

        $today = Carbon::today();
        $verifCarbon = Carbon::createFromFormat('Y-m-d', $verifDateRaw)->startOfDay();
        if ($verifCarbon->gt($today)) {
            throw new RuntimeException("Approval manifest verification_date '{$verifDateRaw}' cannot be in the future.");
        }
        $ageDays = $verifCarbon->diffInDays($today, false);
        if ($ageDays > $this->maxVerificationAgeDays) {
            throw new RuntimeException(
                "Approval manifest verification_date '{$verifDateRaw}' is stale ({$ageDays} days old; max allowed {$this->maxVerificationAgeDays})."
            );
        }

        $formsRef = $manifest['forms_reference'];
        if (is_array($formsRef)) {
            if (!array_is_list($formsRef) || empty($formsRef)) {
                throw new RuntimeException('Approval manifest forms_reference must be a non-empty list of strings.');
            }
            $formsClean = [];
            foreach ($formsRef as $entry) {
                if (!is_string($entry) || trim($entry) === '') {
                    throw new RuntimeException('Approval manifest forms_reference entries must be non-empty strings.');
                }
                $formsClean[] = trim($entry);
            }
            $formsNormalized = implode(', ', $formsClean);
        } elseif (is_string($formsRef)) {
            $formsNormalized = trim($formsRef);
            if ($formsNormalized === '') {
                throw new RuntimeException('Approval manifest forms_reference must not be empty.');
            }
        } else {
            throw new RuntimeException('Approval manifest forms_reference must be a string or list of strings.');
        }

        if (strlen($formsNormalized) > 255) {
            throw new RuntimeException('Approval manifest forms_reference exceeds 255 characters.');
        }

        if (!is_string($manifest['target_db']) || trim($manifest['target_db']) !== $expectedDb) {
            throw new RuntimeException('Approval manifest target_db does not match expected database.');
        }
        if (!is_string($manifest['target_host']) || strcasecmp(trim($manifest['target_host']), trim($expectedHost)) !== 0) {
            throw new RuntimeException('Approval manifest target_host does not match expected host.');
        }
        if (!is_int($manifest['target_port']) || $manifest['target_port'] < 1 || $manifest['target_port'] > 65535 || $manifest['target_port'] !== $expectedPort) {
            throw new RuntimeException('Approval manifest target_port must be an exact integer (1..65535) matching expected port.');
        }

        $items = $manifest['items'];
        if (!is_array($items) || !array_is_list($items) || count($items) !== count(self::CATEGORY_A_TARGETS)) {
            throw new RuntimeException(
                'Approval manifest items must be a list containing exactly ' . count(self::CATEGORY_A_TARGETS) . ' Category A SKUs.'
            );
        }

        $expectedTargetsById = [];
        foreach (self::CATEGORY_A_TARGETS as $target) {
            $expectedTargetsById[$target['id']] = $target;
        }

        $seenIds = [];
        foreach ($items as $idx => $item) {
            if (!is_array($item)) {
                throw new RuntimeException("Approval manifest item at index {$idx} must be an object.");
            }
            foreach (['id', 'product_name', 'barcode', 'old_qty', 'approved_physical_count', 'new_qty'] as $field) {
                if (!array_key_exists($field, $item)) {
                    throw new RuntimeException("Approval manifest item at index {$idx} missing required field '{$field}'.");
                }
            }

            if (!is_int($item['id'])) {
                throw new RuntimeException("Approval manifest item at index {$idx} id must be a strict integer.");
            }
            $pid = $item['id'];
            if (!isset($expectedTargetsById[$pid])) {
                throw new RuntimeException("Approval manifest references unexpected Product ID {$pid}.");
            }
            if (isset($seenIds[$pid])) {
                throw new RuntimeException("Approval manifest contains duplicate Product ID {$pid}.");
            }
            $seenIds[$pid] = true;

            $expected = $expectedTargetsById[$pid];
            if (!is_string($item['product_name']) || $item['product_name'] !== $expected['name']) {
                throw new RuntimeException("Approval manifest product_name mismatch for Product ID {$pid}.");
            }
            if (!is_string($item['barcode']) || $item['barcode'] !== $expected['barcode']) {
                throw new RuntimeException("Approval manifest barcode mismatch for Product ID {$pid}.");
            }
            if (!is_string($item['old_qty']) || $item['old_qty'] !== $expected['old']) {
                throw new RuntimeException("Approval manifest old_qty mismatch for Product ID {$pid}.");
            }
            if (!is_string($item['new_qty']) || $item['new_qty'] !== $expected['new']) {
                throw new RuntimeException("Approval manifest new_qty mismatch for Product ID {$pid}.");
            }
            if (!is_int($item['approved_physical_count']) || $item['approved_physical_count'] !== (int) $expected['new']) {
                throw new RuntimeException("Approval manifest approved_physical_count mismatch for Product ID {$pid}.");
            }
        }

        // Verify cryptographic HMAC-SHA256 signature using external runtime secret (never stored in repo)
        if (!is_string($manifest['signature']) || !preg_match('/^[a-f0-9]{64}$/i', $manifest['signature'])) {
            throw new RuntimeException('Approval manifest signature must be a 64-character hex HMAC-SHA256 digest.');
        }

        $secret = $this->resolveHmacSecret();
        $expectedSignature = self::computeManifestSignature($manifest, $secret);
        if (!hash_equals($expectedSignature, strtolower($manifest['signature']))) {
            throw new RuntimeException('Approval manifest HMAC-SHA256 signature verification failed.');
        }

        return [
            'repair_reference' => $repairRef,
            'verification_date' => $verifDateRaw,
            'authorized_approver' => $approver,
            'forms_reference' => $formsNormalized,
            'manifest_sha256' => self::computeManifestSha256($manifest),
            'target_db' => $expectedDb,
            'target_host' => $expectedHost,
            'target_port' => $expectedPort,
            'items_count' => count($seenIds),
        ];
    }

    /**
     * Atomically applies Category A stock repair ONLY when physical verification, signed manifest,
     * host/port, and DB ledger table (`stock_repair_executions`) all pass inside ONE transaction.
     */
    public function executeApprovedRepair(
        string $expectedDb,
        bool $physicalVerificationConfirmed = false,
        ?string $expectedHost = null,
        ?int $expectedPort = null,
        ?array $approvalManifest = null,
        ?string $connectionName = null,
        ?callable $beforeCommitHook = null
    ): array {
        if (!$physicalVerificationConfirmed) {
            throw new RuntimeException(
                'Physical verification (Forms 6A/6B) and explicit owner approval must be confirmed before executing stock repair.'
            );
        }

        if ($expectedHost === null || trim($expectedHost) === '' || $expectedPort === null || $expectedPort < 1 || $expectedPort > 65535) {
            throw new RuntimeException(
                'Live execution requires explicit non-empty expectedHost and expectedPort in range 1..65535.'
            );
        }

        if ($approvalManifest === null) {
            throw new RuntimeException(
                'Live execution requires a validated approval manifest (signed Forms 6A/6B evidence).'
            );
        }

        $validatedManifest = $this->validateApprovalManifest($approvalManifest, $expectedDb, $expectedHost, $expectedPort);

        $conn = DB::connection($connectionName);
        $pdo = $conn->getPdo();
        $meta = $this->assertDatabaseIdentity($pdo, $expectedDb, $expectedHost, $expectedPort, requireWritable: true, requireHostPort: true);

        // Fail closed unless the transactional DB idempotency ledger table exists
        $this->assertStockRepairTableExists($pdo);

        if (!is_dir($this->lockStorageDir) && !@mkdir($this->lockStorageDir, 0775, true) && !is_dir($this->lockStorageDir)) {
            throw new RuntimeException("Unable to initialize repair lock directory '{$this->lockStorageDir}'.");
        }

        $lockPath = $this->getLockPath();
        $lockHandle = @fopen($lockPath, 'c+');
        if ($lockHandle === false) {
            throw new RuntimeException("Unable to open repair lock file '{$lockPath}'.");
        }

        if (!flock($lockHandle, LOCK_EX | LOCK_NB)) {
            fclose($lockHandle);
            throw new RuntimeException('Another Shahin Alom Category A repair execution is currently holding the lock.');
        }

        try {
            if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
                $pdo->exec('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
            }

            $pdo->beginTransaction();

            try {
                // Re-verify table inside transaction and enforce authoritative DB idempotency by repair_key & repair_reference
                $this->assertStockRepairTableExists($pdo);

                if ($this->hasDbExecutionRecord($pdo, lock: true)) {
                    throw new RuntimeException(
                        "Duplicate repair execution blocked by database ledger for key '{$this->repairKey}'."
                    );
                }

                if ($this->hasDbExecutionReference($pdo, $validatedManifest['repair_reference'], lock: true)) {
                    throw new RuntimeException(
                        "Duplicate repair execution blocked: manifest repair_reference '{$validatedManifest['repair_reference']}' was already committed."
                    );
                }

                $snapshot = $this->lockAndValidatePreconditions($pdo);
                $preSum34 = $snapshot['pre_sum_34'];
                $excludedBefore = $snapshot['excluded_before'];
                $nonCatABefore = $snapshot['non_cat_a_before'];

                $stmt = $pdo->prepare("
                    UPDATE products
                    SET quantity = :new_qty, updated_at = NOW()
                    WHERE id = :id
                      AND product_name = :name
                      AND JSON_CONTAINS(product_code, :barcode_json)
                      AND quantity = :old_qty
                      AND CAST(quantity AS SIGNED) = :old_qty_int
                ");

                $updatedRows = [];
                foreach (self::CATEGORY_A_TARGETS as $target) {
                    $stmt->execute([
                        ':new_qty'      => $target['new'],
                        ':id'           => $target['id'],
                        ':name'         => $target['name'],
                        ':barcode_json' => json_encode($target['barcode']),
                        ':old_qty'      => $target['old'],
                        ':old_qty_int'  => (int) $target['old'],
                    ]);

                    $affected = $stmt->rowCount();
                    if ($affected !== 1) {
                        throw new RuntimeException(
                            "Aborting repair: UPDATE for Product ID {$target['id']} affected {$affected} rows (expected 1)."
                        );
                    }

                    $updatedRows[] = [
                        'id' => $target['id'],
                        'name' => $target['name'],
                        'old' => $target['old'],
                        'new' => $target['new'],
                        'affected' => $affected,
                    ];
                }

                // Re-verify all 9 Category A SKUs inside the open transaction before COMMIT
                $catAIds = array_column(self::CATEGORY_A_TARGETS, 'id');
                sort($catAIds);
                $catAPlaceholders = implode(',', array_fill(0, count($catAIds), '?'));
                $afterCatAStmt = $pdo->prepare("SELECT id, quantity FROM products WHERE id IN ({$catAPlaceholders}) ORDER BY id ASC");
                $afterCatAStmt->execute($catAIds);
                $afterCatA = $afterCatAStmt->fetchAll(PDO::FETCH_KEY_PAIR);

                $postCatASum = 0;
                foreach (self::CATEGORY_A_TARGETS as $target) {
                    $actualNew = isset($afterCatA[$target['id']]) ? (string) $afterCatA[$target['id']] : null;
                    if ($actualNew !== $target['new']) {
                        throw new RuntimeException(
                            "Post-update verification failed for Product ID {$target['id']}: expected '{$target['new']}', got '{$actualNew}'."
                        );
                    }
                    $postCatASum += (int) $actualNew;
                }

                if ($postCatASum !== self::EXPECTED_POST_CAT_A_SUM) {
                    throw new RuntimeException(
                        "Post-repair Category A total mismatch: expected " . self::EXPECTED_POST_CAT_A_SUM . ", got {$postCatASum}."
                    );
                }

                // Re-verify all 34 Shahin Alom SKUs sum and non-target rows inside open transaction
                $all34Ids = $snapshot['all_34_ids'];
                $all34Placeholders = implode(',', array_fill(0, count($all34Ids), '?'));
                $after34Stmt = $pdo->prepare("SELECT id, quantity FROM products WHERE id IN ({$all34Placeholders}) ORDER BY id ASC");
                $after34Stmt->execute($all34Ids);
                $after34Map = $after34Stmt->fetchAll(PDO::FETCH_KEY_PAIR);

                if (count($after34Map) !== self::EXPECTED_TOTAL_SHAHIN_SKUS) {
                    throw new RuntimeException(
                        'Post-repair 34-SKU count mismatch: expected ' . self::EXPECTED_TOTAL_SHAHIN_SKUS . ', got ' . count($after34Map)
                    );
                }

                $postSum34 = 0;
                $nonCatAAfter = [];
                foreach ($after34Map as $pid => $qty) {
                    $postSum34 += (int) $qty;
                    if (!in_array((int) $pid, $catAIds, true)) {
                        $nonCatAAfter[(int) $pid] = (string) $qty;
                    }
                }

                $expectedPostSum34 = $preSum34 + self::EXPECTED_NET_DELTA;
                if ($postSum34 !== $expectedPostSum34) {
                    throw new RuntimeException(
                        "Post-repair 34-product total mismatch: expected {$expectedPostSum34}, got {$postSum34}."
                    );
                }

                if ($nonCatAAfter !== $nonCatABefore) {
                    throw new RuntimeException('Non-Category-A Shahin Alom SKUs changed unexpectedly inside transaction.');
                }

                // Verify excluded focus SKUs (408, 418, 717, 719) remained completely untouched using strict comparison
                $exclIds = self::EXCLUDED_FOCUS_IDS;
                sort($exclIds);
                $excludedAfter = [];
                foreach ($exclIds as $eid) {
                    if (!array_key_exists($eid, $after34Map)) {
                        throw new RuntimeException("Excluded focus SKU {$eid} missing from post-repair 34-SKU snapshot.");
                    }
                    $excludedAfter[(int) $eid] = (string) $after34Map[$eid];
                }
                if ($excludedAfter !== $excludedBefore) {
                    throw new RuntimeException('Excluded focus SKUs (408, 418, 717, 719) changed unexpectedly.');
                }

                // Write authoritative execution ledger row inside the EXACT same InnoDB transaction
                $executionId = $this->recordDbExecution($pdo, $validatedManifest, $meta, $updatedRows, $preSum34, $postSum34);

                if ($beforeCommitHook !== null) {
                    $beforeCommitHook($pdo);
                }

                $pdo->commit();

                Log::info('Shahin Alom Stock Repair Executed', [
                    'execution_id' => $executionId,
                    'repair_key' => $this->repairKey,
                    'repair_reference' => $validatedManifest['repair_reference'],
                    'authorized_approver' => $validatedManifest['authorized_approver'],
                    'forms_reference' => $validatedManifest['forms_reference'],
                    'manifest_sha256' => $validatedManifest['manifest_sha256'],
                    'db_meta' => $meta,
                    'pre_sum_9' => self::EXPECTED_PRE_CAT_A_SUM,
                    'post_sum_9' => $postCatASum,
                    'pre_sum_34' => $preSum34,
                    'post_sum_34' => $postSum34,
                    'updated_rows' => $updatedRows,
                    'timestamp' => now()->toIso8601String(),
                ]);

                return [
                    'mode' => 'execute',
                    'committed' => true,
                    'execution_id' => $executionId,
                    'repair_key' => $this->repairKey,
                    'repair_reference' => $validatedManifest['repair_reference'],
                    'authorized_approver' => $validatedManifest['authorized_approver'],
                    'manifest_sha256' => $validatedManifest['manifest_sha256'],
                    'db_meta' => $meta,
                    'total_34_count' => count($after34Map),
                    'pre_sum_34' => $preSum34,
                    'post_sum_34' => $postSum34,
                    'pre_sum_9' => self::EXPECTED_PRE_CAT_A_SUM,
                    'post_sum_9' => $postCatASum,
                    'delta' => $postSum34 - $preSum34,
                    'updated_rows' => $updatedRows,
                ];
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                Log::error('Shahin Alom Stock Repair Aborted & Rolled Back', [
                    'repair_key' => $this->repairKey,
                    'repair_reference' => $validatedManifest['repair_reference'] ?? null,
                    'authorized_approver' => $validatedManifest['authorized_approver'] ?? null,
                    'expected_db' => $expectedDb,
                    'expected_host' => $expectedHost,
                    'expected_port' => $expectedPort,
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        } finally {
            flock($lockHandle, LOCK_UN);
            fclose($lockHandle);
        }
    }

    public function getLockPath(): string
    {
        return rtrim($this->lockStorageDir, '\\/') . DIRECTORY_SEPARATOR . $this->repairKey . '.lock';
    }

    private function resolveHmacSecret(): string
    {
        $secret = $this->hmacSecret;
        if ($secret === null) {
            $envVal = getenv(self::HMAC_ENV_VAR);
            if ($envVal !== false && $envVal !== '') {
                $secret = (string) $envVal;
            } elseif (isset($_ENV[self::HMAC_ENV_VAR]) && $_ENV[self::HMAC_ENV_VAR] !== '') {
                $secret = (string) $_ENV[self::HMAC_ENV_VAR];
            } elseif (isset($_SERVER[self::HMAC_ENV_VAR]) && $_SERVER[self::HMAC_ENV_VAR] !== '') {
                $secret = (string) $_SERVER[self::HMAC_ENV_VAR];
            } else {
                $secret = '';
            }
        }

        self::assertValidSecretFormat($secret);

        return $secret;
    }

    private function hasStockRepairTable(PDO $pdo): bool
    {
        $tableCheck = $pdo->query("SHOW TABLES LIKE 'stock_repair_executions'");
        return (bool) ($tableCheck && $tableCheck->fetchColumn() !== false);
    }

    private function assertStockRepairTableExists(PDO $pdo): void
    {
        if (!$this->hasStockRepairTable($pdo)) {
            throw new RuntimeException(
                "Stock repair execution blocked: required database ledger table 'stock_repair_executions' does not exist. Approve and run its migration first."
            );
        }
    }

    private function hasDbExecutionRecord(PDO $pdo, bool $lock = false): bool
    {
        if (!$this->hasStockRepairTable($pdo)) {
            return false;
        }
        $sql = 'SELECT id FROM stock_repair_executions WHERE repair_key = ? LIMIT 1' . ($lock ? ' FOR UPDATE' : '');
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->repairKey]);
        return (bool) $stmt->fetchColumn();
    }

    private function hasDbExecutionReference(PDO $pdo, string $repairReference, bool $lock = false): bool
    {
        if (!$this->hasStockRepairTable($pdo)) {
            return false;
        }
        $sql = 'SELECT id FROM stock_repair_executions WHERE repair_reference = ? LIMIT 1' . ($lock ? ' FOR UPDATE' : '');
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$repairReference]);
        return (bool) $stmt->fetchColumn();
    }

    private function recordDbExecution(
        PDO $pdo,
        array $manifest,
        array $meta,
        array $updatedRows,
        int $preSum34,
        int $postSum34
    ): int {
        $this->assertStockRepairTableExists($pdo);

        $stmt = $pdo->prepare("
            INSERT INTO stock_repair_executions
                (repair_key, repair_reference, authorized_approver, verification_date, forms_reference, manifest_sha256, target_db, target_host, target_port, pre_sum_9, post_sum_9, pre_sum_34, post_sum_34, updated_rows_json, executed_at)
            VALUES
                (:repair_key, :repair_reference, :authorized_approver, :verification_date, :forms_reference, :manifest_sha256, :target_db, :target_host, :target_port, :pre_sum_9, :post_sum_9, :pre_sum_34, :post_sum_34, :updated_rows_json, NOW())
        ");
        $stmt->execute([
            ':repair_key' => $this->repairKey,
            ':repair_reference' => $manifest['repair_reference'],
            ':authorized_approver' => $manifest['authorized_approver'],
            ':verification_date' => $manifest['verification_date'],
            ':forms_reference' => $manifest['forms_reference'],
            ':manifest_sha256' => $manifest['manifest_sha256'],
            ':target_db' => $meta['db'],
            ':target_host' => $meta['host'],
            ':target_port' => (int) $meta['port'],
            ':pre_sum_9' => self::EXPECTED_PRE_CAT_A_SUM,
            ':post_sum_9' => self::EXPECTED_POST_CAT_A_SUM,
            ':pre_sum_34' => $preSum34,
            ':post_sum_34' => $postSum34,
            ':updated_rows_json' => json_encode($updatedRows, JSON_THROW_ON_ERROR),
        ]);

        return (int) $pdo->lastInsertId();
    }

    private function assertDatabaseIdentity(
        PDO $pdo,
        string $expectedDb,
        ?string $expectedHost,
        ?int $expectedPort,
        bool $requireWritable,
        bool $requireHostPort
    ): array {
        if (trim($expectedDb) === '') {
            throw new RuntimeException('Expected database name must not be empty.');
        }

        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver !== 'mysql') {
            throw new RuntimeException("ShahinAlomStockRepairService requires MySQL driver; got '{$driver}'.");
        }

        $meta = $pdo->query('SELECT DATABASE() AS db, @@hostname AS host, @@port AS port, @@read_only AS ro, @@super_read_only AS sro')
            ->fetch(PDO::FETCH_ASSOC);

        if (!$meta || ($meta['db'] ?? null) !== $expectedDb) {
            $actual = $meta['db'] ?? 'NULL';
            throw new RuntimeException("Database identity mismatch: expected '{$expectedDb}', connected to '{$actual}'.");
        }

        if ($requireHostPort && (empty(trim((string) $expectedHost)) || $expectedPort === null || $expectedPort < 1 || $expectedPort > 65535)) {
            throw new RuntimeException('Expected MySQL host and valid port (1..65535) must be explicitly provided.');
        }

        if ($expectedHost !== null && trim($expectedHost) !== '') {
            $actualHost = (string) ($meta['host'] ?? '');
            if (strcasecmp(trim($actualHost), trim($expectedHost)) !== 0) {
                throw new RuntimeException("Database host mismatch: expected '{$expectedHost}', connected to '{$actualHost}'.");
            }
        }

        if ($expectedPort !== null) {
            if ($expectedPort < 1 || $expectedPort > 65535) {
                throw new RuntimeException("Expected MySQL port must be between 1 and 65535; got {$expectedPort}.");
            }
            $actualPort = (int) ($meta['port'] ?? 0);
            if ($actualPort !== $expectedPort) {
                throw new RuntimeException("Database port mismatch: expected '{$expectedPort}', connected to '{$actualPort}'.");
            }
        }

        if ($requireWritable && ((int) ($meta['ro'] ?? 1) !== 0 || (int) ($meta['sro'] ?? 1) !== 0)) {
            throw new RuntimeException('Target database is read-only; aborting repair execution.');
        }

        return $meta;
    }

    private function lockAndValidatePreconditions(PDO $pdo, bool $lockForUpdate = true): array
    {
        $purPlaceholders = implode(',', array_fill(0, count(self::PURCHASE_IDS), '?'));
        $purStmt = $pdo->prepare("SELECT id, purchase_id FROM purchases WHERE id IN ({$purPlaceholders}) ORDER BY id ASC");
        $purStmt->execute(self::PURCHASE_IDS);
        $purchases = $purStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($purchases) !== count(self::PURCHASE_IDS)) {
            throw new RuntimeException(
                'Expected target purchases (23, 24) to exist; found ' . count($purchases) . '.'
            );
        }

        $podStmt = $pdo->prepare(
            "SELECT purchase_id, product_id FROM purchase_order_details WHERE purchase_id IN ({$purPlaceholders}) ORDER BY product_id ASC"
        );
        $podStmt->execute(self::PURCHASE_IDS);
        $podRows = $podStmt->fetchAll(PDO::FETCH_ASSOC);

        $all34Ids = [];
        $purchaseIdByProduct = [];
        foreach ($podRows as $podRow) {
            $pid = (int) $podRow['product_id'];
            $all34Ids[] = $pid;
            $purchaseIdByProduct[$pid][] = (int) $podRow['purchase_id'];
        }
        $all34Ids = array_values(array_unique($all34Ids));
        sort($all34Ids);

        if (count($all34Ids) !== self::EXPECTED_TOTAL_SHAHIN_SKUS) {
            throw new RuntimeException(
                'Expected ' . self::EXPECTED_TOTAL_SHAHIN_SKUS . ' distinct Shahin Alom SKUs in purchases 23 & 24, found ' . count($all34Ids) . '.'
            );
        }

        $expectedAll34Ids = array_column(self::ALL_34_SHAHIN_SKUS, 'id');
        sort($expectedAll34Ids);
        if ($all34Ids !== $expectedAll34Ids) {
            throw new RuntimeException('Shahin Alom 34-SKU ID set mismatch against verified baseline registry.');
        }

        // Read all 34 Shahin Alom SKUs in deterministic ascending ID order (locking FOR UPDATE only on execute)
        $all34Placeholders = implode(',', array_fill(0, count($all34Ids), '?'));
        $forUpdateClause = $lockForUpdate ? ' FOR UPDATE' : '';
        $lockStmt = $pdo->prepare(
            "SELECT id, product_name, product_code, quantity FROM products WHERE id IN ({$all34Placeholders}) ORDER BY id ASC{$forUpdateClause}"
        );
        $lockStmt->execute($all34Ids);
        $lockedAll34 = $lockStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($lockedAll34) !== self::EXPECTED_TOTAL_SHAHIN_SKUS) {
            throw new RuntimeException(
                'Expected 34 locked product rows, found ' . count($lockedAll34) . '.'
            );
        }

        $byId = [];
        $preSum34 = 0;
        foreach ($lockedAll34 as $row) {
            $id = (int) $row['id'];
            $byId[$id] = $row;
            $preSum34 += (int) $row['quantity'];
        }

        // Verify ALL 34 Shahin Alom SKUs exact names, barcodes, and purchase membership
        foreach (self::ALL_34_SHAHIN_SKUS as $expectedSku) {
            $pid = $expectedSku['id'];
            $row = $byId[$pid] ?? null;
            if (!$row) {
                throw new RuntimeException("Baseline Shahin Alom Product ID {$pid} missing from locked product rows.");
            }
            if (!in_array($expectedSku['purchase_id'], $purchaseIdByProduct[$pid] ?? [], true)) {
                throw new RuntimeException(
                    "Product ID {$pid} is not linked to expected Purchase ID {$expectedSku['purchase_id']}."
                );
            }
            $codes = json_decode((string) $row['product_code'], true);
            $codes = is_array($codes) ? $codes : [];
            if ($row['product_name'] !== $expectedSku['name'] || !in_array($expectedSku['barcode'], $codes, true)) {
                throw new RuntimeException(
                    "34-SKU identity mismatch on Product ID {$pid}: expected name='{$expectedSku['name']}'/barcode='{$expectedSku['barcode']}', got name='{$row['product_name']}' codes='{$row['product_code']}'."
                );
            }
        }

        if ($preSum34 !== self::EXPECTED_PRE_ALL_34_SUM) {
            throw new RuntimeException(
                'Pre-repair 34-SKU total mismatch: expected ' . self::EXPECTED_PRE_ALL_34_SUM . ", got {$preSum34}."
            );
        }

        // Snapshot excluded focus SKUs directly from the already-fetched/locked 34-SKU $byId map (no duplicate query)
        $exclIds = self::EXCLUDED_FOCUS_IDS;
        sort($exclIds);
        $excludedBefore = [];
        foreach ($exclIds as $eid) {
            if (!isset($byId[$eid])) {
                throw new RuntimeException("One or more excluded focus SKUs (408, 418, 717, 719) missing from 34-SKU snapshot: {$eid}.");
            }
            $excludedBefore[(int) $eid] = (string) $byId[$eid]['quantity'];
        }

        $catAIds = array_column(self::CATEGORY_A_TARGETS, 'id');
        $nonCatABefore = [];
        foreach ($byId as $id => $row) {
            if (!in_array($id, $catAIds, true)) {
                $nonCatABefore[$id] = (string) $row['quantity'];
            }
        }

        $preSum9 = 0;
        $targetsPreview = [];
        foreach (self::CATEGORY_A_TARGETS as $target) {
            $row = $byId[$target['id']] ?? null;
            if (!$row) {
                throw new RuntimeException("Category A Product ID {$target['id']} missing from locked 34-SKU set.");
            }

            $codes = json_decode((string) $row['product_code'], true);
            $codes = is_array($codes) ? $codes : [];

            if (
                $row['product_name'] !== $target['name'] ||
                !in_array($target['barcode'], $codes, true) ||
                (string) $row['quantity'] !== $target['old']
            ) {
                throw new RuntimeException(
                    "Precondition mismatch on Product ID {$target['id']}: " .
                    "db_name='{$row['product_name']}', db_qty='{$row['quantity']}', db_codes='{$row['product_code']}'"
                );
            }

            $preSum9 += (int) $row['quantity'];
            $targetsPreview[] = [
                'id' => $target['id'],
                'name' => $target['name'],
                'barcode' => $target['barcode'],
                'current_qty' => (string) $row['quantity'],
                'planned_qty' => $target['new'],
                'delta' => (int) $target['new'] - (int) $target['old'],
            ];
        }

        if ($preSum9 !== self::EXPECTED_PRE_CAT_A_SUM) {
            throw new RuntimeException(
                'Pre-repair Category A sum mismatch: expected ' . self::EXPECTED_PRE_CAT_A_SUM . ", got {$preSum9}."
            );
        }

        return [
            'purchase_count' => count($purchases),
            'all_34_ids' => $all34Ids,
            'total_34_count' => count($lockedAll34),
            'pre_sum_34' => $preSum34,
            'pre_sum_9' => $preSum9,
            'targets_preview' => $targetsPreview,
            'excluded_before' => $excludedBefore,
            'non_cat_a_before' => $nonCatABefore,
        ];
    }
}
