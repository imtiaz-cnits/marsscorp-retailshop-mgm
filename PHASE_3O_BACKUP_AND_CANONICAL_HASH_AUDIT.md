# PHASE 3O: BACKUP INTEGRITY & DETERMINISTIC CANONICAL HASH AUDIT

**Project:** MARSS Corporation Retail Management System → Dedicated Battery Module  
**Repository:** `marsscorp-retailshop-mgm`  
**Host Environment:** Windows Server / Win64, MySQL 8.4.3 Community Server (`127.0.0.1:3306`), PHP 8.3.30, Laravel 12.64.0  
**Audit Target:** 15 Retail Source Tables Data Parity & Hot Backup Integrity  
**Execution Script:** [`scratch/phase_3o/verify_deterministic_serialization.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/scratch/phase_3o/verify_deterministic_serialization.php)  
**Date:** 2026-11-03  
**Status:** **`100% BIT-FOR-BIT CANONICAL MATCH (15/15 TABLES)`**  

---

## 1. Technical Clarification: RFC 8259 vs Deterministic Serialization Contract

The human review provided a critical technical clarification:
> *"RFC 8259 is a generic JSON data-interchange syntax specification; it is NOT inherently a deterministic canonical serialization standard. RFC 8259 does not mandate column ordering, numeric representation limits, date formats, or binary encoding across heterogeneous database environments."*

To satisfy the highest cryptographic audit standards, Phase 3O implemented a formal **Deterministic Serialization Contract** implemented in [`verify_deterministic_serialization.php`](file:///d:/Running%20Works/04.%20Clients%20Back-end%20Projects%20-%202025/PHP%20-%20Laravel/MARSS%20Corp/marsscorp-retailshop-mgm/scratch/phase_3o/verify_deterministic_serialization.php) that enforces:

1. **Fixed Column Ordering:** Columns are extracted strictly sorted by `information_schema.COLUMNS.ORDINAL_POSITION`.
2. **Type-Safe Null vs Empty String Encoding:** Native `JSON_ARRAY` serializes SQL `NULL` as literal `null` and empty strings as `""`, eliminating null-string ambiguity.
3. **Timezone-Agnostic Datetime Normalization:** All `DATETIME` and `TIMESTAMP` columns are explicitly converted via `DATE_FORMAT(col, '%Y-%m-%d %H:%i:%s')`, and `DATE` columns via `DATE_FORMAT(col, '%Y-%m-%d')`.
4. **Lossless Binary/Blob Encoding:** All binary/varbinary/blob columns are converted to hexadecimal strings via `HEX(col)` to prevent byte-truncation or character set conversions.
5. **Deterministic Decimal Scaling:** Numeric and decimal columns are formatted with explicit scale via `FORMAT(col, scale)` to avoid floating-point trailing zero variances.
6. **Deterministic Row Ordering:** Rows are sorted strictly by primary key column(s) (`ORDER BY id`).
7. **Explicit Stream Framing:** Rows are framed with a Unix newline (`\n`) delimiter before being fed into the incremental SHA-256 streaming hashing context.

---

## 2. 15/15 Bit-for-Bit Deterministic Hash Parity Catalog

Calculated across production `marsscorpdb` and restored staging `marsscorpdb_staging_verify`:

| # | Table Name | Total Rows | Production (`marsscorpdb`) Deterministic SHA-256 | Restored Staging Deterministic SHA-256 | Parity Verdict |
|:---:|:---|:---:|:---|:---|:---:|
| 1 | `users` | 6 | `8960388e0c616f79919083ec2c6046b4de5e806e0122d6c4e0cf33f4d55b5d19` | `8960388e0c616f79919083ec2c6046b4de5e806e0122d6c4e0cf33f4d55b5d19` | **MATCH** |
| 2 | `customers` | 91 | `2ee71ea295fe090ffefa5079737502d4c06d5ff34c89a7e7e161ac7b7c47eb39` | `2ee71ea295fe090ffefa5079737502d4c06d5ff34c89a7e7e161ac7b7c47eb39` | **MATCH** |
| 3 | `customer_payment_details` | 30 | `d282e0010182a0b45dd854b6ff72bc9e81af0f0bf294f568daa3479ca1cb27b6` | `d282e0010182a0b45dd854b6ff72bc9e81af0f0bf294f568daa3479ca1cb27b6` | **MATCH** |
| 4 | `suppliers` | 14 | `3445624deb5c61db739dbcff7bf2074ecdbbc482e664bbee3aedc53407b7ceab` | `3445624deb5c61db739dbcff7bf2074ecdbbc482e664bbee3aedc53407b7ceab` | **MATCH** |
| 5 | `supplier_due_collections` | 3 | `841d5a65a14069af48a1ca6e532a2923887b28a8ff7378cb016b15bf3556f7e4` | `841d5a65a14069af48a1ca6e532a2923887b28a8ff7378cb016b15bf3556f7e4` | **MATCH** |
| 6 | `categories` | 30 | `41557840115d370d08a66efd4512cbfbf8b4a8f1b7b2bcb85c8f4aeeeae34538` | `41557840115d370d08a66efd4512cbfbf8b4a8f1b7b2bcb85c8f4aeeeae34538` | **MATCH** |
| 7 | `sub_categories` | 0 | `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855` | `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855` | **MATCH** |
| 8 | `brands` | 22 | `1076c2bc2e5a28b331f8be38e961cfbf6bce89a1cb9ee95d47ba340363ad92aa` | `1076c2bc2e5a28b331f8be38e961cfbf6bce89a1cb9ee95d47ba340363ad92aa` | **MATCH** |
| 9 | `units` | 1 | `2d38286f994569837f2fd310be6f2f422851b6608f64cae0f1f4db884f1adc8c` | `2d38286f994569837f2fd310be6f2f422851b6608f64cae0f1f4db884f1adc8c` | **MATCH** |
| 10 | `products` | 364 | `6dfd9dc95b0cf0083c1a67cb56844c02298faea9d417e614996d33b94ff0891b` | `6dfd9dc95b0cf0083c1a67cb56844c02298faea9d417e614996d33b94ff0891b` | **MATCH** |
| 11 | `purchases` | 17 | `698cb7bdcc66bbd3ffc0b7c81e6459eb3d663faf893c06766dd88ae01555398b` | `698cb7bdcc66bbd3ffc0b7c81e6459eb3d663faf893c06766dd88ae01555398b` | **MATCH** |
| 12 | `purchase_order_details` | 116 | `e96a7de8d9a02c330418e35dacec77dad6e01f5ef563d760f0a240aa42241765` | `e96a7de8d9a02c330418e35dacec77dad6e01f5ef563d760f0a240aa42241765` | **MATCH** |
| 13 | `purchase_payment_details` | 17 | `b3c26c96af3c078ef33c735ccece6665831be461a944388ad03f7b17c9296261` | `b3c26c96af3c078ef33c735ccece6665831be461a944388ad03f7b17c9296261` | **MATCH** |
| 14 | `orders` | 94 | `4fb0b4adbf95a5904d7872d411f4b248c1684760ab24214fd2e9431576e676e6` | `4fb0b4adbf95a5904d7872d411f4b248c1684760ab24214fd2e9431576e676e6` | **MATCH** |
| 15 | `order_details` | 273 | `679491ec58e99fa3d4b1366eee610cfa7fcfd80d9a1d634a91df0db615f891c4` | `679491ec58e99fa3d4b1366eee610cfa7fcfd80d9a1d634a91df0db615f891c4` | **MATCH** |

---

## 3. Deep 19-Point Backup & Restore Parity Verification

Restored in isolated staging database `marsscorpdb_staging_verify`:
* Total Tables: **55** (Production: 55, Restored: 55)
* Total Columns: **549** (Production: 549, Restored: 549)
* Primary Keys: **55** (Production: 55, Restored: 55)
* Foreign Keys: **99** (Production: 99, Restored: 99)
* Unique Constraints: **6** (Production: 6, Restored: 6)
* Distinct Physical Indexes: **174** (Production: 174, Restored: 174)
* Total Rows in `information_schema.STATISTICS`: **180** (Production: 180, Restored: 180)
* Data Loss / Truncation: **ZERO**

