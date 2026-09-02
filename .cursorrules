# MARSS Corporation - Retail Shop Management
## Project Rules & Architecture Guidelines (প্রজেক্ট নীতিমালা ও ডিজাইন গাইডলাইন)

---

### 1. Typography & Font Standard (ফন্ট নীতিমালা) [STRICT RULE]
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
- **Global CSS Font Stack**:
  ```css
  font-family: 'Valley Sans', 'Baloo Da 2', sans-serif;
  ```
  *(CSS ফলব্যাকের মাধ্যমে ইংরেজি ক্যারেক্টারগুলো সরাসরি `Valley Sans`-এ এবং বাংলা অক্ষরগুলো স্বয়ংক্রিয়ভাবে `Baloo Da 2`-তে রেন্ডার হয়)*
- **CDN Import Link**:
  ```html
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
  ```

---

### 2. Design & Color Consistency (কালার ও ডিজাইন কনসিস্টেন্সি)

- **Brand Primary Green**: `#15803d` / `#16a34a` (বাটন, আইকন, হাইলাইট ও সেভ অ্যাকশন)
- **Hover & Active Green**: `#166534` / `#14532d`
- **Subtle Tint Backgrounds**: `#f0fdf4` / `#ecfdf5`
- **Text & Heading Colors**:
  - Primary Dark Text: `#0f172a` / `#1e293b`
  - Secondary / Muted Text: `#64748b` / `#475569`
  - White: `#ffffff`
- **Borders & Dividers**: `#e2e8f0` / `#cbd5e1`
- **Status & Variant Colors**:
  - **Left Handed (বাম হাতি)**: Primary Blue `#2563eb` (`bg-primary-subtle text-primary border-primary-subtle`)
  - **Right Handed (ডান হাতি)**: Success Green `#16a34a` (`bg-success-subtle text-success border-success-subtle`)
  - **Both / Universal (উভয়মুখী)**: Teal / Purple `#0891b2` / `#7c3aed` (`bg-info-subtle text-info border-info-subtle`)

---

### 3. Door Category & Handedness Rules (ডোর ক্যাটাগরি ও পাল্লার দিক সম্পর্কিত নিয়ম)

1. **ডোর স্পেসিফিকেশন (Door Handedness Specification)**:
   - Door ক্যাটাগরি সিলেক্ট হলে ৩টি নির্দিষ্ট হ্যান্ডেডনেস অপশন থাকবে:
     - `👈 Left Handed (বাম হাতি)`
     - `👉 Right Handed (ডান হাতি)`
     - `↔️ Both / Universal (উভয়মুখী)`
2. **মডাল ও ফর্মে কোয়ান্টিটি ইনপুট লেআউট**:
   - প্রতিটি কার্ডের ভেতর `QTY:` লেবেল এবং ইনপুট ফিল্ডটি অবশ্যই **১ লাইনে (Single Line Horizontal Layout)** থাকতে হবে।
     - উদাহরণ: `QTY: [  4  ]`
   - যেকোনো বক্সে স্টক লিখলে রিয়েল-টাইমে স্বয়ংক্রিয়ভাবে মোট স্টক হিসাব হয়ে মূল `Quantity` ফিল্ড এবং `মোট ডোর স্টক: X` ব্যাজে আপডেট হবে।
3. **প্রোডাক্ট লিস্ট ও টেবিল ভিউ (Multi-Variant Row Grouping)**:
   - একই নাম, মডেল, ব্র্যান্ড ও ক্যাটাগরির ভিন্ন ভিন্ন ডোর ভেরিয়েন্টগুলোকে টেবিলে আলাদা রো হিসেবে না দেখিয়ে **একই মূল রো-এর অধীনে** গ্রুপ করে দেখাতে হবে।
   - মূল রো-তে সর্বমোট স্টক এবং হ্যান্ডেডনেস ব্রেকডাউন চিপস (`👈 Left: X | 👉 Right: Y | ↔️ Both: Z`) প্রদর্শিত হবে।
   - বিস্তারিত ও পৃথক ভেরিয়েন্ট এডিট/ডিলিটের জন্য কোল্যাপসিবল একর্ডিয়ন সাব-টেবিল থাকবে।

---

### 4. UI Layout, Table & Modal Rules (মডাল ও টেবিল স্ট্যান্ডার্ড)

- **ফিল্টার ও সার্চ কন্ট্রোলস**:
  - **Row 1**: `Entries` ড্রপডাউন এবং `Search Product...` ইনপুট পাশাপাশি (`flex-nowrap`) বসবে। ডানপাশে `+ Add Product` এবং এক্সপোর্ট বাটন থাকবে।
  - **Row 2**: `All Brands` এবং `All Categories` ফিল্টার ড্রপডাউন দুটি পাশাপাশি একই লাইনে বসবে (`42px` হাইট, `8px` বর্ডার রেডিয়াস)।
- **মডাল স্ট্যান্ডার্ড**:
  - ব্যাকড্রপ: `rgba(15, 23, 42, 0.6)` সাথে `backdrop-filter: blur(4px)`.
  - বর্ডার রেডিয়াস: `12px` থেকে `16px`.
  - বাটন ও অ্যাকশন: Cancel বাটনে সফট গ্রে এবং Save/Submit বাটনে গ্রেডিয়েন্ট গ্রিন `#15803d`.

---

### 5. Backend & Architecture Rules (ব্যাকএন্ড ও এপিআই নীতিমালা)

- **কন্ট্রোলার রেসপন্স ফরম্যাট**:
  - সাফল্য: `return response()->json(['status' => 'success', 'message' => '...', ...]);`
  - ব্যর্থতা: `return response()->json(['status' => 'fail', 'message' => '...']);`
- **রিলেশন ইগার লোডিং (Eager Loading)**:
  - প্রোডাক্ট সংক্রান্ত এপিআই কোয়েরিতে সবসময় `category`, `brand`, `unit`, `subCategory` ইগার-লোড করতে হবে।
- **টোকেন অথেনটিকেশন**:
  - ফ্রন্টএন্ড থেকে সকল এপিআই রিকোয়েস্টে `HeaderToken()` বা `HeaderTokenWithBlob()` হেডার পাস করতে হবে।
- **ক্যাশ ও এসেট কম্পাইলেশন**:
  - ফ্রন্টএন্ড বা ব্লেড ভিউতে বড় ধরনের সিএসএস/জেএস পরিবর্তনের পর `npm run build` এবং `php artisan optimize:clear` রান করতে হবে।
