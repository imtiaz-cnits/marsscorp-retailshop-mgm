# MARSS Corporation - Retail Shop Management
## Project Rules & Architecture Guidelines (প্রজেক্ট নীতিমালা ও ডিজাইন গাইডলাইন)

---

### 1. CSS Framework & Styling Standard (টেইলউইন্ড সিএসএস স্ট্যান্ডার্ড) [STRICT RULE]
> [!IMPORTANT]
> **সমগ্র প্রোজেক্টে Tailwind CSS বাধ্যতামূলক এবং Bootstrap সম্পূর্ণ নিষিদ্ধ:**
> 1. **Framework**: প্রোজেক্টের সমস্ত UI ডিজাইন **Tailwind CSS** (Vite কম্পাইল্ড) দিয়ে পরিচালিত হবে। Bootstrap সম্পূর্ণভাবে পরিহার/রিপ্লেস করতে হবে।
> 2. **Custom CSS Reduction**: অপ্রয়োজনীয় কাস্টম CSS ফাইল কমিয়ে সবকিছু Tailwind utility classes দিয়ে ম্যানেজ করতে হবে। শুধুমাত্র জটিল অ্যানিমেশন, প্রিন্ট মিডিয়া বা স্পেশাল প্লাগইনের জন্য মিনিমাল সিএসএস `resources/css/app.css`-এ রাখা যাবে।
> 3. **Design System & Colors**:
>    - Brand Primary Green: `emerald-700` / `#15803d`, `emerald-600` / `#16a34a`
>    - Hover Green: `emerald-800` / `#166534`, `emerald-900` / `#14532d`
>    - Subtle Tint Backgrounds: `emerald-50` / `#f0fdf4`
>    - Neutral Dark: `slate-900` / `#0f172a`, `slate-800` / `#1e293b`
>    - Borders: `slate-200` / `#e2e8f0`, `slate-300` / `#cbd5e1`

---

### 2. Zero Functional & Logic Regression (ফাংশনালিটি ও লজিক অক্ষুণ্ণ রাখার নিয়ম) [STRICT RULE]
> [!WARNING]
> **ডিজাইন রূপান্তরের সময় কোনো ফাংশনালিটি বা ব্যাকএন্ড লজিক পরিবর্তন করা যাবে না:**
> 1. সমস্ত DOM Element ID (`#CustomerSelectData`, `#subTotal`, `#paidAmountInput`, `#CustomerID`, ইত্যাদি) এবং JS ভ্যারিয়েবল/ফাংশন অবিকৃত থাকতে হবে।
> 2. API এন্ডপয়েন্ট, Axios রিকোয়েস্ট, হেডার টোকেন, কন্ট্রোলার ও ডাটাবেজ মডেল ১০০% অপরিবর্তিত থাকবে।
> 3. SweetAlert, Toastify, Html5QrcodeScanner, ভ্যালিডেশন এবং ইনভয়েস প্রিন্টিং কার্যকারিতা হুবহু অক্ষুণ্ণ রাখতে হবে।

---

### 3. Typography & Font Standard (ফন্ট নীতিমালা) [STRICT RULE]
> [!IMPORTANT]
> **সমগ্র প্রোজেক্টের ফন্ট ব্যবহারের কঠোর নিয়মাবলী:**
> 1. **ইংরেজি ও নিউমেরিক টেক্সট (English & Numbers)**: অবশ্যই **`Valley Sans`** ফন্ট ব্যবহার করতে হবে।
> 2. **বাংলা টেক্সট (Bangla Text)**: অবশ্যই **`Baloo Da 2`** ফন্ট ব্যবহার করতে হবে।
> 3. `Poppins` বা অন্য কোনো ফন্ট প্রোজেক্টে ব্যবহার করা সম্পূর্ণরূপে নিষিদ্ধ।

