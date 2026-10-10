@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchase Return Details - MARSS CORPORATION')

@section('topbar_back_button')
  <a href="{{ route('battery.purchase.returns') }}" class="topbar-back-btn" title="Back to Purchase Returns">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
@endsection

@section('content')

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            
            <!-- Controls bar (No Print) -->
            <div class="no-print flex items-center justify-between mb-4 flex-wrap gap-2">
                <a href="{{ route('battery.purchase.returns') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Purchase Returns</span>
                </a>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 h-[38px] bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-print"></i>
                    <span>Print Return Voucher</span>
                </button>
            </div>

            <!-- Receipt Container -->
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-6 p-6 sm:p-8 max-w-4xl mx-auto print:shadow-none print:border-none print:p-0">
                
                <!-- Header Top -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between border-b border-slate-200 dark:border-slate-800 pb-5 mb-6 gap-4">
                    <div class="flex items-start gap-3">
                        <img src="{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}" alt="MARSS Corporation Logo" style="height: 48px; width: auto; object-fit: contain;" />
                        <div>
                            <h2 class="text-xl font-black text-emerald-700 dark:text-emerald-400 m-0 tracking-tight leading-tight">
                                <span class="text-rose-600">MARSS</span> CORPORATION
                            </h2>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 m-0">Battery Division • Supplier Stock Return Voucher</p>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500 m-0">Success Super Market, Sadar Police Fari, Pabna</p>
                        </div>
                    </div>
                    <div class="text-right sm:text-right">
                        <span class="inline-block px-3 py-1 bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 text-xs font-black uppercase tracking-wider rounded-lg border border-amber-200 dark:border-amber-900 mb-1">
                            Purchase Return Voucher
                        </span>
                        <div class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                            Voucher #PR-{{ str_pad($purchaseReturn->id, 5, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="text-[11px] text-slate-500 dark:text-slate-400">
                            Date: {{ \Carbon\Carbon::parse($purchaseReturn->date ?? $purchaseReturn->created_at)->format('d-m-Y') }}
                        </div>
                    </div>
                </div>

                <!-- Parties & Document Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-slate-50 dark:bg-slate-800/40 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Supplier Information</span>
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white m-0">
                            {{ $purchaseReturn->supplier->name ?? $purchaseReturn->supplier->company ?? 'Supplier' }}
                        </h4>
                        @if($purchaseReturn->supplier && $purchaseReturn->supplier->company && $purchaseReturn->supplier->name !== $purchaseReturn->supplier->company)
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-300 m-0">
                            Company: {{ $purchaseReturn->supplier->company }}
                        </p>
                        @endif
                        <p class="text-xs text-slate-600 dark:text-slate-300 m-0">
                            {{ $purchaseReturn->supplier->address ?? 'Tejgaon I/A, Dhaka' }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 m-0">
                            Phone: <span class="font-mono">{{ $purchaseReturn->supplier->mobile ?? 'N/A' }}</span>
                        </p>
                    </div>
                    <div class="sm:border-l sm:border-slate-200 dark:sm:border-slate-700 sm:pl-4">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Original Purchase Reference</span>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-slate-500">Purchase Ref:</span>
                            <span class="text-xs font-mono font-bold text-emerald-700 dark:text-emerald-400">
                                {{ $purchaseReturn->purchase->referance_no ?? $purchaseReturn->purchase->purchase_id ?? ('#PurID' . str_pad($purchaseReturn->purchase_id, 5, '0', STR_PAD_LEFT)) }}
                            </span>
                        </div>
                        @if($purchaseReturn->purchase)
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-slate-500">Purchase Date:</span>
                            <span class="text-xs text-slate-700 dark:text-slate-300 font-medium">
                                {{ \Carbon\Carbon::parse($purchaseReturn->purchase->date ?? $purchaseReturn->purchase->created_at)->format('d-m-Y') }}
                            </span>
                        </div>
                        @endif
                        @if($purchaseReturn->user)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500">Processed By:</span>
                            <span class="text-xs text-slate-700 dark:text-slate-300">{{ $purchaseReturn->user->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Returned Items (Read-Only) -->
                <div class="mb-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-slate-300 dark:border-slate-700">
                        <thead>
                            <tr class="bg-slate-100 dark:bg-slate-800 text-[11px] font-bold uppercase text-slate-600 dark:text-slate-300 tracking-wider">
                                <th class="border border-slate-300 dark:border-slate-700 p-2.5 text-center w-12">#</th>
                                <th class="border border-slate-300 dark:border-slate-700 p-2.5">Product Name</th>
                                <th class="border border-slate-300 dark:border-slate-700 p-2.5 text-center w-24">Returned Qty</th>
                                <th class="border border-slate-300 dark:border-slate-700 p-2.5 text-right w-28">Cost Price</th>
                                <th class="border border-slate-300 dark:border-slate-700 p-2.5 text-right w-32">Return Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-slate-700 dark:text-slate-200">
                            @php
                                $qty = (int) ($purchaseReturn->quantity ?? 1);
                                $costPrice = $qty > 0 ? ((float) $purchaseReturn->amount / $qty) : (float) $purchaseReturn->amount;
                            @endphp
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50">
                                <td class="border border-slate-300 dark:border-slate-700 p-2.5 text-center font-semibold">1</td>
                                <td class="border border-slate-300 dark:border-slate-700 p-2.5 font-bold text-slate-800 dark:text-white">
                                    {{ $purchaseReturn->product->product_name ?? 'Battery Product' }}
                                </td>
                                <td class="border border-slate-300 dark:border-slate-700 p-2.5 text-center font-bold">
                                    {{ $qty }} pcs
                                </td>
                                <td class="border border-slate-300 dark:border-slate-700 p-2.5 text-right font-mono">
                                    ৳ {{ number_format($costPrice, 2) }}
                                </td>
                                <td class="border border-slate-300 dark:border-slate-700 p-2.5 text-right font-mono font-bold text-rose-600 dark:text-rose-400">
                                    ৳ {{ number_format((float) $purchaseReturn->amount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Breakdown -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
                    <div class="text-xs text-slate-500 max-w-sm">
                        <div class="font-bold text-slate-700 dark:text-slate-300 mb-1">Stock & Supplier Account Impact:</div>
                        <p class="m-0 leading-relaxed">
                            This return was deducted atomically from warehouse battery inventory and credited against the purchase payable balance.
                        </p>
                    </div>
                    <div class="w-full sm:w-72 bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3.5 border border-slate-200 dark:border-slate-800 space-y-2 text-xs">
                        <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                            <span>Total Return Amount:</span>
                            <span class="font-bold font-mono text-rose-600 dark:text-rose-400">৳ {{ number_format((float) $purchaseReturn->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                            <span>Due Reduced:</span>
                            <span class="font-mono font-semibold">৳ {{ number_format((float) ($purchaseReturn->due_amount ?? 0), 2) }}</span>
                        </div>
                        @if((float) ($purchaseReturn->discount_amount ?? 0) > 0)
                        <div class="flex justify-between items-center text-slate-600 dark:text-slate-300">
                            <span>Discount Adjustment:</span>
                            <span class="font-mono">৳ {{ number_format((float) $purchaseReturn->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center font-bold text-slate-800 dark:text-white">
                            <span>Net Payable Adjustment:</span>
                            <span class="font-mono text-emerald-700 dark:text-emerald-400">৳ {{ number_format((float) $purchaseReturn->amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Signatures Row -->
                <div class="pt-10 flex justify-between items-end text-xs text-slate-500 border-t border-dotted border-slate-300 dark:border-slate-800">
                    <div class="text-center w-36 border-t border-slate-400 pt-1 font-semibold">
                        Supplier Signature
                    </div>
                    <div class="text-center w-36 border-t border-slate-400 pt-1 font-semibold">
                        Authorized Signature
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
