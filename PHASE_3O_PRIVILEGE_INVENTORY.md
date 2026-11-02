# PHASE 3O: COMPLETE MYSQL 8.4.3 PRIVILEGE FORENSIC AUDIT (READ-ONLY)

**Project:** MARSS Corporation Retail Management System → Dedicated Battery Module  
**Repository:** `marsscorp-retailshop-mgm`  
**Host Environment:** Windows Server / Win64, MySQL 8.4.3 Community Server (`127.0.0.1:3306`), PHP 8.3.30, Laravel 12.64.0  
**Audit Target:** Production Server Accounts & Privilege Inventory  
**Audit Scope:** STRICTLY READ-ONLY (Zero user/grant modifications)  
**Date:** 2026-11-03  
**Status:** **`HOLD — LIVE MIGRATION NOT AUTHORIZED`**  

---

## 1. Executive Summary

This forensic inventory inspects all MySQL user accounts, global grants, database-level permissions, table-level grants, column-level grants, stored routine execution contexts, and role configurations on the MySQL 8.4.3 Community Server powering MARSS Corporation.

### Key Architectural Finding
On the production server:
* Laravel connects to MySQL using the account **`root`@`localhost`** with an empty password (`DB_USERNAME=root` in `.env`).
* There is **no separate dedicated `marss_app` user** defined in MySQL on this host.
* **`root`@`localhost`** holds comprehensive global static and dynamic administrative privileges on `*.*` with `GRANT OPTION`.
* **Zero roles** (`mysql.role_edges = 0`, `mysql.default_roles = 0`) and zero database-level grants (`mysql.db = 0` for `marsscorpdb`) exist.
* **Crucial Implication:** Because the application operates as a globally privileged user (`*.*`), issuing `REVOKE INSERT, UPDATE, DELETE ON marsscorpdb.* FROM 'root'@'localhost'` **does not block writes**! MySQL privilege evaluation checks global grants first; if a user holds global `UPDATE` on `*.*`, MySQL allows the write without even evaluating database-level rules.
* **Resolution:** Complete writer isolation on this host requires either:
  1. Temporary account locking (`ALTER USER ... ACCOUNT LOCK`) coupled with dedicated migration credentials.
  2. Or deploying a properly architected least-privilege application account (`marss_app`@`localhost`) with database-level grants only.

---

## 2. Complete MySQL Account & Privilege Inventory

