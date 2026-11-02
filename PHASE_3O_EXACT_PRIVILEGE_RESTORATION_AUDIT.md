# PHASE 3O: EXACT PRIVILEGE RESTORATION ENGINE AUDIT

**Project:** MARSS Corporation Retail Management System → Dedicated Battery Module  
**Repository:** `marsscorp-retailshop-mgm`  
**Host Environment:** Windows Server / Win64, MySQL 8.4.3 Community Server (`127.0.0.1:3306`), PHP 8.3.30, Laravel 12.64.0  
**Test Harness:** `marsscorpdb_staging_verify` (STAGING ONLY)  
**Execution Script:** [`scratch/phase_3o/test_exact_privilege_restoration.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/scratch/phase_3o/test_exact_privilege_restoration.php)  
**Date:** 2026-11-03  
**Status:** **`STAGING-VERIFIED (100% PASS)`**  

---

## 1. Executive Summary & Problem Addressed

In Phase 3N, the proposed privilege restoration was hardcoded as:
```sql
GRANT INSERT, UPDATE, DELETE ON `marsscorpdb`.* TO 'marss_app'@'localhost';
```
As correctly highlighted in the human review:
> *"Hardcoded GRANT does not guarantee exact restoration. If the account had EXECUTE, table-level grants, column-level grants, or active roles, a hardcoded grant silently corrupts the application's security posture. Original SHOW GRANTS must be captured, restored verbatim, and verified bit-for-bit."*

In Phase 3O, an **Exact Privilege Restoration Engine** was engineered, tested, and validated in staging across three diverse account architectures:
1. Direct Database + Table-level Account (`test_app_writer`)
2. Role-Based Access Control Account (`test_role_writer` with `role_order_entry`)
3. Global Privileged Account (`test_global_writer` with `*.*` grants)

---

## 2. Experimental Staging Setup & Pre-State Snapshots

The staging drill configured three test accounts representing the full spectrum of MySQL authorization:

### 2.1 Baseline `SHOW GRANTS` Snapshots Captured Before Isolation

* **Account 1: `test_app_writer`@`localhost` (Direct Database + Table Grants):**
  ```sql
  GRANT USAGE ON *.* TO `test_app_writer`@`localhost`
  GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON `marsscorpdb_staging_verify`.* TO `test_app_writer`@`localhost`
  GRANT INDEX ON `marsscorpdb_staging_verify`.`products` TO `test_app_writer`@`localhost`
  ```

* **Account 2: `test_role_writer`@`localhost` (Role-Based Writer with Default Role):**
  ```sql
  GRANT USAGE ON *.* TO `test_role_writer`@`localhost`
  GRANT SELECT ON `marsscorpdb_staging_verify`.* TO `test_role_writer`@`localhost`
  GRANT `role_order_entry`@`%` TO `test_role_writer`@`localhost`
  -- Default Role: role_order_entry (which holds INSERT, UPDATE on orders & order_details)
  ```

* **Account 3: `test_global_writer`@`localhost` (Global Bypass Writer):**
  ```sql
  GRANT SELECT, UPDATE ON *.* TO `test_global_writer`@`localhost`
  ```

---

## 3. Empirical Demonstration of the Global Bypass Flaw

During Step 4 of the staging drill, an attempt was made to isolate `test_global_writer` using a standard database-level revoke:
```sql
REVOKE UPDATE ON `marsscorpdb_staging_verify`.* FROM 'test_global_writer'@'localhost';
```
* **Observed MySQL Engine Error:**
  `SQLSTATE[42000]: 1141 There is no such grant defined for user 'test_global_writer' on host 'localhost'`
* **Write Capability Test:** `test_global_writer` established a new PDO connection and executed `UPDATE products SET quantity = quantity WHERE id = 568`.
* **Empirical Outcome:** **WRITE WAS PERMITTED.**
* **Conclusion:** This empirically confirms that database-level revocation is completely bypassed by global privileges. Global writers must be isolated via `ALTER USER ... ACCOUNT LOCK` or global privilege revocation.

---

## 4. Tailored Isolation Execution Results

| Account | Grant Level | Applied Isolation Mechanism | Write Attempt Result | Error Caught |
|:---|:---|:---|:---:|:---|
| `test_app_writer` | DB + Table | `REVOKE INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.*` | **DENIED** | `SQLSTATE[42000]: 1142 UPDATE command denied` |
| `test_role_writer` | Role-Derived | `REVOKE 'role_order_entry' FROM 'test_role_writer'` | **DENIED** | `SQLSTATE[42000]: 1142 UPDATE command denied` |
| `test_global_writer` | Global (`*.*`) | `ALTER USER 'test_global_writer'@'localhost' ACCOUNT LOCK` | **DENIED** | `SQLSTATE[HY000]: 3118 Access denied (Account Locked)` |

---

## 5. Exact Restoration Engine & Verification Results

The restoration engine parsed the original baseline snapshot JSON and executed the exact inverse grant/unlock commands:

1. **Restoration of `test_app_writer`:**
   ```sql
   GRANT INSERT, UPDATE, DELETE ON `marsscorpdb_staging_verify`.* TO 'test_app_writer'@'localhost';
   FLUSH PRIVILEGES;
   ```
2. **Restoration of `test_role_writer`:**
   ```sql
   GRANT 'role_order_entry' TO 'test_role_writer'@'localhost';
   SET DEFAULT ROLE 'role_order_entry' TO 'test_role_writer'@'localhost';
   FLUSH PRIVILEGES;
   ```
3. **Restoration of `test_global_writer`:**
   ```sql
   ALTER USER 'test_global_writer'@'localhost' ACCOUNT UNLOCK;
   FLUSH PRIVILEGES;
   ```

### 5.1 Bit-for-Bit Before/After Comparison

Post-restoration `SHOW GRANTS` statements were captured and compared side-by-side with the pre-isolation baseline:

```
test_app_writer Match  : PASS (100% BIT-FOR-BIT IDENTICAL)
test_role_writer Match : PASS (100% BIT-FOR-BIT IDENTICAL - Roles & Default Roles Preserved)
test_global_writer Match: PASS (100% BIT-FOR-BIT IDENTICAL - Account Unlocked & Global Writes Active)
```

**Audit Verdict:**
The Exact Privilege Restoration Engine successfully reconstructs and validates the precise original authorization state. Zero privilege omission, zero privilege escalation, zero configuration drift.

