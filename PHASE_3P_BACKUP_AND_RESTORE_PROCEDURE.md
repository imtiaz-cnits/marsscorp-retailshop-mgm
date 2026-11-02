# PHASE 3P — Fresh Backup & Restore Pipeline Drill Audit

**Project:** MARSS Corporation Retail Management System → Battery Module Migration  
**Target Environment:** Windows Server / MySQL 8.4.3 / PHP 8.3.30 / Laravel 12.64.0  
**Phase:** 3P — Workstream D  
**Status:** COMPLETE & VERIFIED  

---

## 1. Executive Summary & Defect Resolution (DEF-04)

### 1.1 Defect Analysis in Phase 3O
In Phase 3O, canonical row hashing was verified, but a fresh physical backup dump and subsequent end-to-end restore drill into a clean, disposable database were not executed synchronously within the session. Without physical restoration verification, there is no empirical guarantee that the dump file can be restored without syntax errors, missing routines, or corrupted character sets.

### 1.2 Phase 3P Drill Execution
Phase 3P conducted a comprehensive physical backup and restoration drill using script `scratch/phase_3p/test_backup_restore_pipeline.php`:
1. Generated a fresh, native `mysqldump` from the production database `marsscorpdb`.
2. Verified exit code, file non-emptiness, dump completion trailer, and cryptographic SHA-256 hash.
3. Created a brand-new, clean database `marsscorpdb_p3p_restore_test`.
4. Restored the dump file using the native MySQL client CLI.
5. Executed rigorous schema parity, index parity, foreign key parity, canonical row hash parity, and financial baseline verification.
6. Dropped the disposable database cleanly.

---

## 2. Native `mysqldump` Parameters & Output Proofs

### 2.1 The Hardened Execution Command
To prevent Windows shell encoding corruption (UTF-16LE / BOM) and guarantee transaction consistency without locking the tables, `mysqldump` must always be executed using `--result-file`:

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqldump.exe" `
    -h 127.0.0.1 -P 3306 -u root `
    --single-transaction `
    --quick `
    --no-autocommit `
    --routines `
    --triggers `
    --hex-blob `
    --result-file="D:\Running Works\04. Clients Back-end Projects - 2025\PHP - Laravel\MARSS Corp\marsscorp-retailshop-mgm\storage\app\backups\pre_migration_marsscorpdb_20261103.sql" `
    marsscorpdb
