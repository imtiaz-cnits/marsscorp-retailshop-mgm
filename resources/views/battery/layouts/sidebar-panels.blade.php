<!-- Panel 1: Battery Main Menu Panel -->
<div id="sidebar-main-panel" class="sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent ? '-translate-x-full pointer-events-none' : 'translate-x-0' }}">
  <ul class="space-y-1">
    
    <!-- 1. Dashboard -->
    <li class="sidebar-item relative group">
      <a href="{{ route('battery.dashboard') }}" class="sidebar-link w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->routeIs('battery.dashboard') ? 'active-gradient' : '' }}">
        <i class="fa-solid fa-gauge text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
        <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Battery Dashboard</span>
      </a>
      <div class="sidebar-mini-tooltip">
        Battery Dashboard
      </div>
    </li>

    <!-- 2. POS -->
    <li class="sidebar-item relative group">
      <a href="{{ route('battery.pos') }}" class="sidebar-link w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->routeIs('battery.pos') ? 'active-gradient' : '' }}">
        <i class="fa-solid fa-cash-register text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
        <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Battery POS</span>
      </a>
      <div class="sidebar-mini-tooltip">
        Battery POS
      </div>
    </li>

    <!-- 3. Invoices -->
    <li class="sidebar-item relative group">
      <a href="{{ route('battery.invoices') }}" class="sidebar-link w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->routeIs('battery.invoices') ? 'active-gradient' : '' }}">
        <i class="fa-solid fa-file-invoice-dollar text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
        <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Invoices</span>
      </a>
      <div class="sidebar-mini-tooltip">
        Invoices
      </div>
    </li>

    <!-- 4. Products (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-product">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-product' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-product">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-boxes-stacked text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Products</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Products
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.products') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.products') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-list-ul text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Product List</span></a></li>
          <li><a href="{{ route('battery.brands') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.brands') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-tag text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Brand List</span></a></li>
          <li><a href="{{ route('battery.categories') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.categories') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-layer-group text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Category List</span></a></li>
          <li><a href="{{ route('battery.sub-categories') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.sub-categories') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-sitemap text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Sub Categories</span></a></li>
          <li><a href="{{ route('battery.units') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.units') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-scale-balanced text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Unit List</span></a></li>
          <li><a href="{{ route('battery.barcode.generate') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.barcode.generate') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-barcode text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Barcode Print</span></a></li>
          <li><a href="{{ route('battery.reports.stock-out') }}" class="sidebar-flyout-link text-red-300 {{ request()->routeIs('battery.reports.stock-out') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-triangle-exclamation text-[10px] text-red-300 w-4 text-center"></i><span>Low Stock</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 5. Suppliers (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-supplier">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-supplier' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-supplier">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-truck-field text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Suppliers</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Suppliers
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.suppliers') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.suppliers') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-address-book text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Supplier List</span></a></li>
          <li><a href="{{ route('battery.supplier.due') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.supplier.due') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-file-invoice text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Supplier Due</span></a></li>
          <li><a href="{{ route('battery.supplier.due.collection') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.supplier.due.collection') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-hand-holding-dollar text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Due Collection</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 6. Purchases (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-purchase">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-purchase' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-purchase">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-cart-shopping text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Purchases</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Purchases
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.purchases') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.purchases') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-cart-arrow-down text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Purchase List</span></a></li>
          <li><a href="{{ route('battery.purchase.payments') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.purchase.payments') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-money-check-dollar text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Purchase Payments</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 7. Customers (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-customer">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-customer' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-customer">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-users text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Customers</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Customers
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.customers') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.customers') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-user-group text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Customer List</span></a></li>
          <li><a href="{{ route('battery.customer.due') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.customer.due') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-file-invoice-dollar text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Customer Due</span></a></li>
          <li><a href="{{ route('battery.customer.due.collection') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.customer.due.collection') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-hand-holding-dollar text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Due Collection (FIFO)</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 8. Expenses (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-expense">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-expense' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-expense">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-wallet text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Expenses</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Expenses
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.expenses') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.expenses') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-receipt text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Expense List</span></a></li>
          <li><a href="{{ route('battery.expense.types') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.expense.types') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-tags text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Expense Types</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 9. Returns (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-return">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-return' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-return">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-rotate-left text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Returns</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Returns
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.sales.returns') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.sales.returns') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-cart-shopping text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Sales Returns</span></a></li>
          <li><a href="{{ route('battery.purchase.returns') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.purchase.returns') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-truck-ramp-box text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Purchase Returns</span></a></li>
        </ul>
      </div>
    </li>

    <!-- 10. Opening Balance -->
    <li class="sidebar-item relative group">
      <a href="{{ route('battery.opening.balance') }}" class="sidebar-link w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->routeIs('battery.opening.balance') ? 'active-gradient' : '' }}">
        <i class="fa-solid fa-vault text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
        <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Opening Balance</span>
      </a>
      <div class="sidebar-mini-tooltip">
        Opening Balance
      </div>
    </li>

    <!-- 11. Reports (Drilldown) -->
    <li class="sidebar-item has-submenu relative group" data-menu-id="battery-report">
      <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent outline-none transition-all duration-200 text-start {{ $activeParent === 'battery-report' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-battery-report">
        <div class="flex items-center gap-2 min-w-0">
          <i class="fa-solid fa-chart-pie text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
          <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Reports</span>
        </div>
        <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
          <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </span>
      </button>
      <!-- Collapsed Flyout Popover -->
      <div class="sidebar-flyout">
        <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
          <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
            Reports
          </span>
          <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
        </div>
        <ul class="py-0.5 px-1 space-y-0.5">
          <li><a href="{{ route('battery.reports.sales') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.reports.sales') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-chart-line text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Sales Report</span></a></li>
          <li><a href="{{ route('battery.reports.daily-ledger') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.reports.daily-ledger') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-book text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Daily Ledger</span></a></li>
          <li><a href="{{ route('battery.reports.income-expense') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.reports.income-expense') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-chart-column text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Income / Expense</span></a></li>
          <li><a href="{{ route('battery.reports.daily-receipt-payment') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.reports.daily-receipt-payment') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-receipt text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Receipt & Payment</span></a></li>
          <li><a href="{{ route('battery.reports.stock-out') }}" class="sidebar-flyout-link {{ request()->routeIs('battery.reports.stock-out') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-boxes-packing text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Stock-Out Report</span></a></li>
        </ul>
      </div>
    </li>

  </ul>
</div>

<!-- Panel 2: Battery Product Submenu Panel -->
<div id="submenu-panel-battery-product" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-product' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-product">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Products</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.products') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.products') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-list-ul text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Product List</span>
      </a>
      <div class="sidebar-mini-tooltip">Product List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.brands') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.brands') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-tag text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Brand List</span>
      </a>
      <div class="sidebar-mini-tooltip">Brand List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.categories') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.categories') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-layer-group text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Category List</span>
      </a>
      <div class="sidebar-mini-tooltip">Category List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.sub-categories') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.sub-categories') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-sitemap text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Sub Categories</span>
      </a>
      <div class="sidebar-mini-tooltip">Sub Categories</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.units') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.units') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-scale-balanced text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Unit List</span>
      </a>
      <div class="sidebar-mini-tooltip">Unit List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.barcode.generate') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.barcode.generate') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-barcode text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Barcode Print</span>
      </a>
      <div class="sidebar-mini-tooltip">Barcode Print</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.reports.stock-out') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-red-200 hover:text-white hover:bg-red-600/30 font-bold transition-all duration-150 {{ request()->routeIs('battery.reports.stock-out') ? 'bg-red-600 text-white' : '' }}">
        <i class="fa-solid fa-triangle-exclamation text-xs text-red-300 w-4 text-center"></i>
        <span>Low Stock Products</span>
      </a>
      <div class="sidebar-mini-tooltip">Low Stock Products</div>
    </li>
  </ul>
