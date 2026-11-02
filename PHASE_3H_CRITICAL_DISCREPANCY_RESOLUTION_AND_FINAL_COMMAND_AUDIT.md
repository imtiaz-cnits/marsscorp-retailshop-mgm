# Phase 3H: Critical Financial Discrepancy Resolution & Final Command Integrity Audit

**Project:** Retail Management System (`marsscorp-retailshop-mgm`)  
**Database Server:** MySQL 8.4.3 Community Server (Win64) on `127.0.0.1:3306`  
**Production Database:** `marsscorpdb` (Read-Only Mode)  
**Staging Verification Database:** `marsscorpdb_staging_verify`  
**PHP Executable:** `C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe`  
**Framework Version:** Laravel Framework 12.64.0  
**Timestamp:** November 3, 2026 (01:35:00 +06:00)  
**Author:** Antigravity AI Engineering & Senior Database Architect

---

## 1. Executive Verdict & Operational Status

```
========================================================================================
                      PHASE 3H FINAL GATE AUDIT VERDICT                                 
========================================================================================
  OVERALL TECHNICAL AUDIT STATUS : [PASS] - ALL DISCREPANCIES FORMALLY RESOLVED
  PRODUCTION EXECUTION VERDICT   : [HOLD] - LIVE MIGRATION NOT AUTHORIZED
  PRODUCTION DATABASE STATE      : [UNMODIFIED] - ALL 21 BATTERY TABLES = 0 ROWS
  RETAIL ERP SOURCE INTEGRITY    : [100% PRESERVED] - 15/15 STREAMING SHA-256 MATCH
  AUTHORIZATION STATUS           : STRICT HUMAN AUTHORIZATION GATE ACTIVE
========================================================================================
```

During Phase 3H, all operational inconsistencies, financial query discrepancies, and Artisan command naming issues identified during the Phase 3G review were subjected to rigorous, evidence-driven database forensics.

**Core Findings:**
1. **Riyaz Customer Ledger Discrepancy Resolved:** The database and migration code strictly set `battery_customers.previous_due_amount = 23,592.00` (net opening due) and `battery_orders.due_amount = 37,674.00`, totaling closing receivable of **৳61,266.00**. The erroneous mention of `61,266` in Phase 3G Q05 was a documentation reporting typo. Zero double-deduction confirmed.
2. **Order #26 vs Order #62 Discrepancy Resolved:** Forensic inspection confirmed that Order #26 (`#InvID00024`) is a mixed invoice containing 1 unit of `PTB-250` (migrated at ৳0.00 subtotal, ৳0.00 due, ৳0.00 item price for pure stock tracking). Order #62 (`#InvID00060`) is Ma Saleha's real sale of 7 units of `Benq` @ ৳13,500 = **৳94,500.00 due**. Phase 3G Q07/Q13 expected results were erroneous prose in the markdown report, while the actual codebase has always executed the exact Phase 2D policy.
3. **Artisan Command Signature Verified:** The registered command signature is strictly **`php artisan battery:migrate-from-retail`**. The phantom name `migrate:retail-to-battery` was accidentally derived from the PHP class filename.
4. **15 Source Tables Re-Verified:** 15 out of 15 critical tables matched the established streaming SHA-256 checksums down to the byte.
5. **Schema-Driven Foreign Key Audit:** Enumerate 45 physical foreign keys via `information_schema.KEY_COLUMN_USAGE`; tested on staging with **0 orphans**.
6. **Clean Isolated Backup Restore:** Restored 55/55 tables from scratch into an empty database (`marsscorpdb_clean_test_restore`) with 100% row count parity.
7. **Strict Human Gate Maintained:** Zero writes occurred on `marsscorpdb`.

---

## 2. Riyaz Customer Ledger Discrepancy Resolution

