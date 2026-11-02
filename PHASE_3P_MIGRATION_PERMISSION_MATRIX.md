# PHASE 3P — Least-Privilege Migration Permission Matrix & `LOCK TABLES` Elimination Audit (Final Corrected)

**Project:** MARSS Corporation Retail Management System → Battery Module Migration  
**Target Environment:** Windows Server / MySQL 8.4.3 / PHP 8.3.30 / Laravel 12.64.0  
**Phase:** 3P — Final Operational Closure  
**Status:** COMPLETE & VERIFIED  

---

## 1. Executive Summary & Elimination of `LOCK TABLES`

### 1.1 The `LOCK TABLES` Hazard in MySQL
In Phase 3O, the permission matrix granted `LOCK TABLES` to the migration operator account. In-depth engine forensics conducted in Phase 3P revealed that granting `LOCK TABLES` is not only completely unnecessary, but actively dangerous in MySQL:
1. **Implicit Commit Behavior:** According to MySQL 8.4 Reference Manual (§15.3.3 Statements That Cause an Implicit Commit), issuing an explicit `LOCK TABLES` statement **implicitly commits any active transaction** before acquiring the lock.
2. **Transaction Integrity Hazard:** If an application command relies on `DB::beginTransaction()`, any intermediate call to `LOCK TABLES` silently commits the partial transaction. If an exception subsequently occurs, `DB::rollBack()` cannot reverse the committed statements, resulting in irreversible database corruption.
3. **InnoDB Row-Level Locking:** `MigrateRetailToBatteryCommand` relies exclusively on InnoDB standard ACID transactions (`DB::beginTransaction()`, `DB::commit()`, `DB::rollBack()`). InnoDB automatically manages row-level locks and gap locks without requiring table locks.

