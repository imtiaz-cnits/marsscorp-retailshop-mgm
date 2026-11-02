# PHASE 3A: Controlled Production Execution Plan

**Project:** Retail Management System (`marsscorp-retailshop-mgm`)  
**Phase:** Phase 3A — Production Execution Planning & Operator Control Protocol  
**Plan Date:** November 2, 2026 — 23:45:00 +06:00  
**Target Environment:** Local Production / Windows Server (MySQL 8.4.3 Community Server - GPL)  
**Target Database:** `marsscorpdb`  
**Status:** **PLANNING ONLY — AWAITING EXPLICIT HUMAN AUTHORIZATION**  
**Strict Gate:** **NO LIVE MIGRATION, NO `--force`, NO DATA INSERT/UPDATE/DELETE EXECUTED.**

---

## 1. Final Code Freeze & Command Verification

The migration command [`app/Console/Commands/MigrateRetailToBatteryCommand.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/app/Console/Commands/MigrateRetailToBatteryCommand.php) is officially **FROZEN**.

### Exact Command Signature & Options:
```php
protected $signature = 'battery:migrate-from-retail 
                        {--dry-run : Run simulation in read-only mode without saving database changes} 
                        {--force : Commit migration permanently to the database} 
                        {--rollback : Safely reverse migrated battery records by batch without touching pre-existing data} 
                        {--batch= : Specify the exact migration batch ID to rollback (mandatory for rollback)}
                        {--reconcile-only : Verify existing data and display financial baseline matrix without changes}';
```

### Critical Safety Invariants in Frozen Code:
1. **Target Database Guard:** The command inspects `DB::connection()->getDatabaseName()` at entry. If the active database is not strictly `marsscorpdb`, execution terminates immediately.
2. **Explicit Rollback Batch Parameter:** If `--rollback` is specified without an explicit `--batch=<BATCH_ID>`, execution halts with an error. Automatic fallback to latest batch is completely disabled.
3. **Multi-Entity Foreign Dependency Guards:** Rollback inspects `battery_order_details` (for products), `battery_orders` (for customers), and `battery_purchases` (for suppliers) to block rollback if subsequent transactions exist.
4. **Database-Level Idempotency:** The tracking table `battery_migration_mappings` enforces a database-level `UNIQUE KEY unique_source_mapping (source_module, source_table, source_id)`.
5. **Atomic Transaction Boundary:** The entire 6-level migration runs within `DB::beginTransaction()`. If any step fails or if post-migration mathematical reconciliation deviates by even ৳0.01, `DB::rollBack()` is executed.

---

## 2. Resolution of the Checksum Verification Caveat

### The Technical Caveat:
In MySQL 8.4, the system variable `group_concat_max_len` defaults to **1024 bytes**. Standard SQL queries utilizing `GROUP_CONCAT()` can silently truncate row concatenations for tables exceeding 1 KB, resulting in hash comparisons that cover only the truncated prefix. Furthermore, simple delimiter concatenation (`#`) can theoretically experience delimiter collisions.

### The Robust Cryptographic Solution:
To provide undeniable content-level parity proof, an un-truncatable **streaming per-row SHA-256 algorithm with length-prefixed column encoding** was implemented in [`scratch/verify_advanced_checksums.php`](file:///C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/scratch/verify_advanced_checksums.php).

- **Encoding Protocol:** Each column is serialized as `col_name:L{length}:{value};` (or `col_name:N;` for NULLs), ordered strictly by column ordinal position.
- **Streaming Context:** Rows are ordered by primary key `id` and streamed directly into `hash_init('sha256')`, bypassing MySQL string buffer limitations entirely.

### Actual Execution Evidence (Production vs Restored Staging):

| Critical ERP Table | Total Rows | Production SHA-256 (`marsscorpdb`) | Staging SHA-256 (`marsscorpdb_staging_verify`) | Parity Status |
| :--- | :---: | :---: | :---: | :---: |
| **products** | 364 | `ef7872a6871155ac61db3a6cd175a5580f050b224a0932fbb1063efcc0f65324` | `ef7872a6871155ac61db3a6cd175a5580f050b224a0932fbb1063efcc0f65324` | **100% MATCH** |
| **customers** | 91 | `35cecc00fcf25f66208795a7b89cde1237d7996ab97db7a3d828faf20292ae18` | `35cecc00fcf25f66208795a7b89cde1237d7996ab97db7a3d828faf20292ae18` | **100% MATCH** |
| **orders** | 94 | `dd8f28fdc24d43c7fb09630c681a6c445f0c8ab2c846d9949a2066f8da0408f2` | `dd8f28fdc24d43c7fb09630c681a6c445f0c8ab2c846d9949a2066f8da0408f2` | **100% MATCH** |
| **order_details** | 273 | `96cd6c1d4410b51d6a65fb233d077fd3dbbc8bfe33fed3821de3eec83abd5764` | `96cd6c1d4410b51d6a65fb233d077fd3dbbc8bfe33fed3821de3eec83abd5764` | **100% MATCH** |
| **order_payment_details** | 108 | `032a58f5b5252cc6716294d70fa557812606a479e507e1fb09e589f38c4649d9` | `032a58f5b5252cc6716294d70fa557812606a479e507e1fb09e589f38c4649d9` | **100% MATCH** |
| **purchases** | 17 | `ff08ccd87cb2644f90fa09b32cbd5d4c9b0d3764c0365c2b5cefd3ef64818f77` | `ff08ccd87cb2644f90fa09b32cbd5d4c9b0d3764c0365c2b5cefd3ef64818f77` | **100% MATCH** |
| **purchase_order_details**| 116 | `0432d48f377ca295f9bddeb15e8b9c3beef072b0158aaa19cc16a931989c4819` | `0432d48f377ca295f9bddeb15e8b9c3beef072b0158aaa19cc16a931989c4819` | **100% MATCH** |
| **purchase_payment_details**| 17 | `c6430e7298e77a8eee2f63f728fe446b21f3055a87fd256f409d07a6656ea106` | `c6430e7298e77a8eee2f63f728fe446b21f3055a87fd256f409d07a6656ea106` | **100% MATCH** |
| **expenses** | 145 | `49253b54095ade6c602e68108ab8eb3020fce265e11a42a50477ccc921505ff1` | `49253b54095ade6c602e68108ab8eb3020fce265e11a42a50477ccc921505ff1` | **100% MATCH** |
| **customer_payment_details**| 30 | `f55cccd07c1748f2bd9fd31c27acc5f36b57b573128a01583fe53ad1e57ff1dd` | `f55cccd07c1748f2bd9fd31c27acc5f36b57b573128a01583fe53ad1e57ff1dd` | **100% MATCH** |
| **supplier_due_collections**| 3 | `fdbf03d3aa98a4b9a4c53841ab23b96b36b35b90108ba7e28f71c3668971a1b9` | `fdbf03d3aa98a4b9a4c53841ab23b96b36b35b90108ba7e28f71c3668971a1b9` | **100% MATCH** |
| **suppliers** | 14 | `4a3befe1ac2ee7de3be5a3a9c4e7ee56950d6b34868522d8785664321dfb15a1` | `4a3befe1ac2ee7de3be5a3a9c4e7ee56950d6b34868522d8785664321dfb15a1` | **100% MATCH** |
| **categories** | 30 | `0c69ce1f2219e6ea3640125c917d0aff395e5082445831a6fd719bf5124c3efe` | `0c69ce1f2219e6ea3640125c917d0aff395e5082445831a6fd719bf5124c3efe` | **100% MATCH** |
| **brands** | 22 | `78addd0d92417f98f82d7a5f48a95f10f83be01077ba52a8ea25519e65cd91af` | `78addd0d92417f98f82d7a5f48a95f10f83be01077ba52a8ea25519e65cd91af` | **100% MATCH** |
| **units** | 1 | `764cd5cd4e82c7dd91006f94da94cb845c8996fc584ee9f39d501152ec8fb57e` | `764cd5cd4e82c7dd91006f94da94cb845c8996fc584ee9f39d501152ec8fb57e` | **100% MATCH** |

> **Verdict:** 100% Cryptographic Content Parity verified. The caveat is fully resolved.

---

## 3. Production Preflight Checklist

Before any operator executes the live command, the following preflight checks must be verified:

| Check # | Verification Item | Target Standard | Verification Method | Status |
| :---: | :--- | :--- | :--- | :---: |
| **01** | Active Database Name | Exactly `marsscorpdb` | Built-in command guard + `SELECT DATABASE()` | **PASS** |
| **02** | Database Engine & Version | MySQL 8.4.3 Community Server | `SELECT VERSION()` | **PASS** |
| **03** | Storage Engine Standard | 100% InnoDB across all 55 tables | `information_schema.tables` | **PASS** |
| **04** | Backup File Existence | `storage/app/backups/marsscorpdb_pre_migration_backup_20261102.sql` | Size: 248 KB, MD5 verified | **PASS** |
| **05** | Available Disk Space | Drive C: > 20 GB, Drive D: > 10 GB | Drive C: 23.81 GB, Drive D: 11.25 GB | **PASS** |
| **06** | Battery Tables Initial State | Exactly 0 rows across all 20 `battery_*` tables | `scratch/check_zero_rows.php` | **PASS** |
| **07** | Mapping Table Initial State | Exactly 0 rows in `battery_migration_mappings` | `DB::table('battery_migration_mappings')->count()` | **PASS** |
| **08** | Retail Source Preservation | 364 products, 91 customers, 94 orders, 17 purchases | Table row counts | **PASS** |
| **09** | Approved Financial Baseline | Receivables: ৳623,231; Payables: ৳115,360 | Mathematical audit | **PASS** |
| **10** | Maintenance Isolation | Single-operator CLI access; web requests paused | `php artisan down` | **REQUIRED** |

---

## 4. Controlled Execution Procedure

### The Exact Command (DO NOT RUN WITHOUT AUTHORIZATION):
```powershell
php artisan battery:migrate-from-retail --force
```

### Execution Details:
1. **Interactive Prompt:** The command will display:
   ```
   >>> EXECUTION MODE: LIVE MIGRATION (Changes will be permanently committed) <<<
   Live Migration Batch ID: BATCH-YYYYMMDD-HHMMSS-XXXXXX

   Are you absolutely sure you want to execute live migration on the database? (yes/no) [no]:
   ```
   The operator types `yes` to proceed.
2. **Transaction Open:** `DB::beginTransaction()` is invoked.
3. **DAG Execution Sequence:**
   - **Level 1 (Catalogs):** Migrates Category #3 ('Battery'), Brands #14 ('Pollo') & #15 ('E.V Battery'), Unit #1 ('Pcs'), Expense Type ('Transports cost').
   - **Level 2 (Entities):** Migrates Suppliers #1 ('Polo Battery', payable ৳7,360.00) & #11 ('CK124', payable ৳0.00); Migrates Customers #2 ('Nur Battery', due ৳467,465.00), #5 ('Riyaz Battery', opening due ৳23,592.00), #1 ('Ma Saleha', opening due ৳0.00), #34 ('Walk-in' mirror, opening due ৳0.00).
   - **Level 3 (Products & Expenses):** Migrates 5 Products (#567, #568, #569, #736, #737 with 1 unit reconstructed stock); Migrates 2 Pure Battery Expenses (#82 = ৳160, #123 = ৳100). Enforces Option B retaining ৳820 in Retail.
   - **Level 4 (Purchases & Orders):** Migrates Purchase #15 (`#PurID00015`, due ৳108,000.00); Migrates Orders #53 (`#InvID00051`, due ৳37,674.00), #62 (`#InvID00060`, due ৳94,500.00), #26 (`#InvID00024` mirror, due ৳0.00).
   - **Level 5 (Line Items, Payments & Collections):** Inserts 8x Benq purchase details; Inserts order line items; Records unpaid purchase payment detail; Records Order #53 and #62 payment details; Inserts 5 Customer collections (Nur ৳50,000, Riyaz ৳94,186); Inserts 3 Supplier payments (Polo ৳105,000).
   - **Level 6 (Returns Audit):** Verifies 0 sales returns and 0 purchase returns in ERP source; target return tables left empty.
4. **Post-Migration Mathematical Reconciliation:** Evaluates all 5 accounting baselines. If all pass, asserts mapping count matches DB rows.
5. **Commit & Logging:** Executes `DB::commit()`. Persists full log to `storage/app/battery_migration_mapping.json`.

---

## 5. Post-Migration Immediate Verification Checklist (SQL Queries)

Immediately following execution, the operator will run the following SQL queries to verify complete success:

### Query 1: Battery Products & Stock Count
```sql
SELECT id, product_name, quantity, cost_price, sell_price, status 
FROM battery_products ORDER BY id;
```
- **Expected Output:** Exactly 5 rows.
  - `HPD-225T`: quantity = 0
  - `PTB-250`: quantity = 0
  - `NEXCELL-235`: quantity = 0
  - `AP-29`: quantity = 0
  - `Benq`: quantity = **1**

### Query 2: Customer Receivables & Active Due
```sql
SELECT id, customer_id, customer_name, previous_due_amount 
FROM battery_customers ORDER BY id;
```
- **Expected Output:**
  - `Nur Battery`: `previous_due_amount` = **467465.00**
  - `Riyaz Battery`: `previous_due_amount` = **23592.00**
  - `Ma Saleha Enterpice`: `previous_due_amount` = **0.00**
  - `Walk-in Customer`: `previous_due_amount` = **0.00**

### Query 3: Sales Orders & Incurred Due
```sql
SELECT id, order_no, sub_total, paid_amount, due_amount 
FROM battery_orders ORDER BY id;
```
- **Expected Output:** Exactly 3 rows.
  - `#InvID00051`: due_amount = **37674.00**
  - `#InvID00060`: due_amount = **94500.00**
  - `#InvID00024`: due_amount = **0.00** (sub_total = 0.00, paid_amount = 0.00)

### Query 4: Total Customer Receivables Summary
```sql
SELECT 
  (SELECT COALESCE(SUM(previous_due_amount),0) FROM battery_customers) AS customer_previous_due,
  (SELECT COALESCE(SUM(due_amount),0) FROM battery_orders) AS orders_due,
  ((SELECT COALESCE(SUM(previous_due_amount),0) FROM battery_customers) + 
   (SELECT COALESCE(SUM(due_amount),0) FROM battery_orders)) AS total_customer_receivables;
```
- **Expected Output:**
  - `customer_previous_due`: **491057.00**
  - `orders_due`: **132174.00**
  - `total_customer_receivables`: **623231.00** (Variance: **৳0.00**)

### Query 5: Supplier Payables & Liabilities Summary
```sql
SELECT 
  (SELECT COALESCE(SUM(purchase_payable_amount),0) FROM battery_suppliers) AS supplier_opening_payable,
  (SELECT COALESCE(SUM(due_amount),0) FROM battery_purchases) AS purchases_due,
  ((SELECT COALESCE(SUM(purchase_payable_amount),0) FROM battery_suppliers) + 
   (SELECT COALESCE(SUM(due_amount),0) FROM battery_purchases)) AS total_supplier_payables;
```
- **Expected Output:**
  - `supplier_opening_payable`: **7360.00** (Polo Battery)
  - `purchases_due`: **108000.00** (CK124 Purchase #15)
  - `total_supplier_payables`: **115360.00** (Variance: **৳0.00**)

### Query 6: Historical Collections Log
```sql
SELECT COUNT(*) as receipts_count, SUM(paid_amount) as total_collections 
FROM battery_customer_payment_details;
```
- **Expected Output:** `receipts_count` = **5**, `total_collections` = **144186.00**.

### Query 7: Historical Supplier Payments Log
```sql
SELECT COUNT(*) as payments_count, SUM(paid_amount) as total_payments 
FROM battery_supplier_due_collections;
```
- **Expected Output:** `payments_count` = **3**, `total_payments` = **105000.00**.

### Query 8: Option B Battery Expenses
```sql
SELECT id, expense_details, expense_amount, date FROM battery_expenses;
```
- **Expected Output:** Exactly 2 rows totaling **৳260.00** (ID 82 ৳160.00, ID 123 ৳100.00).

### Query 9: Tracking Table Mapping Rows
```sql
SELECT migration_batch_id, COUNT(*) as total_mappings 
FROM battery_migration_mappings GROUP BY migration_batch_id;
```
- **Expected Output:** Exactly 1 batch record with `total_mappings` = **29**.

### Query 10: Retail ERP Preservation
```sql
SELECT 
  (SELECT COUNT(*) FROM products) AS retail_products,
  (SELECT COUNT(*) FROM customers) AS retail_customers,
  (SELECT COUNT(*) FROM orders) AS retail_orders,
  (SELECT COUNT(*) FROM purchases) AS retail_purchases;
```
- **Expected Output:** Exactly `retail_products` = **364**, `retail_customers` = **91**, `retail_orders` = **94**, `retail_purchases` = **17** (100% untouched).

---

## 6. Emergency Rollback & Disaster Recovery Protocol

### Tier 1: Automated Batch-Scoped Rollback (Immediate CLI Recovery)
If any business discrepancy is observed immediately following migration:
```powershell
php artisan battery:migrate-from-retail --rollback --batch=<MIGRATION_BATCH_ID>
```
1. **Behavior:**
   - Resolves all 29 mappings for `<MIGRATION_BATCH_ID>`.
   - Checks that no subsequent independent transactions reference the migrated items.
   - Deletes target records in reverse DAG order.
   - Deletes mapping rows from `battery_migration_mappings`.
   - Leaves all pre-existing battery records and all retail records 100% untouched.

### Tier 2: Bare-Metal Backup Restoration (Disaster Recovery)
If database corruption or hardware interruption occurs during execution:
```powershell
mysql --host=127.0.0.1 --port=3306 -u root marsscorpdb < storage/app/backups/marsscorpdb_pre_migration_backup_20261102.sql
```
- Restores the entire database to the exact verified state documented in Phase 2D.
- Confirmed tested on staging: restores all 55 tables with 100% SHA-256 content parity.

---

## 7. Operator Step-by-Step Execution Checklist

```
[ ] 1. Ensure application is in maintenance mode: `php artisan down`
[ ] 2. Confirm backup file exists: `storage/app/backups/marsscorpdb_pre_migration_backup_20261102.sql`
[ ] 3. Verify zero rows in battery tables: `php scratch/check_zero_rows.php`
[ ] 4. Receive explicit user/human authorization in chat.
[ ] 5. Run live migration command: `php artisan battery:migrate-from-retail --force`
[ ] 6. Note the generated Batch ID from console output.
[ ] 7. Execute Post-Migration SQL Verification Queries (Queries 1–10).
[ ] 8. Verify all 10 SQL outputs match expected numbers with ৳0.00 variance.
[ ] 9. Bring application back online: `php artisan up`
[ ] 10. Present final live execution confirmation report.
```

---

## 8. Final Approval Gate: Strict Execution Halt

> [!IMPORTANT]
> **STRICT COMPLIANCE NOTICE:**  
> The agent has prepared the complete execution plan, resolved all technical caveats, verified cryptographic SHA-256 content parity, and established the rollback protocol.
> 
> **NO LIVE MIGRATION HAS OCCURRED.**  
> The agent will now halt and await your explicit command before executing Phase 3.