### 2.1 The Issue in Phase 3G
In Phase 3G Q05, the expected result for Riyaz was mistakenly listed as `previous_due_amount = 61,266`. This directly contradicted the ledger architecture established in Phase 2D, which requires:
$$\text{Net Opening Due } (৳23,592) + \text{Order \#53 Due } (৳37,674) = \text{Closing Receivable } (৳61,266)$$

### 2.2 Forensic Inspection of Source Database Records
Direct read-only inspection of `marsscorpdb` yields:
```
1. Customer Table (`customers` where `id = 5`):
   - customer_id:         CUST-0005
   - customer_name:       Riyaz Battery
   - previous_due_amount: ৳23,592.00  <-- Pre-existing Net Due in Retail Table

2. Order Table (`orders` where `customer_id = 5`):
   - id:                  53
   - order_no:            #InvID00051
   - sub_total:           ৳41,860.00 (2x AP-29 @ ৳20,930)
   - paid_amount:         ৳4,186.00 (advance payment on invoice)
   - due_amount:          ৳37,674.00

3. Historical Receipts Table (`customer_payment_details` where `customer_id = 5`):
   - Receipt ID 4  (2026-09-02): ৳50,000.00 (due_amount recorded: ৳53,904.00)
   - Receipt ID 15 (2026-10-01): ৳14,186.00 (due_amount recorded: ৳91,266.00)
   - Receipt ID 19 (2026-10-06): ৳30,000.00 (due_amount recorded: ৳61,266.00)
   - Total Collections:         ৳94,186.00
```

### 2.3 Verification in Migration Source Code
In [`app/Console/Commands/MigrateRetailToBatteryCommand.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/app/Console/Commands/MigrateRetailToBatteryCommand.php#L443-L464):
```php
// Lines 443-464:
$batRiyaz = new BatteryCustomer();
$batRiyaz->customer_id         = $riyaz->customer_id;
$batRiyaz->customer_name       = $riyaz->customer_name;
$batRiyaz->previous_due_amount = 23592.00; // Approved remaining previous due
$batRiyaz->save();

$this->recordMapping('customers', 5, 'battery_customers', $batRiyaz->id, [
    'customer_id'     => $riyaz->customer_id,
    'net_opening_due' => 23592.00,
    'closing_due'     => 61266.00
]);
```
And during post-migration verification in the same file:
```php
// Lines 912-921:
$riyazPrev  = (float)BatteryCustomer::where('customer_id', 'CUST-0005')->value('previous_due_amount'); // 23,592.00
$riyazOrd   = (float)BatteryOrder::where('order_no', '#InvID00051')->value('due_amount');            // 37,674.00
$riyazTotal = $riyazPrev + $riyazOrd;                                                                 // 61,266.00
```

### 2.4 Traceability of Offline Khata Forensics (৳13,874.00) & Zero Double-Deduction
- **Historical Gross Balance:** ৳117,778.00
- **Historical Receipts Collected:** ৳94,186.00
- **Net Opening Balance:** $117,778 - 94,186 = ৳23,592.00$
- **Traceability:** The ৳13,874.00 offline settlement discovered in Phase 2D forensics is preserved because the source table `customers.previous_due_amount` was already adjusted to ৳23,592.00 in the physical database.
- **Zero Double-Deduction:** The 3 historical payment records (IDs 4, 15, 19 totaling ৳94,186) are migrated into `battery_customer_payment_details` as historical audit receipts. They are **not** subtracted again from `battery_customers.previous_due_amount`, guaranteeing zero double-deduction.
- **Mathematical Variance:** Exactly **৳0.00**.

### 2.5 Corrected Query 05
```sql
-- Q05 (Corrected): Customer Net Opening Dues
SELECT id, customer_id, customer_name, previous_due_amount 
FROM battery_customers 
ORDER BY id;
/* Expected Correct Result:
+----+-------------+----------------------+---------------------+
| id | customer_id | customer_name        | previous_due_amount |
+----+-------------+----------------------+---------------------+
|  1 | CUST-0002   | Nur Battery          |           467465.00 |
|  2 | CUST-0005   | Riyaz Battery        |            23592.00 |
|  3 | CUST-0001   | Ma Saleha Enterpice  |                0.00 |
|  4 | CUST-0034   | Walk-in Customer     |                0.00 |
+----+-------------+----------------------+---------------------+
Total Net Opening Dues = ৳491,057.00
*/
```

---

## 3. Order #26 vs Order #62 Transaction-Level Investigation

### 3.1 The Issue in Phase 3G
Phase 3G reports Q07 and Q13 contained erroneous prose:
- Q07 claimed `#InvID00024` had `sub_total = 14,500` and `paid = 14,500`.
- Q13 claimed `#InvID00024` had `Benq Battery` qty=1, price=14,500.

### 3.2 Database Forensics of Source Orders & Line Items
Direct SQL queries on `orders` and `order_details` in `marsscorpdb`:
```
A. Order #26 (`#InvID00024`):
   - Table `orders`:
     id=26, order_no='#InvID00024', customer_id=34, sub_total=0.00, paid_amount=0.00, due_amount=0.00
   - Table `order_details`:
     - Detail #33: product_id=568 ("PTB-250"), qty=1, price=25500, selling_price=0
     - Detail #34: product_id=546 ("Wheel big cock Medium", Retail Category 24), qty=1, price=1260, selling_price=0

B. Order #62 (`#InvID00060`):
   - Table `orders`:
     id=62, order_no='#InvID00060', customer_id=1 (Ma Saleha), sub_total=94500.00, paid_amount=0.00, due_amount=94500.00
   - Table `order_details`:
     - Detail #173: product_id=737 ("Benq"), qty=7, price=13500, selling_price=13500 (7 * 13,500 = ৳94,500.00)

C. Purchase #15 (`#PurID00015`):
   - Table `purchases`:
     id=15, purchase_id='#PurID00015', supplier_id=14 (CK124), due_amount=108000.00
   - Table `purchase_order_details`:
     product_id=737 ("Benq"), qty=8, cost_price=13500, subtotal=108000.00 (8 * 13,500 = ৳108,000.00)
```

### 3.3 Transaction-Level Reconciliation Table

| Source Order | Source Invoice | Customer | Battery Product | Source Quantity | Financial Value in Retail | Financial Value in Battery Mirror | Expected Migration Architecture |
| :--- | :--- | :--- | :--- | :---: | :---: | :---: | :--- |
| **Order #26** | `#InvID00024` | Customer 34 (Walk-in) | `PTB-250` (ID 568) | 1 | Subtotal ৳0, Paid ৳0, Due ৳0 | **Subtotal ৳0.00, Paid ৳0.00, Due ৳0.00** | **Pure stock-only mirror.** Line item price = ৳0.00. Retail plumbing item (`Wheel`) excluded. Zero financial duplication. |
| **Order #62** | `#InvID00060` | Customer 1 (Ma Saleha) | `Benq` (ID 737) | 7 | Subtotal ৳94,500, Due ৳94,500 | **Subtotal ৳94,500.00, Due ৳94,500.00** | **Actual Battery sales invoice.** 7 units @ ৳13,500 = ৳94,500.00 receivable due. |
| **Order #53** | `#InvID00051` | Customer 5 (Riyaz) | `AP-29` (ID 736) | 2 | Subtotal ৳41,860, Due ৳37,674 | **Subtotal ৳41,860.00, Due ৳37,674.00** | **Actual Battery sales invoice.** 2 units @ ৳20,930 = ৳41,860, Paid ৳4,186, Due ৳37,674. |

### 3.4 Verification of Inventory Movement (Benq & PTB-250)
- **Benq (Product 737):** Purchased = 8 units (`#PurID00015`) $-$ Sold = 7 units (`#InvID00060`) $\rightarrow$ **Closing Physical Stock = 1 Unit** (Cost = ৳13,500.00).
- **PTB-250 (Product 568):** Opening Stock = 1 unit $-$ Sold = 1 unit (`#InvID00024` mirror) $\rightarrow$ **Closing Stock = 0 Units**.
- **AP-29 (Product 736):** Purchased = 2 units $-$ Sold = 2 units (`#InvID00051`) $\rightarrow$ **Closing Stock = 0 Units**.
- **Hamko (Product 738) & Volvo (Product 739):** Stock = 0 Units.

### 3.5 Codebase Proof
In `app/Console/Commands/MigrateRetailToBatteryCommand.php`:
- Line 641: `26 => ['customer' => 34, 'note' => 'Mirror for mixed Retail invoice #InvID00024 (Zero financial value)']`
- Line 761: `// Order #26 (1x PTB-250 @ ৳0 = ৳0)`
- Line 771-772: `$od26->price = 0.00; $od26->selling_price = 0.00;`
- Line 743: `// Order #62 (7x Benq @ ৳13,500 = ৳94,500)`

**Conclusion:** The migration code maps the exact correct entities. The error in Phase 3G was entirely a markdown writing error in Q07/Q13.

### 3.6 Corrected Queries 07 & 13
```sql
-- Q07 (Corrected): Battery Orders Headers
SELECT id, order_no, sub_total, paid_amount, due_amount 
FROM battery_orders 
ORDER BY id;
/* Expected Correct Result (3 rows):
+----+-------------+-----------+-------------+------------+
| id | order_no    | sub_total | paid_amount | due_amount |
+----+-------------+-----------+-------------+------------+
|  1 | #InvID00051 |  41860.00 |     4186.00 |   37674.00 |
|  2 | #InvID00060 |  94500.00 |        0.00 |   94500.00 |
|  3 | #InvID00024 |      0.00 |        0.00 |       0.00 |
+----+-------------+-----------+-------------+------------+
Total Orders Due = 37,674 + 94,500 + 0 = ৳132,174.00
*/

-- Q13 (Corrected): Mixed Order #26 Mirror Isolation Verification
SELECT o.id, o.order_no, o.sub_total, o.due_amount, od.product_id, od.quantity, od.price, od.selling_price
FROM battery_orders o 
JOIN battery_order_details od ON o.id = od.order_id 
WHERE o.order_no = '#InvID00024';
/* Expected Correct Result:
+----+-------------+-----------+------------+------------+----------+-------+---------------+
| id | order_no    | sub_total | due_amount | product_id | quantity | price | selling_price |
+----+-------------+-----------+------------+------------+----------+-------+---------------+
|  3 | #InvID00024 |      0.00 |       0.00 |          1 |        1 |  0.00 |          0.00 |
+----+-------------+-----------+------------+------------+----------+-------+---------------+
(Exactly 1 item: PTB-250, qty=1, price=0.00, subtotal=0.00, due=0.00. Stock tracking only)
*/
```

---

## 4. Verification of Actual Artisan Command Signatures

### 4.1 Inspection of Command Registration
- **Command Class:** `app/Console/Commands/MigrateRetailToBatteryCommand.php`
- **Class Name:** `MigrateRetailToBatteryCommand`
- **Actual `$signature` Property:**
  ```php
  protected $signature = 'battery:migrate-from-retail 
                          {--dry-run : Run simulation in read-only mode without saving database changes} 
                          {--force : Commit migration permanently to the database} 
                          {--rollback : Safely reverse migrated battery records by batch without touching pre-existing data} 
                          {--batch= : Specify the exact migration batch ID to rollback (mandatory for rollback)}
                          {--reconcile-only : Verify existing data and display financial baseline matrix without changes}';
  ```

### 4.2 Proof via Laravel Artisan CLI
Running `php artisan help battery:migrate-from-retail` outputs:
```
Description:
  Safely migrate historical Battery business data from Retail module to Battery module with batch-scoped rollback & idempotency

Usage:
  battery:migrate-from-retail [options]

Options:
      --dry-run         Run simulation in read-only mode without saving database changes
      --force           Commit migration permanently to the database
      --rollback        Safely reverse migrated battery records by batch without touching pre-existing data
      --batch[=BATCH]   Specify the exact migration batch ID to rollback (mandatory for rollback)
      --reconcile-only  Verify existing data and display financial baseline matrix without changes
```

Running `php artisan help migrate:retail-to-battery` outputs:
```
ERROR  Command "migrate:retail-to-battery" is not defined.
```

### 4.3 Command Behavior & Guard Specifications
1. **Simulation / Dry-Run (Default):**
   ```bash
   php artisan battery:migrate-from-retail --dry-run
   ```
   If `--force` is omitted, the command defaults to simulation mode (`$dryRun = true`), executes all DAG levels, runs reconciliation, exports dry-run JSON, and executes `DB::rollBack()`.
2. **Reconciliation-Only Check:**
   ```bash
   php artisan battery:migrate-from-retail --reconcile-only
   ```
   Outputs the verified financial baseline matrix (Exit code 0) without any transactions.
3. **Controlled Live Migration (Requires Explicit Authorization):**
   ```bash
   php artisan battery:migrate-from-retail --force
   ```
   - Must be connected to `marsscorpdb` (Database safety guard aborts if connected to any other DB).
   - Prompts for confirmation: `Are you absolutely sure you want to execute live migration on the database? (yes/no) [no]:`.
   - Executes `DB::commit()` **first**, followed by non-fatal auxiliary JSON manifest generation.
4. **Batch-Scoped Rollback:**
   ```bash
   php artisan battery:migrate-from-retail --rollback --batch=<BATCH_ID>
   ```
   - Requires explicit `--batch=<BATCH_ID>`. Aborts if batch parameter is missing.
   - Deletes strictly in reverse foreign key topological DAG order.
   - Never uses `TRUNCATE`.

---

## 5. Fifteen-Table SHA-256 Source Parity Re-Verification

Every critical table in production `marsscorpdb` was re-verified using length-prefixed streaming SHA-256 serialization (`col:L<len>:<val>;`):

| # | Table Name | Actual Rows | Actual Production SHA-256 Checksum | Phase 3G Baseline Checksum | Result |
| :---: | :--- | :---: | :--- | :--- | :---: |
| 1 | `products` | 364 | `ef7872a6871155ac61db3a6cd175a5580f050b224a0932fbb1063efcc0f65324` | `ef7872a6871155ac61db3a6cd175a5580f050b224a0932fbb1063efcc0f65324` | **100% MATCH** |
| 2 | `customers` | 91 | `35cecc00fcf25f66208795a7b89cde1237d7996ab97db7a3d828faf20292ae18` | `35cecc00fcf25f66208795a7b89cde1237d7996ab97db7a3d828faf20292ae18` | **100% MATCH** |
| 3 | `orders` | 94 | `dd8f28fdc24d43c7fb09630c681a6c445f0c8ab2c846d9949a2066f8da0408f2` | `dd8f28fdc24d43c7fb09630c681a6c445f0c8ab2c846d9949a2066f8da0408f2` | **100% MATCH** |
| 4 | `order_details` | 273 | `96cd6c1d4410b51d6a65fb233d077fd3dbbc8bfe33fed3821de3eec83abd5764` | `96cd6c1d4410b51d6a65fb233d077fd3dbbc8bfe33fed3821de3eec83abd5764` | **100% MATCH** |
| 5 | `order_payment_details` | 108 | `032a58f5b5252cc6716294d70fa557812606a479e507e1fb09e589f38c4649d9` | `032a58f5b5252cc6716294d70fa557812606a479e507e1fb09e589f38c4649d9` | **100% MATCH** |
| 6 | `purchases` | 17 | `ff08ccd87cb2644f90fa09b32cbd5d4c9b0d3764c0365c2b5cefd3ef64818f77` | `ff08ccd87cb2644f90fa09b32cbd5d4c9b0d3764c0365c2b5cefd3ef64818f77` | **100% MATCH** |
| 7 | `purchase_order_details` | 116 | `0432d48f377ca295f9bddeb15e8b9c3beef072b0158aaa19cc16a931989c4819` | `0432d48f377ca295f9bddeb15e8b9c3beef072b0158aaa19cc16a931989c4819` | **100% MATCH** |
| 8 | `purchase_payment_details` | 17 | `c6430e7298e77a8eee2f63f728fe446b21f3055a87fd256f409d07a6656ea106` | `c6430e7298e77a8eee2f63f728fe446b21f3055a87fd256f409d07a6656ea106` | **100% MATCH** |
| 9 | `expenses` | 145 | `49253b54095ade6c602e68108ab8eb3020fce265e11a42a50477ccc921505ff1` | `49253b54095ade6c602e68108ab8eb3020fce265e11a42a50477ccc921505ff1` | **100% MATCH** |
| 10 | `customer_payment_details` | 30 | `f55cccd07c1748f2bd9fd31c27acc5f36b57b573128a01583fe53ad1e57ff1dd` | `f55cccd07c1748f2bd9fd31c27acc5f36b57b573128a01583fe53ad1e57ff1dd` | **100% MATCH** |
| 11 | `supplier_due_collections` | 3 | `fdbf03d3aa98a4b9a4c53841ab23b96b36b35b90108ba7e28f71c3668971a1b9` | `fdbf03d3aa98a4b9a4c53841ab23b96b36b35b90108ba7e28f71c3668971a1b9` | **100% MATCH** |
| 12 | `suppliers` | 14 | `4a3befe1ac2ee7de3be5a3a9c4e7ee56950d6b34868522d8785664321dfb15a1` | `4a3befe1ac2ee7de3be5a3a9c4e7ee56950d6b34868522d8785664321dfb15a1` | **100% MATCH** |
| 13 | `categories` | 30 | `0c69ce1f2219e6ea3640125c917d0aff395e5082445831a6fd719bf5124c3efe` | `0c69ce1f2219e6ea3640125c917d0aff395e5082445831a6fd719bf5124c3efe` | **100% MATCH** |
| 14 | `brands` | 22 | `78addd0d92417f98f82d7a5f48a95f10f83be01077ba52a8ea25519e65cd91af` | `78addd0d92417f98f82d7a5f48a95f10f83be01077ba52a8ea25519e65cd91af` | **100% MATCH** |
| 15 | `units` | 1 | `764cd5cd4e82c7dd91006f94da94cb845c8996fc584ee9f39d501152ec8fb57e` | `764cd5cd4e82c7dd91006f94da94cb845c8996fc584ee9f39d501152ec8fb57e` | **100% MATCH** |

**Parity Verdict: 15/15 Tables 100% Identical.** Zero row modifications, zero column updates, and zero deletions have occurred in the production database.

---

## 6. Schema-Driven Foreign Key Inventory & Orphan Audit

A query on `information_schema.KEY_COLUMN_USAGE` identified **45 physical foreign key constraints** in the Battery module schema:

### 6.1 Physical Foreign Key Constraints Catalog
```
 1. battery_brands                   (user_id)                   -> users (id)
 2. battery_categories               (user_id)                   -> users (id)
 3. battery_customer_payment_details (customer_id)               -> battery_customers (id)
 4. battery_customer_payment_details (user_id)                   -> users (id)
 5. battery_customers                (district_id)               -> districts (id)
 6. battery_customers                (thana_id)                  -> thanas (id)
 7. battery_customers                (upazila_id)                -> upazilas (id)
 8. battery_customers                (user_id)                   -> users (id)
 9. battery_expense_types            (user_id)                   -> users (id)
10. battery_expenses                 (expense_type_id)           -> battery_expense_types (id)
11. battery_expenses                 (user_id)                   -> users (id)
12. battery_opening_balances         (user_id)                   -> users (id)
13. battery_order_details            (order_id)                  -> battery_orders (id)
14. battery_order_details            (product_id)                -> battery_products (id)
15. battery_order_details            (user_id)                   -> users (id)
16. battery_order_payment_details    (order_id)                  -> battery_orders (id)
17. battery_order_payment_details    (user_id)                   -> users (id)
18. battery_orders                   (customer_id)               -> battery_customers (id)
19. battery_orders                   (user_id)                   -> users (id)
20. battery_product_returns          (customer_id)               -> battery_customers (id)
21. battery_product_returns          (order_id)                  -> battery_orders (id)
22. battery_product_returns          (product_id)                -> battery_products (id)
23. battery_product_returns          (user_id)                   -> users (id)
24. battery_products                 (brand_id)                  -> battery_brands (id)
25. battery_products                 (category_id)               -> battery_categories (id)
26. battery_products                 (sub_category_id)           -> battery_sub_categories (id)
27. battery_products                 (unit_id)                   -> battery_units (id)
28. battery_products                 (user_id)                   -> users (id)
29. battery_purchase_order_details   (product_id)                -> battery_products (id)
30. battery_purchase_order_details   (purchase_id)               -> battery_purchases (id)
31. battery_purchase_order_details   (user_id)                   -> users (id)
32. battery_purchase_payment_details (purchases_id)              -> battery_purchases (id)
33. battery_purchase_payment_details (user_id)                   -> users (id)
34. battery_purchase_returns         (product_id)                -> battery_products (id)
35. battery_purchase_returns         (purchase_id)               -> battery_purchases (id)
36. battery_purchase_returns         (supplier_id)               -> battery_suppliers (id)
37. battery_purchase_returns         (user_id)                   -> users (id)
38. battery_purchases                (supplier_id)               -> battery_suppliers (id)
39. battery_purchases                (user_id)                   -> users (id)
40. battery_sub_categories           (category_id)               -> battery_categories (id)
41. battery_sub_categories           (user_id)                   -> users (id)
42. battery_supplier_due_collections (supplier_id)               -> battery_suppliers (id)
43. battery_supplier_due_collections (user_id)                   -> users (id)
44. battery_suppliers                (user_id)                   -> users (id)
45. battery_units                    (user_id)                   -> users (id)
```

### 6.2 Staging Verification Results
An automated audit script executed orphan checks on all 45 physical constraints against the staging database:
$$\text{Total Foreign Key Constraints Checked: } 45 \quad\longrightarrow\quad \text{Orphans Found: } \mathbf{0} \quad \mathbf{[100\%\ PASS]}$$

---

## 7. Clean Isolated Backup Restore Validation

The backup restore was tested against a **clean, completely empty database**:
1. **Isolated Database Creation:** `CREATE DATABASE marsscorpdb_clean_test_restore` (Verified 0 tables).
2. **Source Backup File:** `storage/app/backups/marsscorpdb_pre_migration_backup_20261103.sql`
   - File Size: `255,383 bytes` (249.4 KB)
   - SHA-256 Checksum: `f90d8550ac642a54c468ed75d2c167c3cde13b626fc92165e798bf9a28664e48`
   - Target Volume Free Space: `11.25 GB`
3. **Execution Command:**
   ```bash
   mysql --host=127.0.0.1 --port=3306 --user=root marsscorpdb_clean_test_restore < storage/app/backups/marsscorpdb_pre_migration_backup_20261103.sql
   ```
4. **Execution Results:**
   - Exit Code: `0`
   - Duration: `8.66 seconds`
   - Total Tables Restored: `55 / 55 tables` (100% schema match)
   - Row Count Verification:
     - `products`: 364 (Match)
     - `customers`: 91 (Match)
     - `orders`: 94 (Match)
     - `order_details`: 273 (Match)
     - `purchases`: 17 (Match)
     - `expenses`: 145 (Match)
     - All 21 `battery_*` tables: 0 rows (Match)
5. **Clean-Up:** Temporary database `marsscorpdb_clean_test_restore` dropped cleanly after verification.

---

## 8. Event Scheduler Restoration Safety Review

### 8.1 Findings on Server Events
- `SHOW EVENTS FROM marsscorpdb`: **Empty set (0 rows)**
- `SELECT * FROM information_schema.EVENTS`: **Empty set (0 rows)** across the entire MySQL server.

### 8.2 Architectural Safety Recommendation
- Since **zero events exist on the entire server**, turning `event_scheduler = OFF` introduces unnecessary global server mutation and privilege requirements without providing any real isolation benefit.
- **Recommended Action:** Leave `event_scheduler` untouched during migration.
- If corporate protocol mandates toggling:
  ```sql
  -- Store initial state:
  SET @saved_scheduler = @@GLOBAL.event_scheduler;
  SET GLOBAL event_scheduler = OFF;
  -- Restore original state post-migration:
  SET GLOBAL event_scheduler = @saved_scheduler;
  ```

---

## 9. Queue & Database Writer Landscape

### 9.1 Three-Tier Categorization of Database Writers

| Category | Component | Inspection Method | Verified Status |
| :--- | :--- | :--- | :--- |
| **Verified Absent** | External Queue Workers | `jobs` table count, task manager | **0 active processes**, 0 rows in `jobs` table |
| **Verified Absent** | External Schedulers | `Get-ScheduledTask` audit | **0 tasks** invoking PHP / Artisan |
| **Verified Absent** | Apache Virtual Hosts | `C:\laragon\etc\apache2\sites-enabled\00-default.conf` | DocumentRoot is `C:/laragon/www` (only default `index.php`). **No vhost for `marsscorp`**. |
| **Verified Absent** | External MySQL Clients | `SHOW FULL PROCESSLIST` | **0 external clients**. Only internal daemon and CLI root session exist. |
| **Known & Controlled** | Local Web Dev Server | `Get-NetTCPConnection -LocalPort 8000` | Running on PID 2880, 16024. Controlled via `php artisan down` or temporary process stop. |
| **Known & Controlled** | Migration Operator CLI | Console session | Single active thread executing migration command. |
| **Unknown Writers** | **NONE** | Comprehensive system audit | **Zero unknown writers.** |

### 9.2 Queue Commands Verification
- Driver: `database` (`config/queue.php`)
- Queue Name: `default`
- `queue:pause default` and `queue:continue default`: Verified official built-in Laravel Framework 12.64.0 commands.
- `queue:restart`: Dispatches cache broadcast signal to restart daemon workers gracefully.

---

## 10. Comprehensive Financial & Inventory Reconciliation

The table below presents the definitive reconciliation matrix:

| Accounting Component | Source Baseline in Retail | Target in Battery Module | Variance | Evidence & Forensics Reference |
| :--- | :---: | :---: | :---: | :--- |
| **Customer Receivables: Nur Battery** | ৳467,465.00 | ৳467,465.00 | **৳0.00** | `customers.id=2`, 0 orders, opening = closing due |
| **Customer Net Opening: Riyaz Battery** | ৳23,592.00 | ৳23,592.00 | **৳0.00** | `customers.id=5`, pre-existing net opening due |
| **Customer Order #53: Riyaz Battery** | ৳37,674.00 | ৳37,674.00 | **৳0.00** | `orders.id=53` (`#InvID00051`), subtotal ৳41,860, paid ৳4,186 |
| **Customer Total Closing: Riyaz Battery** | ৳61,266.00 | ৳61,266.00 | **৳0.00** | ৳23,592 opening + ৳37,674 order = ৳61,266 closing |
| **Customer Net Opening: Ma Saleha** | ৳0.00 | ৳0.00 | **৳0.00** | Retail balance (৳223,680) retained in Retail; zero duplicate |
| **Customer Order #62: Ma Saleha** | ৳94,500.00 | ৳94,500.00 | **৳0.00** | `orders.id=62` (`#InvID00060`, 7x Benq @ ৳13,500) due = ৳94,500 |
| **Customer Mixed Order #26: Walk-in** | ৳0.00 | ৳0.00 | **৳0.00** | `orders.id=26` (`#InvID00024`), mirror subtotal=0, due=0 |
| **TOTAL CUSTOMER RECEIVABLES** | **৳623,231.00** | **৳623,231.00** | **৳0.00** | **৳491,057 opening + ৳132,174 orders = ৳623,231.00** |
| **Historical Customer Collections** | ৳144,186.00 | ৳144,186.00 | **৳0.00** | Nur ৳50,000 (2 rct) + Riyaz ৳94,186 (3 rct), audit receipts |
| **Supplier Net Opening: Polo Battery** | ৳7,360.00 | ৳7,360.00 | **৳0.00** | Approved net opening payable = ৳7,360.00 |
| **Supplier Purchase #15 Due: CK124** | ৳108,000.00 | ৳108,000.00 | **৳0.00** | `purchases.id=15` (`#PurID00015`, 8x Benq @ ৳13,500) due = ৳108,000 |
| **TOTAL SUPPLIER LIABILITIES** | **৳115,360.00** | **৳115,360.00** | **৳0.00** | **৳7,360 opening + ৳108,000 purchase = ৳115,360.00** |
| **Historical Supplier Payments** | ৳105,000.00 | ৳105,000.00 | **৳0.00** | Polo Battery: 3 payments (৳30k+৳45k+৳30k) = ৳105,000 |
| **Pure Battery Expenses (Option B)** | ৳260.00 | ৳260.00 | **৳0.00** | `expenses.id` IN (82, 123) = ৳160.00 + ৳100.00 |
| **Mixed Transport Expenses** | ৳820.00 | ৳0.00 | **৳0.00** | Zero transfer; retained in Retail ERP |
| **Physical Stock: Benq Battery** | 1 Unit | 1 Unit | **0 Unit** | 8 purchased (`#PurID00015`) - 7 sold (`#InvID00060`) = 1 unit |
| **Physical Stock: 4 Other Products** | 0 Units | 0 Units | **0 Unit** | PTB-250 (1-1=0), AP-29 (2-2=0), Hamko (0), Volvo (0) |

---

## 11. Complete Enumeration of All 10 Pre-Migration Safety Gates

| Gate # | Safety Requirement | Verification Method | Evidence & Test Location | Status |
| :---: | :--- | :--- | :--- | :---: |
| **Gate 1** | Target Database Preflight Guard | Hardcoded database name check (`marsscorpdb`) | Command line 88 aborts if connected DB is not `marsscorpdb`. Verified in Phase 3A. | **PASS** |
| **Gate 2** | Batch-Scoped DAG Rollback | Reverse dependency deletion by explicit batch ID | Verified via DAG topological order in `MigrateRetailToBatteryCommand.php`. Global TRUNCATE removed. | **PASS** |
| **Gate 3** | Composite Mapping Uniqueness | DB unique constraint on `(source_module, source_table, source_id)` | Constraint active on `battery_migration_mappings`. Tested on staging. | **PASS** |
| **Gate 4** | Mathematical Reconciliation Engine | Dual-module financial reconciliation verification | Receivables (৳623,231) and Payables (৳115,360) validated via `--reconcile-only`. | **PASS** |
| **Gate 5** | Mixed Invoice Isolation | Zero-value Battery mirror for mixed order #26 | Detail 33 (PTB-250) mirrored at ৳0.00; Retail hardware item excluded. | **PASS** |
| **Gate 6** | Reconstructed Physical Inventory | Physical stock calculation from historical ledger | Benq = 1 unit, PTB-250 = 0, AP-29 = 0, Hamko = 0, Volvo = 0. | **PASS** |
| **Gate 7** | Native Hardened Backup Protocol | `mysqldump --result-file` (UTF-8, No BOM) | 255,383 bytes backup file verified with SHA-256 and structural signatures. | **PASS** |
| **Gate 8** | Clean Isolated Database Restore | 100% restore into clean empty DB | 55/55 tables restored from scratch in 8.66s with identical row counts. | **PASS** |
| **Gate 9** | Canonical Streaming SHA-256 Parity | Length-prefixed column encoding SHA-256 | 15/15 Retail source tables 100% matched down to the byte. | **PASS** |
| **Gate 10** | Schema-Driven Foreign Key Integrity | 45 physical FK constraints from `information_schema` | All 45 constraints verified with 0 orphan records on staging. | **PASS** |

---

## 12. Remaining Realistic Risks & Production Authorization Gate

### 12.1 Remaining Operational Risks & Safeguards
1. **Unforeseen Power Loss:** Mitigated by InnoDB atomic transaction. MySQL automatically rolls back uncommitted rows upon crash recovery.
2. **Concurrent Web Requests:** Mitigated by placing application in maintenance mode (`php artisan down`) and pausing queues prior to execution.
3. **Operator Typo:** Mitigated by the single verified CLI command: `php artisan battery:migrate-from-retail --force`.

### 12.2 Mandatory Production Authorization Gate
```
########################################################################################
#                    MANDATORY HUMAN AUTHORIZATION GATE                                #
########################################################################################
#                                                                                      #
#   1. PRODUCTION MIGRATION STATUS : NOT EXECUTED                                      #
#   2. PRODUCTION DATABASE STATE   : UNMODIFIED (21 BATTERY TABLES = 0 ROWS)           #
#   3. SOURCE RETAIL DATA          : 100% UNTOUCHED (15/15 SHA-256 MATCH)              #
#   4. ALL 10 PRE-MIGRATION GATES  : 100% COMPLETE AND PASS                            #
#   5. FINANCIAL VARIANCE          : EXACTLY ৳0.00 ZERO VARIANCE                       #
#                                                                                      #
#   LIVE EXECUTION REQUIRES SEPARATE, EXPLICIT HUMAN AUTHORIZATION IN CHAT.            #
#   THE AGENT WILL NOT PROCEED TO LIVE EXECUTION AUTONOMOUSLY.                         #
#                                                                                      #
########################################################################################
```

### Exact Ready Runbook (Pending User Approval)
```powershell
# 1. Engage Maintenance Mode
php artisan down --secret="live-migration-gate-auth"

# 2. Pause Background Queues
php artisan queue:pause default
php artisan queue:restart

# 3. Create Immediate Live Pre-Migration Hardened Backup
mysqldump --host=127.0.0.1 --port=3306 --user=root --password="" --default-character-set=utf8mb4 --single-transaction --quick --routines --triggers --events --result-file="storage/app/backups/marsscorpdb_live_pre_exec_$(Get-Date -Format 'yyyyMMdd_HHmmss').sql" marsscorpdb

# 4. Execute Controlled Live Migration
php artisan battery:migrate-from-retail --force

# 5. Run Post-Migration Verification Queries (Q01 - Q15)
# 6. Resume Queues & Exit Maintenance Mode
php artisan queue:continue default
php artisan up
```