- **Primary English Font**: `'Valley Sans', sans-serif`
  - **Google Font URL**: [https://fonts.google.com/specimen/Valley+Sans](https://fonts.google.com/specimen/Valley+Sans)
  - **Weights**: `300..800` (Variable Font)
- **Primary Bangla Font**: `'Baloo Da 2', sans-serif`
  - **Google Font URL**: [https://fonts.google.com/specimen/Baloo+Da+2](https://fonts.google.com/specimen/Baloo+Da+2)
  - **Weights**: `400`, `500`, `600`, `700`, `800`
- **Global Font Stack**:
  ```css
  font-family: 'Valley Sans', 'Baloo Da 2', sans-serif;
  ```

---

### 4. Folder Structure & Laravel Conventions (ফোল্ডার স্ট্রাকচার স্ট্যান্ডার্ড)

1. **Views Architecture**:
   - Layouts: `resources/views/layouts/` (যেমন `app.blade.php`, `dashboard-sidenav.blade.php`)
   - Pages: `resources/views/pages/`
   - Components: `resources/views/components/`
2. **Assets & Pipeline**:
   - `resources/css/app.css` & `resources/js/app.js` processed via Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`)
   - Static logos, icons, uploads located in `public/` directory.

---

### 5. POS & Product Architecture Rules

1. **POS 100vh Full Screen Rule**:
   - POS পেজটি ব্রাউজারের কোনো পেজ-স্ক্রলিং ছাড়া `100vh` ভিউপোর্টে থাকবে।
   - কার্ট প্রোডাক্ট টেবিল স্বাধীনভাবে স্ক্রল হবে (`overflow-y: auto`), টেবিল হেডার স্টিকি থাকবে।
   - পেমেন্ট মেথড, অ্যামাউন্ট ও কনফার্মেশন বাটন সবসময় নিচে স্টিকি/পিন্ড থাকবে।
2. **Door Handedness Specification**:
   - ডোর ক্যাটাগরির পণ্যে Left, Right, Both হ্যান্ডেডনেস সাপোর্ট এবং মডাল ও ফর্মে ১ লাইনে `QTY: [ input ]` সিঙ্গেল লাইন লেআউট বজায় থাকবে।
   - প্রোডাক্ট টেবিলে একই মডেলের ডোর ভেরিয়েন্ট গ্রুপ রো হিসেবে প্রদর্শিত হবে।

---

### 6. Backend & Architecture Rules (ব্যাকএন্ড ও এপিআই নীতিমালা)

- **কন্ট্রোলার রেসপন্স ফরম্যাট**:
  - সাফল্য: `return response()->json(['status' => 'success', 'message' => '...', ...]);`
  - ব্যর্থতা: `return response()->json(['status' => 'fail', 'message' => '...']);`
- **রিলেশন ইগার লোডিং (Eager Loading)**:
  - প্রোডাক্ট সংক্রান্ত এপিআই কোয়েরিতে সবসময় `category`, `brand`, `unit`, `subCategory` ইগার-লোড করতে হবে।
- **টোকেন অথেনটিকেশন**:
  - ফ্রন্টএন্ড থেকে সকল এপিআই রিকোয়েস্টে `HeaderToken()` বা `HeaderTokenWithBlob()` হেডার পাস করতে হবে।
- **ক্যাশ ও এসেট কম্পাইলেশন**:
  - প্রতিটি পরিবর্তনের পর `npm run build` এবং `php artisan optimize:clear` নিশ্চিত করতে হবে।

---

### 7. Table Data Ordering Standard (টেবিল ডাটা ও নতুন এন্ট্রি ডিসপ্লে নিয়ম) [STRICT RULE]
> [!IMPORTANT]
> **সকল টেবিলে নতুন এন্ট্রি করা ডাটা টেবিলের সবার উপরে (Top) প্রদর্শিত হতে হবে:**
> 1. **Backend List Queries**: সমস্ত কন্ট্রোলারের লিস্ট এপিআই (`ProductList`, `CategoryList`, `BrandList`, `PurchaseList`, `ExpenseList`, `SupplierList`, `CustomerList` ইত্যাদি)-তে ডাটা কোয়েরি করার সময় অবশ্যই `latest('id')` অথবা `orderBy('id', 'desc')` ব্যবহার করতে হবে, যেন নতুন যুক্ত হওয়া আইটেম সবার প্রথমে (Top-এ) থাকে।
> 2. **Frontend Table & DataTables Sorting**:
>    - ফ্রন্টএন্ড টেবিল রেন্ডারিং, ক্লায়েন্ট-সাইড ফিল্টারিং এবং DataTables ইনিশিয়ালাইজেশনের ক্ষেত্রে ডিফল্ট সর্টিং সর্বদা Newest First (ID বা Created Date Descending) বজায় রাখতে হবে।
>    - গ্রুপড টেবিল (যেমন প্রোডাক্ট গ্রুপ) হলে গ্রুপ লিস্টের সর্টিংও গ্রুপের সর্বোচ্চ/নতুন আইটেমের আইডি অনুযায়ী ডিসেন্ডিং অর্ডারে সাজাতে হবে (`groupedList.sort((a, b) => b.maxId - a.maxId)`).
> 3. **Post-Creation Table Refresh**:
>    - নতুন কোনো রেকর্ড তৈরি বা সেভ হওয়ার পর টেবিল রিফ্রেশ বা `getList()` কল করার সময় বর্তমান পেজ নম্বর ১-এ রিসেট করতে হবে (`currentPage = 1`), যাতে নতুন যুক্ত করা আইটেমটি ইউজার তৎক্ষণাৎ টেবিলের একদম উপরে দেখতে পান।

---

### 8. List Page & DataTable Master UI/UX Standard (লিস্ট পেজ ও ডাটাটেবিল সম্পূর্ণ ডিজাইন স্ট্যান্ডার্ড) [STRICT RULE]
> [!IMPORTANT]
> **প্রোজেক্টের প্রতিটি লিস্ট পেজ (Product, Category, Brand, Purchase, Customer, Supplier, Expense ইত্যাদি) হুবহু Product List ও Invoice List পেজের আধুনিক ডিজাইন, বাটন, টেবিল, প্যাডিং, বর্ডার ও ফিল্টারিং স্পেসিফিকেশন মেনে তৈরি করতে হবে:**

#### ১. Page Layout & Card Container
- **Layout Hierarchy**:
  ```html
  <div class="main-content">
      <div class="page-content min-h-screen flex flex-col justify-between">
          <div class="data-table flex-grow">
              <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                  <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                      <!-- Page Contents -->
                  </div>
              </div>
          </div>
          <!-- Sticky Footer with mt-auto -->
      </div>
  </div>
  ```
- **Card Body Padding [STRICT]**:
  - মোবাইল ভিউ (< 768px): চারপাশেই `10px` প্যাডিং (`padding: 10px !important;`).
  - ডেস্কটপ ভিউ (≥ 768px): চারপাশেই `16px` প্যাডিং (`padding: 16px !important;`).
  - `.data-table` ব্যাকগ্রাউন্ড সর্বদা স্বচ্ছ (`background: transparent !important;`), যাতে ডার্ক মোডে কোনো সাদা গ্যাপ বা ফ্ল্যাশ না থাকে।

#### ২. Page Header & Top Action Controls
- **Top Header Layout**: `flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3`
- **Title & Icon Badge**:
  - আইকন বক্স: `w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0`
  - পেজ টাইটেল: `h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0"`
  - টাইটেলের নিচে কোনো ডেসক্রিপশন বা বটম মার্জিন থাকবে না (Zero bottom margin, description completely removed)।
- **Export & Utility Action Buttons (Copy, CSV, PDF, Print, Excel)**:
  - সাইজ: ঠিক `38px × 38px` (`w-[38px] h-[38px] min-w-[38px] min-h-[38px] rounded-xl flex items-center justify-center shadow-sm`).
  - বর্ডার: `.unified-ui-border` (`1.5px solid #cbd5e1`, ডার্ক মোডে `border-color: #334155 !important`).
  - লাইট মোড: `bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900`.
  - ডার্ক মোড: `dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white`.

#### ৩. Controls & Filter Bar (Search, Entries & Dropdowns)
- **Responsive Layout**:
  - **মোবাইল ভিউ (< 768px)**:
    - রো ১: Search Bar সম্পূর্ণ উইডথ (`w-full`) এক লাইনে।
    - রো ২: Start Date ও End Date পাশাপাশি ২ কলামে এক লাইনে (`grid grid-cols-2 gap-2 w-full`).
  - **ডেস্কটপ ভিউ (≥ 768px)**: Search Bar (ফ্লেক্সিবল `flex-1 min-w-[200px]`), Start Date (`w-[165px]-w-[185px]`) ও End Date (`w-[165px]-w-[185px]`) পাশাপাশি ১টি ক্লিন রো-তে থাকবে।
- **Date Picker Standard (Flatpickr)**:
  - ডেট ফিল্ডে Flatpickr ব্যবহার হবে (`d/m/Y` ডিসপ্লে, `Y-m-d` ভ্যালু)।
  - ক্যালেন্ডারে মাসের কোনো সিলেক্ট ড্রপডাউন থাকবে না (`monthSelectorType: "static"`), শুধুমাত্র Prev `<` ও Next `>` বাটন দিয়েই মাস পরিবর্তন হবে।
  - আলাদা কোনো Search বাটনের প্রয়োজন নেই; ডেট সিলেক্ট করার সাথে সাথেই স্বয়ংক্রিয়ভাবে ডাটা ফিল্টার বা লোড হবে।
- **Search Bar**:
  - র‍্যাপার: `search-input-wrapper unified-ui-border h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm`.
  - ফোকাস ইফেক্ট: `border-color: #15803d !important; box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;`.
  - সার্চ আইকন: `w-4 h-4 text-slate-400 mr-2.5 pointer-events-none` (ভার্টিক্যালি পারফেক্ট অ্যালাইন)।
  - ভেতরের ইনপুট: কোনো আউটলাইন বা ইনপুট ফোকাস বর্ডার থাকবে না (`border: none !important; outline: none !important; box-shadow: none !important; background: transparent !important;`).
- **Show Entries Selector**:
  - র‍্যাপার: `entries-wrapper unified-ui-border flex items-center gap-1 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold`.
  - লেবেল: `Show:` (Bold uppercase `text-slate-400`).
  - ডিফল্ট ভ্যালু: সর্বদা **`50`** বা **`15`** (`<option value="50" selected>50</option>`).
- **Custom Searchable Dropdowns (Category, Brand, Filter, etc.)**:
  - ট্রিগার বাটন: `unified-ui-border h-[38px] px-3.5 bg-white dark:bg-slate-800/90 rounded-xl text-xs sm:text-sm font-medium hover:border-emerald-500`.
  - ড্রপডাউন মেনু: `border: 1.5px solid #cbd5e1`, `border-radius: 12px`, শ্যাডো, ডার্ক মোডে `#0f172a` ব্যাকগ্রাউন্ড ও `#334155` বর্ডার।

#### ৪. Desktop Table Architecture & Styling
- **Table Container**: `table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900`.
- **Table Headers (`thead tr`)**:
  - ব্যাকগ্রাউন্ড: সলিড এমারেল্ড গ্রিন `bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider`.
  - টেক্সট র‍্যাপ রুল: টেবিল হেডার কখনো ২ লাইনে ভাঙবে না, строго ১ লাইন থাকবে (`white-space: nowrap !important;`).
  - সিরিয়াল হেডার: `SL` (w-[40px] text-center rounded-tl-2xl).
  - প্যাডিং: প্রতিটি হেডার সেল (`th`) ও ডাটা সেলে (`td`) হরাইজন্টাল ও ভার্টিক্যাল প্যাডিং সমান `10px` থাকবে (`p-[10px]` / `px-[10px] py-[10px]`).
- **Table Body (`tbody tr`)**:
  - রো বর্ডার: `divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200`.
  - রো হোভার [STRICT]: ডার্ক মোডে রো হোভার করলে যেন কখনো সাদা না হয়; সর্বদা ডার্ক স্লেট হোভার `rgba(30, 41, 59, 0.6)` বজায় রাখতে হবে:
    ```css
    body[light-mode="dark"] #printTable tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }
    ```
  - কারেন্সি ফরম্যাট: প্রতিটি টাকার অঙ্কে ডায়নামিক বাংলাদেশি কমা সেপারেটর বসবে (`formatBdCurrency()`: যেমন `৳ 24,800.00`).
  - কাস্টমার আইডি ও স্ট্যাটাস ব্যাজের ডার্ক বর্ডার: ডার্ক মোডে কাস্টমার আইডি ব্যাজ এবং স্ট্যাটাস পিল ব্যাজের বর্ডারও অন্যান্য বাটনের মতো অবশ্যই `#334155` হতে হবে।
  - অ্যাকশন বাটন [Action Icons]:
    - প্রিন্ট বাটন: Emerald (`#10b981`).
    - রিটার্ন বাটন (Sales/Purchase Return): ডার্ক মোডে উজ্জ্বল গোল্ডেন অ্যাম্বার (`color: #fbbf24 !important; background: rgba(245, 158, 11, 0.2) !important;`), যাতে স্পষ্টভাবে বোঝা যায়।
    - ডিউ/কালেকশন বাটন: Blue (`#60a5fa`).
    - এডিট বাটন: Purple (`#c084fc`).
    - সব অ্যাকশন বাটনের বর্ডার ডার্ক মোডে সমানভাবে `#334155` থাকবে।

#### ৫. Mobile View (< 768px) Card Architecture
- মোবাইল স্ক্রিনে ডেস্কটপ টেবিল হাইড থাকবে (`hidden md:block`), এবং মোবাইল কার্ড লিস্ট প্রদর্শিত হবে (`block md:hidden`).
- প্রতিটি মোবাইল কার্ড: `unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3`.
- **ফাইন্যান্সিয়াল / ডেটা বক্স (Financial Grid) [STRICT]**:
  - ডেটা বক্স ভার্টিক্যালি এক কলামে না রেখে বামে-ডানে পাশাপাশি ২ কলামের গ্রিডে (`grid grid-cols-2 gap-2`) থাকবে।
  - প্রতিটি গ্রিড সেলে লেবেল থাকবে বামে এবং টাকার পরিমাণ থাকবে ডানে (`flex items-center justify-between px-2.5 py-1.5`).
  - গ্রিড বক্সের উপরে যথাযথ মার্জিন টপ (`mt-3.5` / `margin-top: 14px !important;`) বজায় রাখতে হবে।

#### ৬. Pagination & Showing Counter Section
- **Layout**: `flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3`.
- **Showing Box ("Showing 1 – 50 of 195 items")**:
  - আধুনিক পিল/কার্ড ব্যাজ স্টাইল: `px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 text-xs font-semibold text-slate-600 dark:text-slate-300`.
  - ডার্ক মোডে ব্যাকগ্রাউন্ড ডার্ক `#0f172a` ও কাউন্ট বক্সে `#1e293b`, কোনো অবস্থায় সাদা ব্যাকগ্রাউন্ড থাকবে না।
- **Pagination Buttons**:
  - মোবাইল ও ডেস্কটপে ১ লাইনে সিঙ্গেল-লাইন লেআউট (`flex-nowrap overflow-x-auto`).
  - অ্যাক্টিভ পেজ: সলিড এমারেল্ড গ্রিন `bg-emerald-700 text-white rounded-lg px-3 py-1.5 text-xs font-bold`.
  - সাধারণ বাটন: `border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 hover:bg-slate-100 text-slate-700 dark:text-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-medium`.

#### ৭. Unified UI Border Color Standard [CRITICAL]
- **লাইট মোড (Light Mode)**:
  - সার্চবার, ডেট ফিল্ড, শো এন্ট্রি, ড্রপডাউন, কপি/সিএসভি/প্রিন্ট বাটন, কার্ড কন্টেইনার, কাস্টমার আইডি, স্ট্যাটাস ব্যাজ ও অ্যাকশন বাটন—সবকিছুর বর্ডার একই কালার `#cbd5e1` (Tailwind `slate-300`) হবে (`border: 1.5px solid #cbd5e1 !important;`).
- **ডার্ক মোড (Dark Mode)**:
  - সমস্ত বর্ডার (ফিল্ড, ডেট ইনপুট, বাটন, টেবিল, কার্ড, ড্রপডাউন, ইমেজ বক্স, কাস্টমার আইডি ব্যাজ, স্ট্যাটাস পিল, অ্যাকশন বাটন, পেজিনেশন) বাধ্যতামূলকভাবে ডার্ক স্লেট কালার `#334155` / `slate-800` হবে।

#### ৮. Dark Mode Standard Specifications
- **বডি ও পেজ ব্যাকগ্রাউন্ড**: `bg-[#0b0f19]`.
- **টপবার ও সাইডবার ব্যাকগ্রাউন্ড**: `bg-[#0b0f19]`.
- **মেইন কার্ড ও মডাল ব্যাকগ্রাউন্ড**: `bg-slate-900` (`#0f172a`).
- **ইনপুট, সিলেক্ট, সার্চ ড্রপডাউন ব্যাকগ্রাউন্ড**: `bg-slate-800/90` (`#1e293b`).

#### ৯. Sticky Footer & Zoom-Out Safety Standard [CRITICAL]
- **ফুল স্ক্রিন ও জুম-আউট প্রটেকশন**:
  - ব্রাউজার জুম আউট (যেমন 25%, 50%, 67%, 75%) করলেও বা বড় স্ক্রিনে কন্টেন্ট কম থাকলেও কপিরাইট ফুটার সর্বদা স্ক্রিনের একদম নিচে (Bottom) থাকবে।
  - এর জন্য `.page-content` ও `.main-content`-এ `min-height: 100vh; display: flex; flex-direction: column;` এবং কপিরাইট ফুটার সেকশনে `margin-top: auto !important;` (`mt-auto`) থাকতে হবে।
- **টেক্সট ফরম্যাট [STRICT]**:
  - কোনো বাংলা নাম বা ব্র্যাকেট থাকবে না।
  - সাল স্বয়ংক্রিয়ভাবে বর্তমান বছরের হবে (`{{ date('Y') }}`):
    ```html
    &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
    ``` none !important; box-shadow: none !important; background: transparent !important;`).
- **Show Entries Selector**:
  - র‍্যাপার: `entries-wrapper unified-ui-border flex items-center gap-1 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold`.
  - লেবেল: `Show:` (Bold uppercase `text-slate-400`).
  - ডিফল্ট ভ্যালু: সর্বদা **`15`** (`<option value="15" selected>15</option>`). অপশনসমূহ: `15, 50, 100, 200, 500`.
- **Custom Searchable Dropdowns (Category, Brand, etc.)**:
  - ট্রিগার বাটন: `unified-ui-border h-[38px] px-3.5 bg-white dark:bg-slate-800/90 rounded-xl text-xs sm:text-sm font-medium hover:border-emerald-500`.
  - ড্রপডাউন মেনু: `border: 1.5px solid #cbd5e1`, `border-radius: 12px`, শ্যাডো, ভেতরে সার্চ ইনপুট ও স্ক্রলযোগ্য অপশন লিস্ট।
  - আইটেম হোভার: `bg-[#f0fdf4] text-[#15803d] border-l-4 border-[#16a34a]`.
  - সিলেক্টেড/অ্যাক্টিভ আইটেম: `bg-[#dcfce7] text-[#15803d] font-semibold` সাথে সবুজ টিকচিহ্ন (`fa-check`).

#### ৪. Desktop Table Architecture & Styling
- **Table Container**: `table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900`.
- **Table Headers (`thead tr`)**:
  - ব্যাকগ্রাউন্ড: সলিড এমারেল্ড গ্রিন `bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider`.
  - টেক্সট র‍্যাপ রুল: টেবিল হেডার কখনো ২ লাইনে ভাঙবে না, строго ১ লাইন থাকবে (`white-space: nowrap !important;`).
  - সিরিয়াল হেডার: `SL` (w-[40px] text-center rounded-tl-2xl).
  - প্যাডিং: প্রতিটি হেডার সেল (`th`) ও ডাটা সেলে (`td`) হরাইজন্টাল ও ভার্টিক্যাল প্যাডিং সমান `10px` থাকবে (`p-[10px]` / `px-[10px] py-[10px]`).
  - অ্যাকশন কলামের অবস্থান: অ্যাকশন কলামটি স্টক (Stock/Quantity) কলামের ডান পাশে বসবে (`text-center w-[75px] rounded-tr-2xl`).
- **Table Body (`tbody tr`)**:
  - রো বর্ডার: `divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200`.
  - রো হোভার: `hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors`.
  - কারেন্সি ফরম্যাট: Cost Price, Total Cost Price, Selling Price ইত্যাদি সকল টাকার অঙ্কে ডায়নামিক বাংলাদেশি কমা সেপারেটর বসবে (`formatBdCurrency()`: যেমন `৳ 24,800.00`).
  - মডার্ন স্ট্যাটাস ব্যাজ: পিল ব্যাজ (`rounded-full px-2.5 py-1 text-xs font-semibold`); Available `bg-emerald-500 text-white`, Out of Stock `bg-rose-500 text-white`.
  - রো অ্যাকশন বাটন: আধুনিক এডিট (`fa-pen-to-square`) ও ডিলিট (`fa-trash-can`) আইকন সমৃদ্ধ মিনি স্কয়ার বাটন (`w-7 h-7 rounded-lg`).
- **Table Footer (`tfoot`)**:
  - `bg-slate-50/90 dark:bg-slate-800/70 font-bold border-t-2 border-emerald-600/30 text-slate-900 dark:text-white`.

#### ৫. Mobile View (< 768px) Card Architecture
- মোবাইল স্ক্রিনে ডেস্কটপ টেবিল হাইড থাকবে (`hidden md:block`), এবং মোবাইল কার্ড লিস্ট প্রদর্শিত হবে (`block md:hidden`).
- প্রতিটি মোবাইল কার্ড: `product-mobile-card unified-ui-border rounded-xl p-3 bg-white dark:bg-slate-800/60 shadow-sm mb-3`.

#### ৬. Pagination & Showing Counter Section
- **Layout**: `flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3`.
- **Showing Box ("Showing 1 – 15 of 195 items")**:
  - আধুনিক পিল/কার্ড ব্যাজ স্টাইল: `px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 text-xs font-semibold text-slate-600 dark:text-slate-300`.
- **Pagination Buttons**:
  - মোবাইল ও ডেস্কটপে ১ লাইনে সিঙ্গেল-লাইন লেআউট (`flex-nowrap overflow-x-auto`).
  - অ্যাক্টিভ পেজ: সলিড এমারেল্ড গ্রিন `bg-emerald-700 text-white rounded-lg px-3 py-1.5 text-xs font-bold`.
  - সাধারণ বাটন: `border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 hover:bg-slate-100 text-slate-700 dark:text-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-medium`.

#### ৭. Unified UI Border Color Standard [CRITICAL]
- **লাইট মোড (Light Mode)**:
  - সার্চবার, শো এন্ট্রি, ক্যাটাগরি/ব্র্যান্ড ড্রপডাউন, কপি/সিএসভি/প্রিন্ট বাটন, কার্ড কন্টেইনার এবং টেবিল বর্ডার—সবকিছুর বর্ডার একই কালার `#cbd5e1` (Tailwind `slate-300`) হবে:
    ```css
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }
    ```
- **ডার্ক মোড (Dark Mode)**:
  - সমস্ত বর্ডার (ফিল্ড, বাটন, টেবিল, কার্ড, ড্রপডাউন, ইমেজ বক্স, বারকোড কার্ড, অ্যাকশন বাটন, পেজিনেশন বক্স) বাধ্যতামূলকভাবে ডার্ক স্লেট কালার `#334155` / `slate-800` হবে। ডার্ক মোডে কোনো অবস্থাতেই সাদা বা হালকা রঙের বর্ডার থাকবে না।

#### ৮. Dark Mode Standard Specifications
- **বডি ও পেজ ব্যাকগ্রাউন্ড**: `bg-[#0b0f19]`.
- **টপবার ও সাইডবার টপ লোগো ব্যাকগ্রাউন্ড**: `bg-[#0b0f19]`.
- **মেইন কার্ড ও মডাল ব্যাকগ্রাউন্ড**: `bg-slate-900` (`#0f172a`).
- **ইনপুট, সিলেক্ট, সার্চ ড্রপডাউন ব্যাকগ্রাউন্ড**: `bg-slate-800/90` (`#1e293b`).
- **টেবিল ডেটা রো হোভার**: `dark:hover:bg-slate-800/50`.

#### ৯. Sticky Footer Copyright Standard
- **কনটেইনার**: `sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center`.
- **টেক্সট ফরম্যাট [STRICT]**:
  - কোনো বাংলা নাম বা ব্র্যাকেট থাকবে না।
  - সাল স্বয়ংক্রিয়ভাবে বর্তমান বছরের হবে (`{{ date('Y') }}`):
    ```html
    &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
    ```