</div>

<!-- Panel 3: Battery Supplier Submenu Panel -->
<div id="submenu-panel-battery-supplier" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-supplier' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-supplier">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Suppliers</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.suppliers') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.suppliers') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-address-book text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Supplier List</span>
      </a>
      <div class="sidebar-mini-tooltip">Supplier List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.supplier.due') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.supplier.due') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-file-invoice text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Supplier Due List</span>
      </a>
      <div class="sidebar-mini-tooltip">Supplier Due List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.supplier.due.collection') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.supplier.due.collection') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-hand-holding-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Due Collection</span>
      </a>
      <div class="sidebar-mini-tooltip">Due Collection</div>
    </li>
  </ul>
</div>

<!-- Panel 4: Battery Purchase Submenu Panel -->
<div id="submenu-panel-battery-purchase" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-purchase' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-purchase">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Purchases</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.purchases') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.purchases') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-cart-arrow-down text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Purchase List</span>
      </a>
      <div class="sidebar-mini-tooltip">Purchase List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.purchase.payments') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.purchase.payments') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-money-check-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Purchase Payments</span>
      </a>
      <div class="sidebar-mini-tooltip">Purchase Payments</div>
    </li>
  </ul>
</div>

<!-- Panel 5: Battery Customer Submenu Panel -->
<div id="submenu-panel-battery-customer" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-customer' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-customer">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Customers</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.customers') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.customers') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-user-group text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Customer List</span>
      </a>
      <div class="sidebar-mini-tooltip">Customer List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.customer.due') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.customer.due') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-file-invoice-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Customer Due List</span>
      </a>
      <div class="sidebar-mini-tooltip">Customer Due List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.customer.due.collection') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.customer.due.collection') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-hand-holding-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Due Collection (FIFO)</span>
      </a>
      <div class="sidebar-mini-tooltip">Due Collection (FIFO)</div>
    </li>
  </ul>
