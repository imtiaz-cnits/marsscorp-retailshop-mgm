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