Data extracted read-only via [`scratch/phase_3o/audit_production_privileges.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/scratch/phase_3o/audit_production_privileges.php):

| Account | Host | Global Write | DB Write (`marsscorpdb`) | Table Write | Column Write | Roles Assigned | Effective Write Risk to `marsscorpdb` |
|:---|:---|:---:|:---:|:---:|:---:|:---:|:---|
| `root` | `localhost` | **YES** (`*.*`) | Inherited via Global | None Specific | None Specific | None | **CRITICAL / ADMINISTRATIVE** (Used by Laravel `.env`) |
| `mysql.infoschema` | `localhost` | NO | NO | NO | NO | None | **SAFE** (Locked system account; internal dictionary queries) |
| `mysql.session` | `localhost` | NO | NO | NO | NO | None | **SAFE** (Locked system account; read-only performance_schema) |
| `mysql.sys` | `localhost` | NO | NO | NO | NO | None | **SAFE** (Locked system account; sys schema maintenance) |

---

## 3. Effective Privilege Analysis & Grant Statements

### 3.1 `root`@`localhost`
* **Static Privileges:**
  ```sql
  GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, RELOAD, SHUTDOWN, PROCESS, FILE, REFERENCES, INDEX, ALTER, SHOW DATABASES, SUPER, CREATE TEMPORARY TABLES, LOCK TABLES, EXECUTE, REPLICATION SLAVE, REPLICATION CLIENT, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, CREATE USER, EVENT, TRIGGER, CREATE TABLESPACE, CREATE ROLE, DROP ROLE ON *.* TO `root`@`localhost` WITH GRANT OPTION;
  ```
* **Dynamic Privileges (MySQL 8.4):**
  ```sql
  GRANT ALLOW_NONEXISTENT_DEFINER, APPLICATION_PASSWORD_ADMIN, AUDIT_ABORT_EXEMPT, AUDIT_ADMIN, AUTHENTICATION_POLICY_ADMIN, BACKUP_ADMIN, BINLOG_ADMIN, BINLOG_ENCRYPTION_ADMIN, CLONE_ADMIN, CONNECTION_ADMIN, ENCRYPTION_KEY_ADMIN, FIREWALL_EXEMPT, FLUSH_OPTIMIZER_COSTS, FLUSH_PRIVILEGES, FLUSH_STATUS, FLUSH_TABLES, FLUSH_USER_RESOURCES, GROUP_REPLICATION_ADMIN, GROUP_REPLICATION_STREAM, INNODB_REDO_LOG_ARCHIVE, INNODB_REDO_LOG_ENABLE, OPTIMIZE_LOCAL_TABLE, PASSWORDLESS_USER_ADMIN, PERSIST_RO_VARIABLES_ADMIN, REPLICATION_APPLIER, REPLICATION_SLAVE_ADMIN, RESOURCE_GROUP_ADMIN, RESOURCE_GROUP_USER, ROLE_ADMIN, SENSITIVE_VARIABLES_OBSERVER, SERVICE_CONNECTION_ADMIN, SESSION_VARIABLES_ADMIN, SET_ANY_DEFINER, SHOW_ROUTINE, SYSTEM_USER, SYSTEM_VARIABLES_ADMIN, TABLE_ENCRYPTION_ADMIN, TELEMETRY_LOG_ADMIN, TRANSACTION_GTID_TAG, XA_RECOVER_ADMIN ON *.* TO `root`@`localhost` WITH GRANT OPTION;
  ```
* **Effective Privilege Path:** Direct global grant on `*.*`.
* **Vulnerability Identified:** Any connection authenticating as `root` bypasses all database-level `REVOKE` statements.

### 3.2 System Internal Accounts (`mysql.infoschema`, `mysql.session`, `mysql.sys`)
All three accounts have `account_locked = 'Y'`. They cannot be used to establish external client sessions or execute writes to `marsscorpdb`.

---

## 4. Metadata Catalog Audit Findings

1. `mysql.db`: Zero entries for `marsscorpdb`. No database-specific grants exist.
2. `mysql.tables_priv`: Contains entries only for `mysql.session` (`user` table) and `mysql.sys` (`sys_config` table). Zero custom table grants.
3. `mysql.columns_priv`: Zero rows.
4. `mysql.procs_priv`: Zero rows.
5. `mysql.role_edges` & `mysql.default_roles`: Zero rows. MySQL 8.4 Role-Based Access Control (RBAC) is not actively deployed on this server.
6. `information_schema.SCHEMA_PRIVILEGES`: 0 rows for `marsscorpdb`.

---

## 5. Architectural Recommendation for Production Migration Isolation

Because Laravel uses `root`@`localhost` on this host, attempting a simple database-level `REVOKE` against `root` is ineffective. The production runbook must implement one of two proven isolation strategies:
1. **Strategy 1 (Account Lock & Dedicated Migration User):**
   - Create a temporary, dedicated migration account (`marss_migrator`@`localhost`) with least privilege.
   - Lock `root`@`localhost` (`ALTER USER 'root'@'localhost' ACCOUNT LOCK`) during the execution window, rendering any newly spawned web/artisan threads completely unable to connect.
   - Unlock `root`@`localhost` during Stage E restoration.
2. **Strategy 2 (Deploy Dedicated Application Account Before Migration):**
   - Migrate Laravel `.env` to connect as `marss_app`@`localhost` with database-level grants only (`marsscorpdb.*`).
   - Isolate by revoking `INSERT, UPDATE, DELETE` from `marss_app`.