```

### 2.2 Backup Verification Metrics
- **Process Exit Code:** `0` (PASS)
- **Dump File Size:** `255,118` bytes (PASS, $> 0$)
- **Trailer Integrity Check:** Final 1,024 bytes inspected; contains `-- Dump completed on 2026-11-03 03:46:29` (PASS)
- **Cryptographic Checksum:**
  $$\text{SHA-256}(\text{Dump File}) = \mathtt{51cf84549d7260760f567238bf12285a7d391788510d1d649d307501fb3e9c10}$$

---

## 3. Physical Database Restoration Drill

### 3.1 Restoration Execution
The dump was piped into a freshly initialized database `marsscorpdb_p3p_restore_test` using native Windows CLI:

```cmd
mysql.exe -h 127.0.0.1 -P 3306 -u root marsscorpdb_p3p_restore_test < p3p_pipeline_test.sql
```
- **Restore Exit Code:** `0` (PASS)

---

## 4. Deep Structural & Mathematical Reconciliation

### 4.1 Schema Parity Analysis
Every metadata structure in `information_schema` was compared between `marsscorpdb` (Source) and `marsscorpdb_p3p_restore_test` (Restored Target):

| Structural Element | Source (`marsscorpdb`) | Target (`restore_test`) | Delta | Parity Status |
| :--- | :---: | :---: | :---: | :---: |
| **Total Tables** | 55 | 55 | 0 | **PASS (100%)** |
| **Total Columns** | 549 | 549 | 0 | **PASS (100%)** |
| **Primary Keys** | 55 | 55 | 0 | **PASS (100%)** |
| **Foreign Key Constraints** | 45 (99 column entries) | 45 (99 column entries) | 0 | **PASS (100%)** |
| **Total Indexes** | 174 distinct (180 entries) | 174 distinct (180 entries) | 0 | **PASS (100%)** |

### 4.2 Canonical Row Hashing (15 Source Retail Tables)
To prove zero data loss and exact byte-level restoration, canonical row hashes were computed across both databases using:
$$\text{Hash}(T) = \text{SHA2}\left(\text{GROUP\_CONCAT}\left(\text{SHA2}\left(\text{CONCAT\_WS}(\text{'#'}, c_1, \dots, c_k), 256\right) \text{ ORDER BY id SEPARATOR ''}\right), 256\right)$$

| # | Source Retail Table | Source Hash (Prefix) | Restored Hash (Prefix) | Parity Status |
| :-: | :--- | :--- | :--- | :---: |
| 1 | `categories` | `c7caf46a00fb227b...` | `c7caf46a00fb227b...` | **MATCH** |
| 2 | `brands` | `797cc4340b321128...` | `797cc4340b321128...` | **MATCH** |
| 3 | `units` | `41a4f2bbf47da563...` | `41a4f2bbf47da563...` | **MATCH** |
| 4 | `expense_types` | `26da8e7a752a56af...` | `26da8e7a752a56af...` | **MATCH** |
| 5 | `suppliers` | `eaa4261d6041efd6...` | `eaa4261d6041efd6...` | **MATCH** |
| 6 | `customers` | `450fd6888ff7d93f...` | `450fd6888ff7d93f...` | **MATCH** |
| 7 | `products` | `738190a0f1ba6b46...` | `738190a0f1ba6b46...` | **MATCH** |
| 8 | `expenses` | `d6dae381a4d045c8...` | `d6dae381a4d045c8...` | **MATCH** |
| 9 | `purchases` | `f6ea1f368f6c948d...` | `f6ea1f368f6c948d...` | **MATCH** |
| 10 | `purchase_order_details` | `6a06f88c2ef8f6d8...` | `6a06f88c2ef8f6d8...` | **MATCH** |
| 11 | `purchase_payment_details` | `5c05b6961779be26...` | `5c05b6961779be26...` | **MATCH** |
| 12 | `orders` | `a39d6800f22dea72...` | `a39d6800f22dea72...` | **MATCH** |
| 13 | `order_details` | `77564c6da0983ec9...` | `77564c6da0983ec9...` | **MATCH** |
| 14 | `order_payment_details` | `3b30fae80d57f4cc...` | `3b30fae80d57f4cc...` | **MATCH** |
| 15 | `customer_payment_details` | `72d5d1fe68321f03...` | `72d5d1fe68321f03...` | **MATCH** |

### 4.3 Financial Baseline Verification on Restored Target
Direct SQL queries on `marsscorpdb_p3p_restore_test` confirmed that critical financial balances are intact:
- **Nur Battery Customer Previous Due (ID: 2):** ৳467,465.00 (Expected: ৳467,465.00) -> **PASS**
- **Riyaz Customer Previous Due (ID: 5):** ৳23,592.00 (Expected: ৳23,592.00) -> **PASS**
- **Order #53 Due (ID: 53):** ৳37,674.00 (Expected: ৳37,674.00) -> **PASS**
- **Polo Battery Supplier Payable (ID: 1):** ৳7,360.00 (Expected: ৳7,360.00) -> **PASS**
- **Purchase #15 Due (ID: 15):** ৳108,000.00 (Expected: ৳108,000.00) -> **PASS**

---

## 5. Architectural Acceptance Gate Verification

| Requirement ID | Specification | Status | Evidence |
| :--- | :--- | :--- | :--- |
| **BKP-01** | Native mysqldump with `--result-file` and zero locks | **PASS** | Size: 255,118 bytes, Exit Code: 0 |
| **BKP-02** | Dump file trailer integrity validated | **PASS** | `-- Dump completed on ...` verified |
| **BKP-03** | Physical restoration into fresh database | **PASS** | Restored into `marsscorpdb_p3p_restore_test` with exit code 0 |
| **BKP-04** | Complete schema, PK, FK, and index parity | **PASS** | 55 tables, 549 columns, 45 FKs, 174 indexes identical |
| **BKP-05** | Canonical SHA-256 hash parity across 15 source tables | **PASS** | 15/15 source tables match byte-for-byte |
| **BKP-06** | Financial baseline values verified in restored target | **PASS** | 100% mathematical reconciliation |

