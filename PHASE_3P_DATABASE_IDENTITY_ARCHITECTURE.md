# PHASE 3P — Database Identity & Connection Separation Architecture (Final Corrected)

**Project:** MARSS Corporation Retail Management System → Battery Module Migration  
**Target Environment:** Windows Server / MySQL 8.4.3 / PHP 8.3.30 / Laravel 12.64.0  
**Phase:** 3P — Final Operational Closure  
**Status:** COMPLETE & VERIFIED  

---

## 1. Executive Summary & Production Identity Reality

### 1.1 The Single Production Reality
Production MySQL account inventory and Laravel `.env` configuration confirm the following verified facts:
1. **Application Connection Account:** Laravel connects to MySQL using the account configured in `.env`: `root@localhost`.
2. **Account Non-Existence:** There is **NO `marss_app` account** in production MySQL. Any runbook prescribing `REVOKE ... FROM 'marss_app'` is invalid and cannot be executed against production.
3. **Global Privilege Precedence:** In MySQL 8.4, `root@localhost` holds global administrative privileges (`GRANT ALL PRIVILEGES ON *.* WITH GRANT OPTION`). Under the MySQL privilege evaluation engine, global grants take precedence over database-level grants. Therefore, executing `REVOKE ... ON marsscorpdb.* FROM 'root'@'localhost'` has **zero effect** on restricting root's write capabilities.
4. **Account Lock Consequence:** Executing `ALTER USER 'root'@'localhost' ACCOUNT LOCK` locks out the DBA administration account, terminating backup utilities (`mysqldump`), administrative monitoring, and connection cleanup.

### 1.2 The Unified Identity Architecture
To achieve safe, verified isolation without breaking DBA access or relying on nonexistent accounts, Phase 3P establishes a clean, decoupled **Two-Tier Identity Architecture**:

```
+---------------------------------------------------------------------------------------------------------+
| TIER 1: ADMINISTRATIVE & RECOVERY IDENTITY                                                              |
| Account: root@localhost (Global DBA)                                                                    |
| Role: Backup generation (mysqldump), processlist inspection, connection termination, emergency restore. |
| Ingress Control: Application writer processes isolated at Web Ingress (503) & Queue Drain layers.      |
+---------------------------------------------------------------------------------------------------------+
| TIER 2: TEMPORARY LEAST-PRIVILEGE MIGRATION OPERATOR                                                    |
| Account: marss_migrator@localhost                                                                       |
| Password: Cryptographically generated 64-char Hex (256 bits entropy via RandomNumberGenerator)          |
| Ingress: PowerShell shell-level runtime injection ($env:DB_USERNAME, $env:DB_PASSWORD)                   |
| Privileges: STRICTLY SELECT on 18 Retail tables; CRUD on 21 Battery tables + mappings; ZERO LOCK TABLES |
| Deprovisioning: DROP USER 'marss_migrator'@'localhost' executed immediately post-verification.         |
+---------------------------------------------------------------------------------------------------------+
```

---

## 2. Ingress & Process-Level Writer Isolation Architecture

Because production Laravel connects as `root`, database writer isolation is achieved through **Process & Ingress Barrier Enforcement**:

```mermaid
graph TD
    subgraph "External Ingress Layer"
        HTTP["HTTP Public Web Traffic"]
        SCHED["Windows Task Scheduler / Cron"]
        CLI["Ad-hoc CLI Scripts"]
    end

    subgraph "Ingress Barrier (Application Layer)"
        MAINT["Maintenance Mode (HTTP 503)<br/>Dynamic Ephemeral GUID Secret"]
        QDRAIN["Queue Drain & Shutdown<br/>artisan queue:restart"]
        KILL["Scoped Processlist Cleanse<br/>WHERE db = 'marsscorpdb'"]
    end

    subgraph "Execution Identities (MySQL Engine)"
        DBA["DBA Administration Account<br/>(root@localhost)<br/>Global Privileges: mysqldump, User Mgmt"]
        MIGRATOR["Migration Operator Service Account<br/>(marss_migrator@localhost)<br/>Least Privilege: Retail SELECT, Battery CRUD"]
    end

    subgraph "MySQL Storage Engine (marsscorpdb)"
        RETAIL[("18 Source Retail Tables<br/>(customers, orders, products, etc.)<br/>STRICTLY READ-ONLY")]
        BATTERY[("21 Target Battery Tables<br/>(battery_products, battery_orders, etc.)<br/>TRANSACTIONAL WRITE TARGET")]
        MAPPINGS[("Tracking Audit Table<br/>(battery_migration_mappings)<br/>ATOMIC DAG LINEAGE")]
    end

    HTTP -->|Blocked with 503| MAINT
    SCHED -->|Stopped| QDRAIN
    CLI -->|Terminated| KILL

    DBA -->|1. Native mysqldump| RETAIL
    DBA -->|2. Provision with 64-char Hex Pass| MIGRATOR
    MIGRATOR -->|SELECT ONLY (Enforced Error 1142 on Write)| RETAIL
    MIGRATOR -->|INSERT, UPDATE (Transactional DAG)| BATTERY
    MIGRATOR -->|INSERT, DELETE (Rollback Trace)| MAPPINGS
```

---

## 3. PowerShell Environment Injection Protocol

To execute the migration CLI under `marss_migrator` without touching or modifying the production `.env` file on disk:

```powershell
# 1. Generate 64-character cryptographic hex password
$bytes = New-Object byte[] 32
[System.Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($bytes)
$MIGRATOR_PASS = -join ($bytes | ForEach-Object { "{0:X2}" -f $_ })

# 2. Provision marss_migrator in MySQL via root session
# (DDL grants Retail SELECT, Battery CRUD, zero LOCK TABLES)

# 3. Inject credentials into the current PowerShell process session
$env:DB_DATABASE = "marsscorpdb"
$env:DB_USERNAME = "marss_migrator"
$env:DB_PASSWORD = $MIGRATOR_PASS

# 4. Execute Artisan command
& "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" artisan battery:migrate-from-retail --force

# 5. Clear credentials and deprovision user immediately
Remove-Item env:DB_USERNAME -ErrorAction SilentlyContinue
Remove-Item env:DB_PASSWORD -ErrorAction SilentlyContinue
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -u root -e "DROP USER IF EXISTS 'marss_migrator'@'localhost'; FLUSH PRIVILEGES;"
```

### Empirical Proof
Inspection script `scratch/phase_3p/consolidated_staging_validation.ps1` confirmed:
1. `DB::select("SELECT CURRENT_USER()")[0]->user` evaluated to `marss_migrator@localhost`.
2. Physical `.env` on disk remained completely untouched (`DB_USERNAME=root`).
3. Attempted write to retail table `orders` was blocked by MySQL engine with `SQLSTATE[42000]: 1142 INSERT command denied`.
4. User `marss_migrator` was cleanly dropped post-execution.

---

## 4. Architectural Acceptance Verification

| Requirement ID | Specification | Status | Evidence |
| :--- | :--- | :--- | :--- |
| **ARCH-01** | Production application reality recognized (`root@localhost`) | **PASS** | No nonexistent `marss_app` references in active runbook |
| **ARCH-02** | Zero modification of production `.env` file | **PASS** | Shell-level environment injection verified via runtime inspection |
| **ARCH-03** | Retail tables structurally protected from migration writes | **PASS** | MySQL Error 1142 confirmed on unauthorized retail write attempt |
| **ARCH-04** | Cryptographic credential generation (256 bits entropy) | **PASS** | .NET `RandomNumberGenerator` generates 64-char hex password |
| **ARCH-05** | Administrative recovery path unaffected by application isolation | **PASS** | DBA account maintains distinct session and global administration |