</div>

<!-- Panel 6: Battery Expense Submenu Panel -->
<div id="submenu-panel-battery-expense" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-expense' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-expense">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Expenses</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.expenses') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.expenses') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-receipt text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Expense List</span>
      </a>
      <div class="sidebar-mini-tooltip">Expense List</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.expense.types') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.expense.types') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-tags text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Expense Types</span>
      </a>
      <div class="sidebar-mini-tooltip">Expense Types</div>
    </li>
  </ul>
</div>

<!-- Panel 7: Battery Return Submenu Panel -->
<div id="submenu-panel-battery-return" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-return' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-return">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Returns</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.sales.returns') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.sales.returns') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-cart-shopping text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Sales Returns</span>
      </a>
      <div class="sidebar-mini-tooltip">Sales Returns</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.purchase.returns') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.purchase.returns') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-truck-ramp-box text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Purchase Returns</span>
      </a>
      <div class="sidebar-mini-tooltip">Purchase Returns</div>
    </li>
  </ul>
</div>

<!-- Panel 8: Battery Report Submenu Panel -->
<div id="submenu-panel-battery-report" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'battery-report' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="battery-report">
  <div class="sidebar-back-wrapper relative group mb-2">
    <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
      <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
      <span class="truncate">Reports</span>
    </button>
    <div class="sidebar-mini-tooltip">Main Menu</div>
  </div>
  <ul class="space-y-1">
    <li class="relative group">
      <a href="{{ route('battery.reports.sales') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.reports.sales') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-chart-line text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Sales Report</span>
      </a>
      <div class="sidebar-mini-tooltip">Sales Report</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.reports.daily-ledger') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.reports.daily-ledger') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-book text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Daily Ledger</span>
      </a>
      <div class="sidebar-mini-tooltip">Daily Ledger</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.reports.income-expense') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.reports.income-expense') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-chart-column text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Income / Expense</span>
      </a>
      <div class="sidebar-mini-tooltip">Income / Expense</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.reports.daily-receipt-payment') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->routeIs('battery.reports.daily-receipt-payment') ? 'active-submenu-link' : '' }}">
        <i class="fa-solid fa-receipt text-xs text-emerald-300/80 w-4 text-center"></i>
        <span>Daily Receipt &amp; Payment</span>
      </a>
      <div class="sidebar-mini-tooltip">Daily Receipt &amp; Payment</div>
    </li>
    <li class="relative group">
      <a href="{{ route('battery.reports.stock-out') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-red-200 hover:text-white hover:bg-red-600/30 font-bold transition-all duration-150 {{ request()->routeIs('battery.reports.stock-out') ? 'bg-red-600 text-white' : '' }}">
        <i class="fa-solid fa-boxes-packing text-xs text-red-300 w-4 text-center"></i>
        <span>Stock-Out Report</span>
      </a>
      <div class="sidebar-mini-tooltip">Stock-Out Report</div>
    </li>
  </ul>
</div>
