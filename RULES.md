# MARSS Corp - Retail Shop Management
## Development Standards & Design Consistency Rules (`RULES.md`)

This document establishes the architecture, UI/UX design consistency standards, coding conventions, and domain-specific rules for the **MARSS Corp Retail Shop Management System**. All developers and automated tools must adhere to these guidelines to ensure code quality, maintainability, and visual coherence across all modules.

---

## 1. Technology Stack & Core Dependencies

- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL 8.x (Default DB: `marsscorpdb`)
- **Frontend / Asset Bundling**: Vite, Blade Templating, Vanilla JavaScript (ES6+), jQuery
- **CSS Framework**: Bootstrap 5.3 + Custom Scoped SCSS/CSS
- **Iconography**: FontAwesome 6 Pro / Free (`fa-solid`, `fa-regular`)
- **HTTP Client**: Axios (with `HeaderToken()` authentication interceptors)
- **Feedback & Alerts**: SweetAlert2, Toastify.js (`successToast()`, `errorToast()`)
- **Barcode & Scanner Support**: Web Audio API (Scan Beep), HTML5 QR/Barcode Camera Scanner

---

## 2. UI / UX Design Consistency Guidelines

### 2.1 Color Palette
Maintain consistent color usage across all pages, modals, tables, and buttons:

| Color Role | Hex Code | Utility / CSS Equivalent | Usage |
| :--- | :--- | :--- | :--- |
| **Primary Brand Green** | `#15803d` / `#16a34a` | `text-success`, `bg-success` | Main actions, save buttons, active tabs, brand headers |
| **Hover Primary Green** | `#166534` | - | Hover/Active state of primary action buttons |
| **Success Subtle / Light** | `#f0fdf4` / `#dcfce7` | `bg-success-subtle` | Container backgrounds, highlight flash, active cards |
| **Danger / Alert Red** | `#dc2626` / `#ef4444` | `text-danger`, `bg-danger` | Delete buttons, out-of-stock badges, error toasts |
| **Danger Subtle / Light** | `#fef2f2` / `#fee2e2` | `bg-danger-subtle` | Out of stock background, delete icon background |
| **Dark Slate / Text** | `#0f172a` / `#1e293b` | `text-dark`, `text-slate-900` | Headings, table data, strong labels |
| **Muted Slate / Subtitle** | `#64748b` | `text-muted`, `text-secondary` | Timestamps, barcodes, IDs, helper text |
| **Border Neutral** | `#e2e8f0` / `#cbd5e1` | `border`, `border-slate-200` | Card borders, table dividers, input borders |
| **Card / Surface White** | `#ffffff` | `bg-white` | Modal cards, table body, dropdown menus |

### 2.2 Typography & Fonts
- **Primary Body Font**: `'Poppins', 'Inter', -apple-system, sans-serif`
- **Bangla Font Support**: `'Hind Siliguri', 'SolaimanLipi', sans-serif`
- **Monospace Code/Barcode**: `font-monospace`, `'Courier New', monospace`
- **Font Sizes**:
  - Main Page Title: `20px - 24px` (`fw-bold`)
  - Modal Heading: `16px - 18px` (`fw-bold text-success`)
  - Table Header: `12px - 13px` (`fw-bold text-uppercase`)
  - Table Body Data: `13px - 14px`
  - Badges & Micro-tags: `10px - 11px` (`fw-semibold`)

### 2.3 Form & Input Standards
1. **Input Height**: Standard height for inputs & selects is `40px` to `44px` with `border-radius: 8px`.
2. **Focus State**: `border-color: #15803d; box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15);`
3. **Required Fields**: Mark with red asterisk `<span class="text-danger">*</span>` next to label.
4. **Action Buttons in Forms**:
   - Save / Submit: `<button type="submit" class="btn btn-success fw-bold px-4 py-2" style="background-color: #15803d; border-radius: 8px;">`
   - Cancel / Close: `<button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">`
   - Inline Add / Popups: `+ Add` button styled with background `#15803d` and text `#ffffff`.

### 2.4 Modals Architecture
- Every modal must have a distinct backdrop and proper z-index layering (`z-index: 1055` to `1065` for sub-modals).
- Always attach the `hidden.bs.modal` event to reset form state, clear image previews, and reset hidden IDs.
- Use `showLoader()` and `hideLoader()` during asynchronous API calls in modals.

### 2.5 Responsive & Mobile First Table Behavior
- On desktop (`>= 992px`), render high-density tables with `#tableList`.
- On mobile (`< 992px`), automatically render responsive card views `#mobileCardList`.
- Avoid horizontal page overflows; make all table wrappers responsive with `.table-responsive`.

---

## 3. Domain Business Rules & Features

### 3.1 Door Category & Handedness Specification
- When a product is created or edited under the **"Door"** category (Category name matches `/door/i`):
  - A dynamic selection system **Door Handedness / পাল্লার দিক নির্বাচন** must be displayed.
  - Allowed values for `door_side`:
    1. `Left Handed` (বাম হাতি 👈)
    2. `Right Handed` (ডান হাতি 👉)
    3. `Both Handed` (উভয়মুখী / Universal ↔️)
  - If category is not "Door", the `door_side` field is reset to `null` and hidden.
  - The `door_side` badge must be displayed across Product Lists, POS Product Cards, Cart, Search Suggestions, Purchase Orders, Return Orders, and Invoices.

### 3.2 Product Barcode Standards
- Products support single or multiple barcodes stored as JSON arrays (e.g. `["CODE1", "CODE2"]`).
- POS and Purchase search boxes support:
  - Instant exact match auto-increment on hardware barcode scanner trigger (`Enter` key).
  - Search by code substring, product name, or category name.
  - Scan audio confirmation via Web Audio API beep sound.

### 3.3 Inventory & Financial Calculations
- **Stock Integrity**:
  - POS sale decreases product `quantity`.
  - Purchases increase product `quantity` and update `cost_price`.
  - Returns adjust stock and supplier/customer balances accordingly.
- **Amounts & Money Format**:
  - Always calculate money with 2 decimal places (`toFixed(2)`).
  - Show Bangladeshi Taka sign `৳` before currency figures.

---

## 4. Backend & API Conventions

### 4.1 Authentication & Request Headers
- All API requests to protected routes (`/api/*`) require a JWT Bearer token passed via `HeaderToken()`:
  ```javascript
  function HeaderToken() {
      let token = localStorage.getItem('token');
      return {
          headers: {
              'token': token,
              'Authorization': 'Bearer ' + token
          }
      };
  }
  ```

### 4.2 Standard API JSON Response Contract
Controllers must return standardized JSON payloads:
```json
{
  "status": "success",
  "message": "Operation completed successfully",
  "data": { ... }
}
```
Or for errors:
```json
{
  "status": "failed",
  "message": "Validation or execution error message"
}
```

### 4.3 Database Migrations & Models
- Foreign keys must be indexed and reference corresponding parent tables with appropriate `cascadeOnDelete()` or `restrictOnDelete()`.
- Eloquent models must define `$fillable` arrays explicitly for mass assignment protection.
- Date fields should use standard `date` or `timestamp` types.

---

## 5. Summary Checklist for New Features

- [ ] Does the UI match the Primary Green (`#15803d`) and Neutral Border palette?
- [ ] Is the view responsive on both Desktop (Table) and Mobile (Cards)?
- [ ] Are feedback notifications using `successToast()` or `errorToast()`?
- [ ] Are forms validated both client-side (JS) and server-side (Laravel)?
- [ ] Is image uploading secured with format and size checks?
- [ ] Are category-specific attributes (like `door_side`) preserved and displayed across modules?
