<!-- MODAL: Battery Split Purchase Invoice Modal -->
<section class="modal fade" id="batteryPurchaseSplitModal" tabindex="-1" aria-labelledby="batteryPurchaseSplitModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content rounded-2xl border-0 shadow-2xl overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <!-- Modal Header -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-code-fork text-sm"></i>
                    <span>Split Battery Purchase Invoice</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4 sm:p-5" style="max-height: calc(85vh - 120px); overflow-y: auto;">
                <input type="hidden" id="splitBatterySourcePurchaseId">

                <!-- Source Purchase Summary Bar -->
                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 mb-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 font-mono text-sm" id="splitBatterySourcePurId">-</span>
                            <span class="font-bold text-slate-700 dark:text-slate-200" id="splitBatterySourceSupplier">-</span>
                        </div>
                        <div class="flex items-center gap-3 font-mono">
                            <div>Subtotal: <strong class="text-slate-800 dark:text-white" id="splitBatterySourceSubtotalDisplay">৳ 0.00</strong></div>
                            <div>Paid: <strong class="text-emerald-600 dark:text-emerald-400" id="splitBatterySourcePaidDisplay">৳ 0.00</strong></div>
                            <div>Due: <strong class="text-rose-600 dark:text-rose-400" id="splitBatterySourceDueDisplay">৳ 0.00</strong></div>
                            <div>Status: <span class="px-2 py-0.5 rounded font-bold text-[11px]" id="splitBatterySourceStatusBadge">Unpaid</span></div>
                        </div>
                    </div>
                </div>

                <!-- Products Table with Checkboxes -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">
                            Select Battery Product Lines to Move to New Invoice:
                        </label>
                        <span class="text-xs text-slate-500 dark:text-slate-400" id="splitBatterySelectionCount">0 items selected</span>
                    </div>

                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden max-h-60 overflow-y-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 sticky top-0 border-b border-slate-200 dark:border-slate-700">
                                <tr>
                                    <th class="p-2 text-center w-10">
                                        <input type="checkbox" id="splitBatterySelectAllCheckbox" onchange="toggleBatterySplitSelectAll(this.checked)" class="rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                    </th>
                                    <th class="p-2 text-center w-10">SL</th>
                                    <th class="p-2">Product Name</th>
                                    <th class="p-2 text-center w-16">Qty</th>
                                    <th class="p-2 text-end w-24">Cost Price (৳)</th>
                                    <th class="p-2 text-end w-28">Subtotal (৳)</th>
                                </tr>
                            </thead>
                            <tbody id="splitBatteryItemsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                                <tr><td colspan="6" class="p-4 text-center text-slate-400">Loading battery purchase products...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Configuration Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- New Invoice Configuration -->
                    <div class="p-3.5 rounded-xl border border-purple-200 dark:border-purple-900/50 bg-purple-50/40 dark:bg-purple-950/20">
                        <h4 class="text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-file-invoice text-sm"></i>
                            <span>New Invoice Settings (Selected Lines)</span>
                        </h4>

                        <div class="space-y-2.5 text-xs">
                            <div>
                                <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-1">New Reference No</label>
                                <input type="text" id="splitBatteryNewRefNo" class="form-control text-xs font-bold rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="Auto-generated if empty">
                            </div>
                            <div>
                                <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-1">New Invoice Discount</label>
                                <div class="flex items-center gap-1.5">
                                    <select id="splitBatteryNewDiscountType" class="form-select h-8 px-2 py-0 text-xs font-bold rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white" style="width: 60px;" onchange="recalculateBatterySplitPreview()">
                                        <option value="percent">%</option>
                                        <option value="fixed">৳</option>
                                    </select>
                                    <input type="number" step="any" min="0" id="splitBatteryNewDiscountValue" value="15" class="form-control h-8 text-end font-bold rounded-lg text-xs border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white" placeholder="0" oninput="recalculateBatterySplitPreview()">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Source Invoice (Remaining Lines) Configuration -->
                    <div class="p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/40">
                        <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-receipt text-sm"></i>
                            <span>Remaining Items Settings</span>
                        </h4>

                        <div class="space-y-2.5 text-xs">
                            <div class="flex items-center gap-2 pt-1">
                                <input type="checkbox" id="splitBatteryCustomSourceDiscount" onchange="toggleCustomBatterySourceDiscount(this.checked)" class="rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                <label for="splitBatteryCustomSourceDiscount" class="font-semibold text-slate-700 dark:text-slate-300 cursor-pointer mb-0">
                                    Customize discount on remaining items?
                                </label>
                            </div>

                            <div id="splitBatterySourceDiscountBox" style="display: none;">
                                <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-1">Remaining Discount</label>
                                <div class="flex items-center gap-1.5">
                                    <select id="splitBatterySourceDiscountType" class="form-select h-8 px-2 py-0 text-xs font-bold rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white" style="width: 60px;" onchange="recalculateBatterySplitPreview()">
                                        <option value="percent">%</option>
                                        <option value="fixed">৳</option>
                                    </select>
                                    <input type="number" step="any" min="0" id="splitBatterySourceDiscountValue" value="0" class="form-control h-8 text-end font-bold rounded-lg text-xs border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white" placeholder="0" oninput="recalculateBatterySplitPreview()">
                                </div>
                            </div>

                            <div class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                                * Default: Retains verified existing discount configuration on remaining products.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Reconciliation Comparison Card -->
                <div class="p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-2">
                        Financial Impact & Payment Reconciliation
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                        <!-- Source Remaining Preview -->
                        <div class="p-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60">
                            <div class="font-bold text-slate-800 dark:text-slate-200 mb-1.5 border-b border-slate-200 dark:border-slate-700 pb-1 flex justify-between">
                                <span>Original Invoice (Remaining)</span>
                                <span id="splitBatteryPrevRemainingCount" class="text-[11px] font-normal text-slate-500">0 items</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between"><span>Subtotal:</span><strong id="prevBatteryRemainingSubtotal">৳ 0.00</strong></div>
                                <div class="flex justify-between text-rose-500"><span>Discount:</span><strong id="prevBatteryRemainingDiscount">-৳ 0.00</strong></div>
                                <div class="flex justify-between font-bold text-slate-800 dark:text-white border-t border-slate-200 dark:border-slate-700 pt-1">
                                    <span>Net Payable:</span><strong id="prevBatteryRemainingPayable">৳ 0.00</strong>
                                </div>
                                <div class="flex justify-between text-emerald-600 dark:text-emerald-400"><span>Allocated Paid:</span><strong id="prevBatteryRemainingPaid">৳ 0.00</strong></div>
                                <div class="flex justify-between text-rose-600 dark:text-rose-400 font-bold"><span>Due Balance:</span><strong id="prevBatteryRemainingDue">৳ 0.00</strong></div>
                            </div>
                        </div>

                        <!-- New Split Preview -->
                        <div class="p-2.5 rounded-lg bg-purple-50/50 dark:bg-purple-950/20 border border-purple-200 dark:border-purple-900/50">
                            <div class="font-bold text-purple-800 dark:text-purple-300 mb-1.5 border-b border-purple-200 dark:border-purple-900/50 pb-1 flex justify-between">
                                <span>New Split Invoice</span>
                                <span id="splitBatteryPrevNewCount" class="text-[11px] font-normal text-purple-600 dark:text-purple-400">0 items</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between"><span>Subtotal:</span><strong id="prevBatteryNewSubtotal">৳ 0.00</strong></div>
                                <div class="flex justify-between text-rose-500"><span>Discount:</span><strong id="prevBatteryNewDiscount">-৳ 0.00</strong></div>
                                <div class="flex justify-between font-bold text-slate-800 dark:text-white border-t border-purple-200 dark:border-purple-900/50 pt-1">
                                    <span>Net Payable:</span><strong id="prevBatteryNewPayable">৳ 0.00</strong>
                                </div>
                                <div class="flex justify-between text-emerald-600 dark:text-emerald-400"><span>Allocated Paid:</span><strong id="prevBatteryNewPaid">৳ 0.00</strong></div>
                                <div class="flex justify-between text-rose-600 dark:text-rose-400 font-bold"><span>Due Balance:</span><strong id="prevBatteryNewDue">৳ 0.00</strong></div>
                            </div>
                        </div>
                    </div>

                    <!-- Integrity Bottom Bar -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2 text-[11.5px]">
                        <div class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-sm"></i>
                            <span>Historical Paid: <strong class="font-mono" id="splitBatteryTotalHistPaid">৳ 0.00</strong> | Allocated Sum: <strong class="font-mono" id="splitBatteryTotalAllocPaid">৳ 0.00</strong></span>
                        </div>
                        <div id="splitBatteryReconciliationStatus" class="font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Payment Reconciled (100% Intact)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-700/80 p-3.5 flex items-center justify-between gap-3">
                <button type="button" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 transition shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="confirmBatterySplitButton" onclick="submitBatterySplitPurchaseOrder()" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow transition duration-150 flex items-center gap-2 border-0 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-code-fork text-xs"></i>
                    <span>Confirm &amp; Split Invoice</span>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    let currentBatterySplitPurchase = null;

    async function openBatterySplitPurchaseModal(purchaseId) {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post("/api/battery/purchases-by-id", { id: purchaseId }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (!res.data || res.data.status !== 'success' || !res.data.rows) {
                if (typeof errorToast === 'function') errorToast(res.data?.message || "Failed to load battery purchase details");
                return;
            }

            currentBatterySplitPurchase = res.data.rows;
            populateBatterySplitModal(currentBatterySplitPurchase);
            $('#batteryPurchaseSplitModal').modal('show');
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Open Battery Split Modal Error:", e);
            if (typeof errorToast === 'function') errorToast("Failed to open split modal: " + (e.response?.data?.message || e.message));
        }
    }

    function populateBatterySplitModal(purchase) {
        document.getElementById('splitBatterySourcePurchaseId').value = purchase.id;
        document.getElementById('splitBatterySourcePurId').textContent = purchase.purchase_id || ('#PurID' + purchase.id);
        document.getElementById('splitBatterySourceSupplier').textContent = purchase.supplier?.name || 'N/A';
        
        let grandSub = parseFloat(purchase.grand_subtotal || 0);
        let paid = parseFloat(purchase.paid_amount || (purchase.payment_details ? purchase.payment_details.reduce((acc, p) => acc + parseFloat(p.paid_amount || 0), 0) : 0));
        let due = parseFloat(purchase.due_amount || 0);

        document.getElementById('splitBatterySourceSubtotalDisplay').textContent = `৳ ${grandSub.toFixed(2)}`;
        document.getElementById('splitBatterySourcePaidDisplay').textContent = `৳ ${paid.toFixed(2)}`;
        document.getElementById('splitBatterySourceDueDisplay').textContent = `৳ ${due.toFixed(2)}`;

        let badge = document.getElementById('splitBatterySourceStatusBadge');
        if (badge) {
            let status = due <= 0 ? 'Fully Paid' : (paid > 0 ? 'Partial Paid' : 'Unpaid');
            badge.textContent = status;
            badge.className = `px-2 py-0.5 rounded font-bold text-[11px] ${status === 'Fully Paid' ? 'bg-emerald-100 text-emerald-700' : (status === 'Partial Paid' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700')}`;
        }

        document.getElementById('splitBatteryNewRefNo').value = (purchase.referance_no ? purchase.referance_no + '-SPLIT' : 'SPLIT-' + Date.now());
        document.getElementById('splitBatteryNewDiscountType').value = 'percent';
        document.getElementById('splitBatteryNewDiscountValue').value = '15';

        document.getElementById('splitBatteryCustomSourceDiscount').checked = false;
        document.getElementById('splitBatterySourceDiscountBox').style.display = 'none';
        if (purchase.discount_type === 'percent' && purchase.discount_rate) {
            document.getElementById('splitBatterySourceDiscountType').value = 'percent';
            document.getElementById('splitBatterySourceDiscountValue').value = purchase.discount_rate;
        } else {
            document.getElementById('splitBatterySourceDiscountType').value = 'fixed';
            document.getElementById('splitBatterySourceDiscountValue').value = '0';
        }

        // Render line items
        const tbody = document.getElementById('splitBatteryItemsTableBody');
        tbody.innerHTML = '';

        const orderDetails = purchase.order_details || purchase.orderDetails || [];
        if (orderDetails.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-rose-500 font-bold">No product line items found in this battery purchase.</td></tr>`;
            return;
        }

        orderDetails.forEach((d, idx) => {
            const qty = parseFloat(d.quantity || 1);
            const cost = parseFloat(d.cost_price || 0);
            const lineTotal = parseFloat(d.subtotal || (qty * cost));
            const prodName = d.product?.product_name || d.product?.name || `Product #${d.product_id}`;

            const tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/60 transition cursor-pointer";
            tr.innerHTML = `
                <td class="p-2 text-center" onclick="event.stopPropagation()">
                    <input type="checkbox" class="split-battery-item-checkbox rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer" value="${d.id}" data-cost="${cost}" data-qty="${qty}" data-total="${lineTotal}" onchange="recalculateBatterySplitPreview()">
                </td>
                <td class="p-2 text-center text-slate-500 font-semibold">${idx + 1}</td>
                <td class="p-2 font-medium text-slate-800 dark:text-slate-100">${prodName}</td>
                <td class="p-2 text-center font-mono font-bold">${qty}</td>
                <td class="p-2 text-end font-mono">৳ ${cost.toFixed(2)}</td>
                <td class="p-2 text-end font-mono font-bold">৳ ${lineTotal.toFixed(2)}</td>
            `;

            tr.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    const cb = tr.querySelector('.split-battery-item-checkbox');
                    cb.checked = !cb.checked;
                    recalculateBatterySplitPreview();
                }
            });

            tbody.appendChild(tr);
        });

        recalculateBatterySplitPreview();
    }

    function toggleBatterySplitSelectAll(checked) {
        document.querySelectorAll('.split-battery-item-checkbox').forEach(cb => cb.checked = checked);
        recalculateBatterySplitPreview();
    }

    function toggleCustomBatterySourceDiscount(checked) {
        document.getElementById('splitBatterySourceDiscountBox').style.display = checked ? 'block' : 'none';
        recalculateBatterySplitPreview();
    }

    function recalculateBatterySplitPreview() {
        if (!currentBatterySplitPurchase) return;

        const allCheckboxes = Array.from(document.querySelectorAll('.split-battery-item-checkbox'));
        const selectedCheckboxes = allCheckboxes.filter(cb => cb.checked);
        const totalItemsCount = allCheckboxes.length;
        const selectedCount = selectedCheckboxes.length;
        const remainingCount = totalItemsCount - selectedCount;

        document.getElementById('splitBatterySelectionCount').textContent = `${selectedCount} of ${totalItemsCount} items selected`;
        document.getElementById('splitBatteryPrevNewCount').textContent = `${selectedCount} items`;
        document.getElementById('splitBatteryPrevRemainingCount').textContent = `${remainingCount} items`;

        let newSubtotal = 0;
        let remainingSubtotal = 0;

        allCheckboxes.forEach(cb => {
            const lineTotal = parseFloat(cb.getAttribute('data-total') || 0);
            if (cb.checked) {
                newSubtotal += lineTotal;
            } else {
                remainingSubtotal += lineTotal;
            }
        });

        // 1. New Split Discount
        const newDiscType = document.getElementById('splitBatteryNewDiscountType').value;
        const newDiscVal = parseFloat(document.getElementById('splitBatteryNewDiscountValue').value) || 0;
        let newDiscountAmount = 0;
        if (newDiscType === 'percent') {
            newDiscountAmount = (newSubtotal * newDiscVal) / 100;
        } else {
            newDiscountAmount = newDiscVal;
        }
        newDiscountAmount = Math.min(newSubtotal, Math.max(0, newDiscountAmount));
        const newNetPayable = Math.max(0, newSubtotal - newDiscountAmount);

        // 2. Remaining Source Discount
        const isCustomSource = document.getElementById('splitBatteryCustomSourceDiscount').checked;
        let remainingDiscountAmount = 0;
        if (isCustomSource) {
            const srcDiscType = document.getElementById('splitBatterySourceDiscountType').value;
            const srcDiscVal = parseFloat(document.getElementById('splitBatterySourceDiscountValue').value) || 0;
            if (srcDiscType === 'percent') {
                remainingDiscountAmount = (remainingSubtotal * srcDiscVal) / 100;
            } else {
                remainingDiscountAmount = srcDiscVal;
            }
        } else {
            if (currentBatterySplitPurchase.discount_type === 'percent' && currentBatterySplitPurchase.discount_rate) {
                remainingDiscountAmount = (remainingSubtotal * parseFloat(currentBatterySplitPurchase.discount_rate)) / 100;
            } else {
                let origFixed = parseFloat(currentBatterySplitPurchase.discount_amount || 0);
                let origGrand = parseFloat(currentBatterySplitPurchase.grand_subtotal || 0);
                if (origGrand > 0 && origFixed > 0) {
                    remainingDiscountAmount = (origFixed * (remainingSubtotal / origGrand));
                }
            }
        }
        remainingDiscountAmount = Math.min(remainingSubtotal, Math.max(0, remainingDiscountAmount));
        const remainingDelivery = parseFloat(currentBatterySplitPurchase.delivery_charge || 0);
        const remainingNetPayable = Math.max(0, (remainingSubtotal - remainingDiscountAmount) + remainingDelivery);

        // 3. Payment Allocation
        const totalPaidHist = parseFloat(currentBatterySplitPurchase.paid_amount || 0);
        const combinedPayable = remainingNetPayable + newNetPayable;

        let newPaid = 0;
        let remainingPaid = 0;

        if (combinedPayable <= 0) {
            newPaid = 0;
            remainingPaid = 0;
        } else if (totalPaidHist >= combinedPayable) {
            newPaid = newNetPayable;
            remainingPaid = remainingNetPayable;
            const excess = totalPaidHist - combinedPayable;
            if (excess > 0) {
                remainingPaid += excess;
            }
        } else {
            newPaid = Math.round((totalPaidHist * (newNetPayable / combinedPayable)) * 100) / 100;
            remainingPaid = Math.max(0, totalPaidHist - newPaid);
        }

        const newDue = Math.max(0, newNetPayable - newPaid);
        const remainingDue = Math.max(0, remainingNetPayable - remainingPaid);

        // 4. Update UI Displays
        document.getElementById('prevBatteryRemainingSubtotal').textContent = `৳ ${remainingSubtotal.toFixed(2)}`;
        document.getElementById('prevBatteryRemainingDiscount').textContent = `-৳ ${remainingDiscountAmount.toFixed(2)}`;
        document.getElementById('prevBatteryRemainingPayable').textContent = `৳ ${remainingNetPayable.toFixed(2)}`;
        document.getElementById('prevBatteryRemainingPaid').textContent = `৳ ${remainingPaid.toFixed(2)}`;
        document.getElementById('prevBatteryRemainingDue').textContent = `৳ ${remainingDue.toFixed(2)}`;

        document.getElementById('prevBatteryNewSubtotal').textContent = `৳ ${newSubtotal.toFixed(2)}`;
        document.getElementById('prevBatteryNewDiscount').textContent = `-৳ ${newDiscountAmount.toFixed(2)}`;
        document.getElementById('prevBatteryNewPayable').textContent = `৳ ${newNetPayable.toFixed(2)}`;
        document.getElementById('prevBatteryNewPaid').textContent = `৳ ${newPaid.toFixed(2)}`;
        document.getElementById('prevBatteryNewDue').textContent = `৳ ${newDue.toFixed(2)}`;

        document.getElementById('splitBatteryTotalHistPaid').textContent = `৳ ${totalPaidHist.toFixed(2)}`;
        document.getElementById('splitBatteryTotalAllocPaid').textContent = `৳ ${(remainingPaid + newPaid).toFixed(2)}`;

        // Button State
        const btn = document.getElementById('confirmBatterySplitButton');
        if (selectedCount === 0) {
            btn.disabled = true;
            btn.title = "Select at least 1 item to split";
        } else if (remainingCount === 0) {
            btn.disabled = true;
            btn.title = "At least 1 item must remain in original purchase";
        } else {
            btn.disabled = false;
            btn.title = "";
        }
    }

    async function submitBatterySplitPurchaseOrder() {
        const purchaseId = document.getElementById('splitBatterySourcePurchaseId').value;
        const selectedCheckboxes = Array.from(document.querySelectorAll('.split-battery-item-checkbox:checked'));
        const detailIds = selectedCheckboxes.map(cb => parseInt(cb.value));

        if (detailIds.length === 0) {
            if (typeof errorToast === 'function') errorToast("Please select at least one item to split.");
            return;
        }

        const isCustomSource = document.getElementById('splitBatteryCustomSourceDiscount').checked;
        const payload = {
            purchase_id: parseInt(purchaseId),
            detail_ids: detailIds,
            new_discount_type: document.getElementById('splitBatteryNewDiscountType').value,
            new_discount_rate: parseFloat(document.getElementById('splitBatteryNewDiscountValue').value) || 0,
            referance_no: document.getElementById('splitBatteryNewRefNo').value.trim() || undefined,
        };

        if (isCustomSource) {
            payload.original_discount_type = document.getElementById('splitBatterySourceDiscountType').value;
            payload.original_discount_rate = parseFloat(document.getElementById('splitBatterySourceDiscountValue').value) || 0;
        }

        const btn = document.getElementById('confirmBatterySplitButton');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-xs"></i> Splitting...`;

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post("/api/battery/split-purchase", payload, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            btn.disabled = false;
            btn.innerHTML = origText;

            if (res.data && res.data.status === 'success') {
                if (typeof successToast === 'function') successToast(res.data.message || "Battery purchase split successfully!");
                $('#batteryPurchaseSplitModal').modal('hide');
                if (typeof getList === 'function') {
                    getList();
                } else {
                    setTimeout(() => location.reload(), 600);
                }
            } else {
                if (typeof errorToast === 'function') errorToast(res.data?.message || "Failed to split battery purchase.");
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            btn.disabled = false;
            btn.innerHTML = origText;
            console.error("Submit Battery Split Error:", e);
            if (typeof errorToast === 'function') errorToast(e.response?.data?.message || "Failed to split battery purchase.");
        }
    }

    $(document).ready(function() {
        $('#batteryPurchaseSplitModal').appendTo('body');
    });
</script>
