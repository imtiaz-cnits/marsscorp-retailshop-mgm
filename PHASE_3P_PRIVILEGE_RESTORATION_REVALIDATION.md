# PHASE 3P — Exact Privilege Restoration Re-Validation Audit

**Project:** MARSS Corporation Retail Management System → Battery Module Migration  
**Target Environment:** Windows Server / MySQL 8.4.3 / PHP 8.3.30 / Laravel 12.64.0  
**Phase:** 3P — Workstream C  
**Status:** COMPLETE & VERIFIED  

---

## 1. Executive Summary & Defect Resolution (DEF-03)

### 1.1 Defect Analysis in Phase 3O
In Phase 3O, the privilege restoration mechanism was tested in a separate script (`restore_exact_grants.php`), but the final runbook contained hardcoded `GRANT ALL PRIVILEGES` statements. Hardcoding grants violates the least-privilege principle and risks granting excessive privileges or failing to restore granular column-level, table-level, or role-based grants.

### 1.2 Phase 3P Restoration Principle
Phase 3P establishes a mathematical, automated restoration mechanism:
1. **Dynamic Capture:** Before any privilege revocation or account modification occurs, the DBA script executes `SHOW GRANTS FOR '<user>'@'<host>'`.
2. **Normalized Persistence:** The exact statements returned by MySQL are captured in memory and written to a secure timestamped JSON snapshot file (`storage/app/mysql_grants_snapshot_<timestamp>.json`).
3. **Automated Re-Application:** During post-migration restoration (or failure abort recovery), the snapshot file is parsed, and each original statement is re-executed sequentially.
4. **Cryptographic & Character-Level Verification:** After re-application, `SHOW GRANTS` is queried again. The baseline statements array and the restored statements array are compared:
   $$\text{Baseline Array} \equiv \text{Restored Array}$$
   If any discrepancy exists, the gate halts immediately.

---

## 2. Test Matrix Across 8 Distinct Account Types

Script `scratch/phase_3p/test_privilege_restoration.php` created, isolated, restored, and verified 8 distinct MySQL account architectures:

| # | Account Archetype | User Identity | Baseline Grants Captured | Revocation Action | Restored Grants | String Parity |
| :-: | :--- | :--- | :--- | :--- | :--- | :---: |
| 1 | **Database-Level Writer** | `p3p_t1_dbwriter` | `GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb.*` | `REVOKE INSERT, UPDATE, DELETE` | Exact match | **PASS (100%)** |
| 2 | **Table-Level Writer** | `p3p_t2_tblwriter` | `GRANT INSERT, UPDATE, DELETE ON marsscorpdb.orders` | `REVOKE INSERT, UPDATE, DELETE ON orders` | Exact match | **PASS (100%)** |
| 3 | **Column-Level Writer** | `p3p_t3_colwriter` | `GRANT UPDATE (due_amount) ON marsscorpdb.orders` | `REVOKE UPDATE (due_amount)` | Exact match | **PASS (100%)** |
| 4 | **Role-Derived Privileges** | `p3p_t4_rolederived` | `GRANT 'p3p_test_role'@'%'` + table insert | `REVOKE INSERT ON orders` | Exact match | **PASS (100%)** |
| 5 | **Global Privileges** | `p3p_t5_global` | `GRANT PROCESS, RELOAD ON *.*` + db select, insert | `REVOKE INSERT ON db` | Exact match | **PASS (100%)** |
| 6 | **Grant Option Holder** | `p3p_t6_grantopt` | `GRANT SELECT, INSERT ... WITH GRANT OPTION` | `REVOKE INSERT` | Exact match | **PASS (100%)** |
| 7 | **Read-Only Auditor** | `p3p_t7_readonly` | `GRANT SELECT ON marsscorpdb.*` | None revoked (control) | Exact match | **PASS (100%)** |
| 8 | **Migration Service Account** | `p3p_t8_migrator` | `GRANT SELECT ON orders; GRANT SELECT, INSERT, UPDATE ON battery_products` | `REVOKE INSERT, UPDATE ON battery_products` | Exact match | **PASS (100%)** |

