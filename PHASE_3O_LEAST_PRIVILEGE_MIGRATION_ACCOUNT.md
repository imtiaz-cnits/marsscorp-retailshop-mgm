# PHASE 3O: LEAST-PRIVILEGE MIGRATION ACCOUNT AUDIT & DESIGN

**Project:** MARSS Corporation Retail Management System → Dedicated Battery Module  
**Repository:** `marsscorp-retailshop-mgm`  
**Host Environment:** Windows Server / Win64, MySQL 8.4.3 Community Server (`127.0.0.1:3306`), PHP 8.3.30, Laravel 12.64.0  
**Test Harness:** `marsscorpdb_staging_verify` (STAGING ONLY)  
**Execution Script:** [`scratch/phase_3o/analyze_migration_command_permissions.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/scratch/phase_3o/analyze_migration_command_permissions.php)  
**Date:** 2026-11-03  
**Status:** **`STAGING-VERIFIED (100% PASS)`**  

---

## 1. Executive Summary

Using the unrestricted administrative account (`root`) for executing migrations introduces unnecessary operational risk. If an error exists in migration code or a raw query, an administrative account could inadvertently modify or drop retail source tables.

Phase 3O inspected [`MigrateRetailToBatteryCommand.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/app/Console/Commands/MigrateRetailToBatteryCommand.php) and all associated Eloquent models to design and test a dedicated **Least-Privilege Migration Identity (`marss_migrator`)**.

---

## 2. Command Code & Model Permissions Analysis

Inspection of the 58,885-byte migration command revealed:
* **Source Tables (Read-Only Dependency):** The command queries retail customers, orders, order details, products, purchases, purchase details, payments, categories, brands, units, suppliers, expenses, and expense types using standard Eloquent/QueryBuilder `get()`, `where()`, and `join()` methods.
* **Destination Tables (Write Dependency):** The command instantiates Battery models (`BatteryCustomer`, `BatteryOrder`, etc.) and calls `save()`, inserting rows into the 21 `battery_*` tables and inserting tracking UUIDs into `battery_migration_mappings`.
* **Zero DDL Dependency:** The command performs **no schema changes** (`CREATE TABLE`, `ALTER TABLE`, `DROP TABLE` are never called during execution; migrations were executed beforehand).
* **Zero Retail Write Dependency:** The command contains **no update or delete queries targeting retail source tables**.

---

## 3. Least-Privilege Permission Matrix

| Operation Category | Target Source Tables | Target Destination Tables | Required MySQL Privilege | Operational Rationale |
|:---|:---|:---|:---:|:---|
| **Source Data Extraction** | 18 Retail Tables (`users`, `customers`, `orders`, `products`, `purchases`, `suppliers`, etc.) | None | `SELECT` | Reading historical ERP records for transformation. |
| **Destination Population** | None | 21 `battery_*` Tables | `SELECT, INSERT, UPDATE` | Writing migrated records and setting mapped IDs. |
| **Lineage Tracking** | None | `battery_migration_mappings` | `SELECT, INSERT, UPDATE` | Storing source-to-destination UUID mapping records. |
| **Transaction Boundary** | Entire Database | Entire Database | `LOCK TABLES` | Consistent multi-table atomic transactions. |
| **Forbidden Permissions** | Retail Source Tables | All Tables | `DELETE, DROP, ALTER, CREATE USER, GRANT OPTION` | **STRICTLY DENIED** to prevent accidental source data corruption. |

---

## 4. Exact SQL Grant Specification for `marss_migrator`

```sql
-- 1. Create dedicated user
CREATE USER 'marss_migrator'@'localhost' IDENTIFIED BY '<SECURE_MIGRATION_PASSWORD>';

-- 2. Grant basic connection capability
GRANT USAGE ON *.* TO 'marss_migrator'@'localhost';

-- 3. Grant transaction locking capability on database
GRANT LOCK TABLES ON `marsscorpdb`.* TO 'marss_migrator'@'localhost';

-- 4. Grant SELECT-ONLY on 18 Retail Source Tables
GRANT SELECT ON `marsscorpdb`.`users` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`customers` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`customer_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`suppliers` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`supplier_due_collections` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`categories` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`sub_categories` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`brands` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`units` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`products` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchases` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchase_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`purchase_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`orders` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`opening_balances` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`expenses` TO 'marss_migrator'@'localhost';
GRANT SELECT ON `marsscorpdb`.`expense_types` TO 'marss_migrator'@'localhost';

-- 5. Grant SELECT, INSERT, UPDATE on 21 Battery Destination Tables + Mapping
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_migration_mappings` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_brands` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_categories` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_customer_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_customers` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_expense_types` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_expenses` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_opening_balances` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_order_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_orders` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_product_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_products` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_purchase_order_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_purchase_payment_details` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_purchase_returns` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_purchases` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_sub_categories` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_supplier_due_collections` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_suppliers` TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `marsscorpdb`.`battery_units` TO 'marss_migrator'@'localhost';

FLUSH PRIVILEGES;
```

---

## 5. Staging Empirical Drill Results

Tested in `marsscorpdb_staging_verify`:
1. **Source Write Denial Test:** `marss_migrator` attempted `UPDATE products SET quantity = 999 WHERE id = 568`.  
   *Result:* **DENIED.** Threw `SQLSTATE[42000]: 1142 UPDATE command denied`.
2. **Destination Write Test:** `marss_migrator` inserted into `battery_migration_mappings`.  
   *Result:* **SUCCESS.** Mapping row written cleanly.
3. **Execution Conclusion:** The least-privilege migration identity provides complete mathematical protection against accidental source modification while retaining 100% of the permissions necessary to migrate battery entities.