### 1.2 Command Source Code Audit
Script `scratch/phase_3p/audit_lock_tables.php` performed an AST and regex inspection of [`MigrateRetailToBatteryCommand.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/app/Console/Commands/MigrateRetailToBatteryCommand.php):
- **Raw SQL `LOCK TABLES` statements found:** **0**
- **Schema / DB Facade lock methods found:** **0**
- **Explicit table lock calls found:** **0**
- **Transactional calls found:** `DB::beginTransaction()` (line 122), `DB::commit()` (line 218), `DB::rollBack()` (line 232).

**Conclusion:** `LOCK TABLES` is 100% eliminated from the migration user grant specification.

---

## 2. Table-by-Table Privilege Specification

The migration operator identity (`marss_migrator`) is granted the absolute minimum privileges required to execute and verify the migration.

### 2.1 Source Retail Tables (18 Tables) — Strictly Read-Only (`SELECT`)
Under no circumstances may the migration user execute `INSERT`, `UPDATE`, `DELETE`, `DROP`, or `ALTER` on any retail source table.

| # | Source Table Name | Granted Privileges | Prohibited Operations | Verification Status |
| :-: | :--- | :--- | :--- | :---: |
| 1 | `categories` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 2 | `brands` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 3 | `units` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 4 | `expense_types` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 5 | `suppliers` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 6 | `customers` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 7 | `products` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 8 | `expenses` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 9 | `purchases` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 10 | `purchase_order_details` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 11 | `purchase_payment_details` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 12 | `purchase_returns` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 13 | `orders` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 14 | `order_details` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 15 | `order_payment_details` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 16 | `product_returns` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |
| 17 | `customer_payment_details` | `SELECT` | `INSERT, UPDATE, DELETE` | Enforced (Error 1142) |

*(Note: Table `purchase_return_details` does not exist in the retail ERP schema and is omitted).*

### 2.2 Target Battery Tables (21 Tables) — Isolated Write (`SELECT, INSERT, UPDATE, DELETE`)
The migration operator possesses standard DML privileges to write records and support transactional rollback if an abort occurs.

| # | Target Table Name | Granted Privileges | Purpose in Migration |
| :-: | :--- | :--- | :--- |
| 1 | `battery_categories` | `SELECT, INSERT, UPDATE, DELETE` | Master catalog creation |
| 2 | `battery_brands` | `SELECT, INSERT, UPDATE, DELETE` | Master catalog creation |
| 3 | `battery_units` | `SELECT, INSERT, UPDATE, DELETE` | Master catalog creation |
| 4 | `battery_expense_types` | `SELECT, INSERT, UPDATE, DELETE` | Master catalog creation |
| 5 | `battery_sub_categories` | `SELECT, INSERT, UPDATE, DELETE` | Master catalog creation |
| 6 | `battery_suppliers` | `SELECT, INSERT, UPDATE, DELETE` | Supplier entity migration |
| 7 | `battery_customers` | `SELECT, INSERT, UPDATE, DELETE` | Customer entity migration |
| 8 | `battery_products` | `SELECT, INSERT, UPDATE, DELETE` | Product migration & stock tracking |
| 9 | `battery_expenses` | `SELECT, INSERT, UPDATE, DELETE` | Pure battery expenses |
| 10 | `battery_purchases` | `SELECT, INSERT, UPDATE, DELETE` | Purchase records |
| 11 | `battery_purchase_order_details` | `SELECT, INSERT, UPDATE, DELETE` | Purchase line items |
| 12 | `battery_purchase_payment_details` | `SELECT, INSERT, UPDATE, DELETE` | Purchase payment allocations |
| 13 | `battery_purchase_returns` | `SELECT, INSERT, UPDATE, DELETE` | Purchase return tracking |
| 14 | `battery_orders` | `SELECT, INSERT, UPDATE, DELETE` | Sales order records |
| 15 | `battery_order_details` | `SELECT, INSERT, UPDATE, DELETE` | Sales line items |
| 16 | `battery_order_payment_details` | `SELECT, INSERT, UPDATE, DELETE` | Order payment allocations |
| 17 | `battery_product_returns` | `SELECT, INSERT, UPDATE, DELETE` | Sales return tracking |
| 18 | `battery_customer_payment_details` | `SELECT, INSERT, UPDATE, DELETE` | Customer due collections |
| 19 | `battery_supplier_due_collections` | `SELECT, INSERT, UPDATE, DELETE` | Supplier due payments |
| 20 | `battery_opening_balances` | `SELECT, INSERT, UPDATE, DELETE` | Opening balance audits |
| 21 | `battery_migration_mappings` | `SELECT, INSERT, UPDATE, DELETE` | DAG lineage & rollback audit log |

---

## 3. Account Provisioning SQL DDL

The exact DDL script used to provision `marss_migrator` at runtime:

```sql
-- Step 1: Create user with cryptographically generated 64-char hex password
CREATE USER IF NOT EXISTS 'marss_migrator'@'localhost' IDENTIFIED BY '<DYNAMIC_64_CHAR_HEX>';
ALTER USER 'marss_migrator'@'localhost' IDENTIFIED BY '<DYNAMIC_64_CHAR_HEX>';

-- Step 2: Revoke all baseline privileges and flush
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'marss_migrator'@'localhost';
GRANT USAGE ON *.* TO 'marss_migrator'@'localhost';

-- Step 3: Grant SELECT on Retail Source Tables (17 physical tables)
GRANT SELECT ON `marsscorpdb`.`categories` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`brands` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`units` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`expense_types` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`suppliers` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`customers` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`products` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`expenses` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchases` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchase_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchase_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchase_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`orders` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`order_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`product_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`customer_payment_details` TO 'marss_migrator'@'localhost';

-- Step 4: Grant CRUD on 21 Target Battery Tables + Mappings
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_categories` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_brands` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_units` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_expense_types` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_sub_categories` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_suppliers` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_customers` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_products` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_expenses` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_purchases` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_purchase_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_purchase_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_purchase_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_orders` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_order_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_product_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_customer_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_supplier_due_collections` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_opening_balances` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb`.`battery_migration_mappings` TO 'marss_migrator'@'localhost';

FLUSH PRIVILEGES;
```

---

## 4. Empirical Security Verification

During execution in staging (`scratch/phase_3p/consolidated_staging_validation.ps1`):
1. **Unauthorized Write Probe:** Attempted `INSERT INTO orders` under `marss_migrator`.  
   **Result:** `SQLSTATE[42000]: 1142 INSERT command denied to user 'marss_migrator'@'localhost' for table 'orders'`. **PASS.**
2. **Unauthorized Table Lock Probe:** Attempted `LOCK TABLES orders WRITE` under `marss_migrator`.  
   **Result:** `SQLSTATE[42000]: 1142 LOCK TABLES command denied to user 'marss_migrator'@'localhost' for table 'orders'`. **PASS.**
3. **Legitimate Battery Write:** Successfully inserted and updated battery records and mappings. **PASS.**
4. **Command Execution:** Executed `battery:migrate-from-retail --force` to 100% completion with exit code 0. **PASS.**