---

## 3. Detailed Account Traces & Proofs

### Account 1: Database-Level Writer (`p3p_t1_dbwriter`)
- **Baseline Grants:**
  ```sql
  GRANT USAGE ON *.* TO `p3p_t1_dbwriter`@`localhost`;
  GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb_staging_verify`.* TO `p3p_t1_dbwriter`@`localhost`;
  ```
- **Post-Restoration Grants:**
  ```sql
  GRANT USAGE ON *.* TO `p3p_t1_dbwriter`@`localhost`;
  GRANT SELECT, INSERT, UPDATE, DELETE ON `marsscorpdb_staging_verify`.* TO `p3p_t1_dbwriter`@`localhost`;
  ```
- **Parity Status:** Identical 2 statements. **PASS.**

### Account 2: Table-Level Writer (`p3p_t2_tblwriter`)
- **Baseline Grants:**
  ```sql
  GRANT USAGE ON *.* TO `p3p_t2_tblwriter`@`localhost`;
  GRANT SELECT ON `marsscorpdb_staging_verify`.* TO `p3p_t2_tblwriter`@`localhost`;
  GRANT INSERT, UPDATE, DELETE ON `marsscorpdb_staging_verify`.`orders` TO `p3p_t2_tblwriter`@`localhost`;
  ```
- **Post-Restoration Grants:** Identical 3 statements. **PASS.**

### Account 3: Column-Level Writer (`p3p_t3_colwriter`)
- **Baseline Grants:**
  ```sql
  GRANT USAGE ON *.* TO `p3p_t3_colwriter`@`localhost`;
  GRANT SELECT ON `marsscorpdb_staging_verify`.* TO `p3p_t3_colwriter`@`localhost`;
  GRANT UPDATE (`due_amount`) ON `marsscorpdb_staging_verify`.`orders` TO `p3p_t3_colwriter`@`localhost`;
  ```
- **Post-Restoration Grants:** Identical 3 statements. **PASS.**

### Account 4: Role-Derived Privileges (`p3p_t4_rolederived`)
- **Baseline Grants:**
  ```sql
  GRANT USAGE ON *.* TO `p3p_t4_rolederived`@`localhost`;
  GRANT `p3p_test_role`@`%` TO `p3p_t4_rolederived`@`localhost`;
  GRANT INSERT ON `marsscorpdb_staging_verify`.`orders` TO `p3p_t4_rolederived`@`localhost`;
  ```
- **Post-Restoration Grants:** Identical 3 statements. **PASS.**

---

## 4. Failure Scenarios & Edge Cases Tested

### Scenario F1: Syntax Error / Non-Existent Object Handling
- **Simulation:** Injected an intentional grant referencing `marsscorpdb_staging_verify.non_existent_table_xyz`.
- **Engine Response:** PDO caught `SQLSTATE[42S02]: Base table or view not found: 1146 Table 'marsscorpdb_staging_verify.non_existent_table_xyz' doesn't exist`.
- **Runbook Guard:** The restoration engine halts and alerts the operator, preserving previous state without unhandled fatal crashes.

### Scenario F2: Connection Interruption & Idempotent Reconnection
- **Simulation:** Baseline captured on Connection 1; Connection 1 severed; Connection 2 re-established and executed the restoration loop.
- **Engine Response:** Reconnection succeeded; all baseline statements re-executed idempotently.
- **Result:** Post-reconnect `SHOW GRANTS` matched baseline 100%. **PASS.**

---

## 5. Architectural Acceptance Gate Verification

| Requirement ID | Specification | Status | Evidence |
| :--- | :--- | :--- | :--- |
| **REST-01** | Dynamic capture via `SHOW GRANTS` | **PASS** | JSON snapshot generation verified in script |
| **REST-02** | Zero hardcoded `GRANT ALL` in runbook | **PASS** | Runbook dynamically executes captured array |
| **REST-03** | 8 distinct account archetypes verified | **PASS** | All 8 account types restored with 100% parity |
| **REST-04** | Failure resilience and reconnection tested | **PASS** | Scenario F1 and F2 verified in test execution |

