<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>@yield('title') - মার্স কর্পোরেশন (MARSS CORPORATION)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('backend/assets/icons/favicon.svg') }}" type="image/x-icon" />

  <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <!-- Bootstrap Css -->
  <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

  <!-- Vite Tailwind CSS & JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{-- <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Select2 CSS & JS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- HTML5 QR & Barcode Scanner Library -->
  <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>




  <!-- Vanilla Datepicker -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker.min.css" />




  <link href="{{ asset('backend/assets/css/navbar-sidebar.css') }}" rel="stylesheet" />
  <link href="{{ asset('backend/assets/css/user-profile.css') }}" rel="stylesheet" />
  <link href="{{ asset('backend/assets/css/all-modal.css.css') }}" rel="stylesheet" />
  <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/dark-mode.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/table-funtion.css') }}" />


  <link href="{{ asset('backend/assets/css/toastify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('backend/assets/css/progress.css') }}" rel="stylesheet" />
  <link href="{{ asset('backend/assets/css/animate.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('backend/assets/js/toastify-js.js') }}"></script>
  <script src="{{ asset('backend/assets/js/axios.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/config.js') }}"></script>

  <style>
    /* Vibrant Colorful Emerald Teal Mesh Gradient Theme for Sidebar */
    .vertical-menu {
      background: linear-gradient(165deg, #064e3b 0%, #047857 35%, #0d9488 70%, #0f766e 100%) !important;
      border-right: 1px solid rgba(255, 255, 255, 0.12) !important;
      box-shadow: 4px 0 25px rgba(4, 120, 87, 0.25) !important;
      display: flex !important;
      flex-direction: column !important;
      height: 100vh !important;
      overflow: hidden !important;
    }

    /* Prevent Duplicate Logo on Topbar on Desktop */
    #page-topbar .navbar-brand-box {
      display: none !important;
    }

    @media (min-width: 992px) {
      .navbar-top-logo-link {
        display: none !important;
      }
      #page-topbar .vertical-menu-btn {
        margin-left: 1rem !important; /* ms-3 on desktop */
      }
    }

    /* Hide any collapse button on sidebar itself */
    .vertical-menu .vertical-menu-btn,
    .vertical-menu .vertical-menu-btn2 {
      display: none !important;
    }

    /* Stylish Modern Vertical Menu Toggle Button on Topbar */
    #page-topbar .vertical-menu-btn {
      width: 38px !important;
      height: 38px !important;
      border-radius: 10px !important;
      background: #f0fdf4 !important;
      border: 1px solid #bbf7d0 !important;
      color: #047857 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      padding: 0 !important;
      box-shadow: 0 2px 4px rgba(4, 120, 87, 0.08) !important;
      transition: all 0.22s ease-in-out !important;
    }

    #page-topbar .vertical-menu-btn i {
      font-size: 17px !important;
      color: #047857 !important;
      transition: all 0.22s ease-in-out !important;
    }

    #page-topbar .vertical-menu-btn:hover {
      background: #dcfce7 !important;
      border-color: #86efac !important;
      transform: scale(1.05);
    }

    #page-topbar .vertical-menu-btn:hover i {
      color: #065f46 !important;
    }

    body[light-mode="dark"] #page-topbar .vertical-menu-btn {
      background: #1e293b !important;
      border-color: #334155 !important;
      color: #34d399 !important;
      box-shadow: none !important;
    }

    body[light-mode="dark"] #page-topbar .vertical-menu-btn i {
      color: #34d399 !important;
    }

    body[light-mode="dark"] #page-topbar .vertical-menu-btn:hover {
      background: #334155 !important;
    }

    .navbar-top-logo {
      height: 38px;
      max-width: 170px;
      object-fit: contain;
      transition: all 0.3s ease-in-out;
    }

    @media (max-width: 576px) {
      .navbar-top-logo {
        height: 30px !important;
        max-width: 130px !important;
      }
    }

    /* Sidebar Logo Header - In Normal Flex Flow so Dashboard Menu Never Enters Behind It */
    .vertical-menu .navbar-brand-box {
      position: relative !important;
      top: auto !important;
      left: auto !important;
      right: auto !important;
      width: 100% !important;
      background: rgba(6, 78, 59, 0.95) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
      height: 72px !important;
      display: flex !important;
      align-items: center !important;
      padding: 0 14px !important;
      box-shadow: none !important;
      flex-shrink: 0 !important;
    }

    /* Expanded Sidebar Logo Rules */
    .vertical-menu .navbar-brand-box .logo-sm,
    .vertical-menu .navbar-brand-box .logo-sm2 {
      display: none !important;
    }

    .vertical-menu .navbar-brand-box .logo-lg {
      display: flex !important;
      align-items: center !important;
    }

    /* Collapsed Sidebar Logo Rules */
    body[data-sidebar-size="sm"] .vertical-menu .navbar-brand-box {
      width: 70px !important;
      padding: 0 !important;
      justify-content: center !important;
    }

    body[data-sidebar-size="sm"] .vertical-menu .navbar-brand-box .logo-lg {
      display: none !important;
    }

    body[data-sidebar-size="sm"] .vertical-menu .navbar-brand-box .logo-sm {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      margin: 0 auto !important;
    }

    /* Modern Sliding Drilldown Sidebar Styles */
    .vertical-menu #sidebar-slider-wrapper {
      flex: 1 1 auto !important;
      height: calc(100vh - 138px) !important;
      max-height: calc(100vh - 138px) !important;
      width: 100% !important;
      position: relative !important;
      overflow: hidden !important;
    }

    /* Drilldown Panel Base Styles */
    .vertical-menu #sidebar-main-panel,
    .vertical-menu .sidebar-submenu-panel {
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      height: 100% !important;
      background: linear-gradient(165deg, #064e3b 0%, #047857 35%, #0d9488 70%, #0f766e 100%) !important;
      transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease, visibility 0.28s ease !important;
    }

    /* Submenu Link Styling Reset */
    .vertical-menu .sidebar-submenu-panel a {
      color: #cbd5e1 !important;
      text-decoration: none !important;
    }

    .vertical-menu .sidebar-submenu-panel a:hover {
      color: #ffffff !important;
      background: rgba(255, 255, 255, 0.12) !important;
    }

    /* Expanded (Default) Sidebar Sliding Drilldown Rules */
    .vertical-menu #sidebar-main-panel.translate-x-0 {
      transform: translateX(0) !important;
      opacity: 1 !important;
      visibility: visible !important;
      pointer-events: auto !important;
      z-index: 10 !important;
    }

    .vertical-menu #sidebar-main-panel.-translate-x-full {
      transform: translateX(-100%) !important;
      opacity: 0 !important;
      visibility: hidden !important;
      pointer-events: none !important;
      z-index: 5 !important;
    }

    .vertical-menu .sidebar-submenu-panel.translate-x-full {
      transform: translateX(100%) !important;
      opacity: 0 !important;
      visibility: hidden !important;
      pointer-events: none !important;
      z-index: 5 !important;
    }

    .vertical-menu .sidebar-submenu-panel.translate-x-0 {
      transform: translateX(0) !important;
      opacity: 1 !important;
      visibility: visible !important;
      pointer-events: auto !important;
      z-index: 20 !important;
    }

    .vertical-menu .sidebar-panel-scroll {
      scrollbar-width: thin !important;
      scrollbar-color: rgba(255, 255, 255, 0.2) transparent !important;
    }

    .vertical-menu .sidebar-panel-scroll::-webkit-scrollbar {
      width: 4px !important;
    }

    .vertical-menu .sidebar-panel-scroll::-webkit-scrollbar-track {
      background: transparent !important;
    }

    .vertical-menu .sidebar-panel-scroll::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.25) !important;
      border-radius: 4px !important;
    }

    .vertical-menu .sidebar-panel-scroll::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.45) !important;
    }

    /* Drilldown Trigger Button Reset - Fixes browser default white buttonface background */
    .vertical-menu button,
    .vertical-menu button.sidebar-drilldown-trigger {
      background: transparent !important;
      background-color: transparent !important;
      border: 0 !important;
      outline: none !important;
      box-shadow: none !important;
      -webkit-appearance: none !important;
      appearance: none !important;
      color: #f1f5f9 !important;
      font-family: inherit !important;
      cursor: pointer !important;
    }

    .vertical-menu button.sidebar-drilldown-trigger:hover {
      background: rgba(255, 255, 255, 0.12) !important;
      background-color: rgba(255, 255, 255, 0.12) !important;
      color: #ffffff !important;
    }

    .vertical-menu button.sidebar-drilldown-trigger:hover i {
      color: #d1fae5 !important;
    }

    /* Active State Gradient Styling */
    .vertical-menu .active-gradient,
    .vertical-menu .active-parent,
    .vertical-menu button.sidebar-drilldown-trigger.active-parent {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      background-color: #059669 !important;
      color: #ffffff !important;
      font-weight: 600 !important;
      border-left: 3px solid #34d399 !important;
      box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35) !important;
    }

    .vertical-menu .active-gradient i,
    .vertical-menu .active-parent i,
    .vertical-menu button.sidebar-drilldown-trigger.active-parent i {
      color: #ffffff !important;
      filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.6)) !important;
    }

    .vertical-menu .active-submenu-link {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: #ffffff !important;
      font-weight: 600 !important;
      border-radius: 9px !important;
      box-shadow: 0 2px 10px rgba(16, 185, 129, 0.35) !important;
    }

    .vertical-menu button.sidebar-back-btn {
      border: 1px solid rgba(255, 255, 255, 0.18) !important;
      background: rgba(255, 255, 255, 0.1) !important;
      color: #d1fae5 !important;
      cursor: pointer !important;
      outline: none !important;
    }

    .vertical-menu button.sidebar-back-btn:hover {
      background: rgba(255, 255, 255, 0.2) !important;
      color: #ffffff !important;
    }

    /* Default (Expanded) rules for flyouts and tooltips - Strictly hidden */
    body:not([data-sidebar-size="sm"]) .sidebar-flyout,
    body:not([data-sidebar-size="sm"]) .sidebar-mini-tooltip {
      display: none !important;
      opacity: 0 !important;
      visibility: hidden !important;
      pointer-events: none !important;
    }

    /* Collapsed Sidebar (sm) Rules */
    body[data-sidebar-size="sm"] .vertical-menu {
      width: 70px !important;
      overflow: visible !important;
      z-index: 1005 !important;
    }

    body[data-sidebar-size="sm"] .vertical-menu #sidebar-slider-wrapper {
      overflow: visible !important;
      height: calc(100vh - 138px) !important;
    }

    body[data-sidebar-size="sm"] #sidebar-main-panel {
      width: 70px !important;
      overflow: visible !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    body[data-sidebar-size="sm"] #sidebar-main-panel.translate-x-0 {
      display: block !important;
      transform: translateX(0) !important;
      pointer-events: auto !important;
    }

    body[data-sidebar-size="sm"] #sidebar-main-panel.-translate-x-full {
      display: none !important;
      pointer-events: none !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel {
      width: 70px !important;
      overflow: visible !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel.translate-x-full {
      display: none !important;
      pointer-events: none !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel.translate-x-0 {
      display: block !important;
      transform: translateX(0) !important;
      pointer-events: auto !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel .sidebar-back-wrapper {
      margin-bottom: 6px !important;
      width: 100% !important;
      display: flex !important;
      justify-content: center !important;
      position: relative !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel ul {
      padding: 0 !important;
      margin: 0 !important;
    }

    body[data-sidebar-size="sm"] .sidebar-submenu-panel li {
      display: flex !important;
      justify-content: center !important;
      width: 100% !important;
      position: relative !important;
    }

    body[data-sidebar-size="sm"] .sidebar-label,
    body[data-sidebar-size="sm"] .sidebar-arrow,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel .sidebar-back-btn span,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel a span {
      display: none !important;
    }

    body[data-sidebar-size="sm"] .sidebar-link,
    body[data-sidebar-size="sm"] .sidebar-drilldown-trigger,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel a,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel .sidebar-back-btn {
      justify-content: center !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      width: 44px !important;
      height: 44px !important;
      margin: 4px auto !important;
      border-radius: 10px !important;
      border-left: none !important;
    }

    body[data-sidebar-size="sm"] .sidebar-link i,
    body[data-sidebar-size="sm"] .sidebar-drilldown-trigger i,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel a i,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel .sidebar-back-btn i {
      margin: 0 auto !important;
      width: auto !important;
      font-size: 16px !important;
    }

    /* Trendy Single-Item Mini Tooltip (Hidden by default, shown ONLY on hover) */
    .vertical-menu .sidebar-mini-tooltip {
      display: none !important;
      opacity: 0 !important;
      visibility: hidden !important;
      pointer-events: none !important;
      position: absolute !important;
      left: 100% !important;
      top: 50% !important;
      margin-left: 12px !important;
      transform: translateY(-50%) translateX(-6px) scale(0.95) !important;
      transition: opacity 0.15s ease, transform 0.15s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.15s !important;
      padding: 6px 14px !important;
      background: linear-gradient(135deg, #064e3b 0%, #0a251e 55%, #0f172a 100%) !important;
      color: #ecfdf5 !important;
      font-family: 'Valley Sans', 'Baloo Da 2', sans-serif !important;
      font-size: 12.5px !important;
      font-weight: 600 !important;
      letter-spacing: 0.3px !important;
      border-radius: 9px !important;
      border: 1px solid rgba(52, 211, 153, 0.45) !important;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.65), 0 0 15px rgba(16, 185, 129, 0.25) !important;
      white-space: nowrap !important;
      z-index: 99999 !important;
      backdrop-filter: blur(12px) !important;
      -webkit-backdrop-filter: blur(12px) !important;
    }

    .vertical-menu .sidebar-mini-tooltip::before {
      content: '' !important;
      position: absolute !important;
      left: -5px !important;
      top: 50% !important;
      transform: translateY(-50%) rotate(45deg) !important;
      width: 9px !important;
      height: 9px !important;
      background: #064e3b !important;
      border-left: 1px solid rgba(52, 211, 153, 0.45) !important;
      border-bottom: 1px solid rgba(52, 211, 153, 0.45) !important;
    }

    body[data-sidebar-size="sm"] .sidebar-item:not(.has-submenu):hover .sidebar-mini-tooltip,
    body[data-sidebar-size="sm"] .sidebar-bottom-logout:hover .sidebar-mini-tooltip,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel li:hover .sidebar-mini-tooltip,
    body[data-sidebar-size="sm"] .sidebar-submenu-panel .sidebar-back-wrapper:hover .sidebar-mini-tooltip {
      display: flex !important;
      align-items: center !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateY(-50%) translateX(0) scale(1) !important;
    }

    /* Modern & Trendy Dropdown Flyout Popover */
    body[data-sidebar-size="sm"] .has-submenu .sidebar-flyout {
      display: block !important;
      position: absolute !important;
      left: 100% !important;
      top: 0 !important;
      margin-left: 10px !important;
      opacity: 0 !important;
      visibility: hidden !important;
      pointer-events: none !important;
      transform: translateX(8px) scale(0.96) !important;
      transition: opacity 0.18s cubic-bezier(0.16, 1, 0.3, 1), transform 0.18s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.18s !important;
      z-index: 99999 !important;
      
      background: linear-gradient(165deg, rgba(6, 78, 59, 0.98) 0%, rgba(6, 44, 35, 0.98) 45%, rgba(15, 23, 42, 0.99) 100%) !important;
      backdrop-filter: blur(20px) !important;
      -webkit-backdrop-filter: blur(20px) !important;
      border: 1px solid rgba(52, 211, 153, 0.35) !important;
      border-radius: 14px !important;
      box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.7), 0 0 25px rgba(16, 185, 129, 0.2) !important;
      padding: 8px !important;
      width: 240px !important;
    }

    /* Invisible hover bridge to prevent pointer flicker when moving cursor from icon to flyout */
    body[data-sidebar-size="sm"] .has-submenu .sidebar-flyout::before {
      content: '' !important;
      position: absolute !important;
      top: -16px !important;
      bottom: -16px !important;
      left: -24px !important;
      width: 26px !important;
      background: transparent !important;
      pointer-events: auto !important;
    }

    /* Elegant Caret indicator */
    body[data-sidebar-size="sm"] .has-submenu .sidebar-flyout::after {
      content: '' !important;
      position: absolute !important;
      left: -6px !important;
      top: 18px !important;
      width: 10px !important;
      height: 10px !important;
      background: #064e3b !important;
      border-left: 1px solid rgba(52, 211, 153, 0.35) !important;
      border-bottom: 1px solid rgba(52, 211, 153, 0.35) !important;
      transform: rotate(45deg) !important;
      pointer-events: none !important;
    }

    /* Show flyout on hover or pinned */
    body[data-sidebar-size="sm"] .has-submenu:hover .sidebar-flyout,
    body[data-sidebar-size="sm"] .has-submenu.flyout-open .sidebar-flyout,
    body[data-sidebar-size="sm"] .has-submenu .sidebar-flyout:hover,
    body[data-sidebar-size="sm"] .has-submenu .sidebar-flyout.flyout-pinned {
      opacity: 1 !important;
      visibility: visible !important;
      pointer-events: auto !important;
      transform: translateX(0) scale(1) !important;
    }

    /* Flyout Links Styling */
    .vertical-menu .sidebar-flyout-link {
      color: #e2e8f0 !important;
      text-decoration: none !important;
      display: flex !important;
      align-items: center !important;
      gap: 9px !important;
      padding: 7px 10px !important;
      border-radius: 8px !important;
      font-size: 12.5px !important;
      font-weight: 500 !important;
      transition: all 0.15s ease !important;
    }

    .vertical-menu .sidebar-flyout-link:hover {
      color: #ffffff !important;
      background: rgba(16, 185, 129, 0.25) !important;
      transform: translateX(3px) !important;
    }

    .vertical-menu .sidebar-flyout-link.active-flyout-link {
      color: #ffffff !important;
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      font-weight: 600 !important;
      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4) !important;
    }

    /* Fixed Bottom Logout Section - Harmonious Emerald Green Theme */
    .vertical-menu .sidebar-bottom-logout {
      flex-shrink: 0 !important;
      margin-top: auto !important;
      padding: 10px 12px !important;
      border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
      background: rgba(6, 78, 59, 0.95) !important;
      box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.15) !important;
    }

    .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn {
      display: flex !important;
      align-items: center !important;
      gap: 8px !important;
      color: #d1fae5 !important;
      font-weight: 600 !important;
      font-size: 14px !important;
      padding: 9px 12px !important;
      border-radius: 9px !important;
      text-decoration: none !important;
      background: rgba(255, 255, 255, 0.09) !important;
      border: 1px solid rgba(255, 255, 255, 0.18) !important;
      transition: all 0.22s ease-in-out !important;
    }

    .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn:hover {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.85) 0%, rgba(5, 150, 105, 0.95) 100%) !important;
      color: #ffffff !important;
      border-color: rgba(52, 211, 153, 0.5) !important;
      transform: translateY(-1px);
      box-shadow: 0 4px 14px rgba(6, 78, 59, 0.45) !important;
    }

    .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn i.icon {
      color: #6ee7b7 !important;
      font-size: 16px !important;
      width: 24px !important;
      text-align: center !important;
      transition: all 0.22s ease-in-out !important;
    }

    .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn:hover i.icon {
      color: #ffffff !important;
      transform: scale(1.15);
    }

    /* Collapsed Sidebar (sm) Rules for Fixed Logout */
    body[data-sidebar-size="sm"] .vertical-menu .sidebar-bottom-logout {
      padding: 8px 4px !important;
    }

    body[data-sidebar-size="sm"] .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn {
      justify-content: center !important;
      padding: 9px 0 !important;
      margin: 0 auto !important;
      width: 44px !important;
      height: 44px !important;
    }

    body[data-sidebar-size="sm"] .vertical-menu .sidebar-bottom-logout .sidebar-logout-btn .text {
      display: none !important;
    }

    /* Comprehensive Dark Mode Card & Section Overrides */
    body[light-mode="dark"],
    body[data-layout-mode="dark"],
    body[data-sidebar="dark"],
    body.dark-mode {
      background-color: #0f172a !important;
      color: #f8fafc !important;
    }

    body[light-mode="dark"] .main-content,
    body[data-layout-mode="dark"] .main-content,
    body[data-sidebar="dark"] .main-content,
    body[light-mode="dark"] .page-content,
    body[data-layout-mode="dark"] .page-content,
    body[data-sidebar="dark"] .page-content {
      background-color: #0f172a !important;
    }

    /* Card & Card Header Dark Mode Styling */
    body[light-mode="dark"] .card,
    body[data-layout-mode="dark"] .card,
    body[data-sidebar="dark"] .card,
    body[light-mode="dark"] .card-body,
    body[data-layout-mode="dark"] .card-body {
      background: #1e293b !important;
      border-color: rgba(255, 255, 255, 0.08) !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
    }

    body[light-mode="dark"] .card-header,
    body[data-layout-mode="dark"] .card-header,
    body[light-mode="dark"] .bg-white,
    body[data-layout-mode="dark"] .bg-white {
      background-color: #1e293b !important;
      color: #f8fafc !important;
      border-bottom-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Inner bg-light boxes (e.g. Monthly Summary Boxes) */
    body[light-mode="dark"] .bg-light,
    body[data-layout-mode="dark"] .bg-light,
    body[data-sidebar="dark"] .bg-light,
    body.dark-mode .bg-light,
    body[light-mode="dark"] .bg-light-subtle,
    body[data-layout-mode="dark"] .bg-light-subtle {
      background-color: #0f172a !important;
      color: #f8fafc !important;
      border-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Badges & Buttons */
    body[light-mode="dark"] .badge.bg-light,
    body[data-layout-mode="dark"] .badge.bg-light,
    body[light-mode="dark"] .badge.bg-success-subtle,
    body[data-layout-mode="dark"] .badge.bg-success-subtle,
    body[light-mode="dark"] .badge.bg-danger-subtle,
    body[data-layout-mode="dark"] .badge.bg-danger-subtle,
    body[light-mode="dark"] .badge.bg-warning-subtle,
    body[data-layout-mode="dark"] .badge.bg-warning-subtle,
    body[light-mode="dark"] .badge.bg-teal-subtle,
    body[data-layout-mode="dark"] .badge.bg-teal-subtle {
      background-color: #334155 !important;
      color: #f8fafc !important;
      border-color: rgba(255, 255, 255, 0.15) !important;
    }

    /* Specific Summary Card Gradients in Dark Mode */
    body[light-mode="dark"] .card[style*="linear-gradient"],
    body[data-layout-mode="dark"] .card[style*="linear-gradient"] {
      background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%) !important;
    }

    /* Typography & Number Colors inside Dark Cards */
    body[light-mode="dark"] .text-dark,
    body[data-layout-mode="dark"] .text-dark,
    body[light-mode="dark"] h1,
    body[light-mode="dark"] h2,
    body[light-mode="dark"] h3,
    body[light-mode="dark"] h4,
    body[light-mode="dark"] h5,
    body[light-mode="dark"] h6,
    body[data-layout-mode="dark"] h1,
    body[data-layout-mode="dark"] h2,
    body[data-layout-mode="dark"] h3,
    body[data-layout-mode="dark"] h4,
    body[data-layout-mode="dark"] h5,
    body[data-layout-mode="dark"] h6 {
      color: #f8fafc !important;
    }

    body[light-mode="dark"] .text-muted,
    body[data-layout-mode="dark"] .text-muted {
      color: #94a3b8 !important;
    }

    body[light-mode="dark"] .text-success,
    body[data-layout-mode="dark"] .text-success {
      color: #4ade80 !important;
    }

    body[light-mode="dark"] .text-primary,
    body[data-layout-mode="dark"] .text-primary {
      color: #38bdf8 !important;
    }

    body[light-mode="dark"] .text-info,
    body[data-layout-mode="dark"] .text-info {
      color: #22d3ee !important;
    }

    body[light-mode="dark"] .style-purple,
    body[data-layout-mode="dark"] .style-purple,
    body[light-mode="dark"] [style*="color: #7c3aed"],
    body[data-layout-mode="dark"] [style*="color: #7c3aed"] {
      color: #c084fc !important;
    }

    body[light-mode="dark"] .text-orange,
    body[data-layout-mode="dark"] .text-orange,
    body[light-mode="dark"] [style*="color: #ea580c"],
    body[data-layout-mode="dark"] [style*="color: #ea580c"] {
      color: #fb923c !important;
    }

    body[light-mode="dark"] [style*="color: #0d9488"],
    body[data-layout-mode="dark"] [style*="color: #0d9488"] {
      color: #2dd4bf !important;
    }

    /* Tables & Table Cells in Dark Mode */
    body[light-mode="dark"] .table,
    body[data-layout-mode="dark"] .table {
      color: #f8fafc !important;
      background-color: #1e293b !important;
    }

    body[light-mode="dark"] .table th,
    body[light-mode="dark"] .table td,
    body[data-layout-mode="dark"] .table th,
    body[data-layout-mode="dark"] .table td,
    body[light-mode="dark"] .table thead.bg-light th,
    body[data-layout-mode="dark"] .table thead.bg-light th {
      background-color: #0f172a !important;
      color: #f8fafc !important;
      border-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Quick Action Outline Buttons in Dark Mode */
    body[light-mode="dark"] .btn-outline-dark,
    body[data-layout-mode="dark"] .btn-outline-dark {
      color: #cbd5e1 !important;
      border-color: #475569 !important;
    }

    body[light-mode="dark"] .btn-outline-dark:hover,
    body[data-layout-mode="dark"] .btn-outline-dark:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }

    /* ApexCharts Text in Dark Mode */
    body[light-mode="dark"] .apexcharts-text,
    body[data-layout-mode="dark"] .apexcharts-text,
    body[light-mode="dark"] .apexcharts-title-text,
    body[data-layout-mode="dark"] .apexcharts-title-text,
    body[light-mode="dark"] .apexcharts-legend-text,
    body[data-layout-mode="dark"] .apexcharts-legend-text {
      fill: #cbd5e1 !important;
      color: #cbd5e1 !important;
    }
    /* ========================================================
       Topbar Action Buttons (Theme Toggle, Fullscreen, Notification Bell)
       Identical to POS page: 30px x 30px, Radius: 8px, Soft border & background
       ======================================================== */
    .pos-theme-toggle-btn,
    .pos-fullscreen-btn,
    .pos-noti-btn {
      width: 30px !important;
      height: 30px !important;
      min-width: 30px !important;
      min-height: 30px !important;
      border-radius: 8px !important;
      background: #f1f5f9 !important;
      border: 1px solid #cbd5e1 !important;
      color: #334155 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      padding: 0 !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      position: relative !important;
      box-shadow: none !important;
    }
    .pos-theme-toggle-btn:hover,
    .pos-fullscreen-btn:hover,
    .pos-noti-btn:hover {
      background: #e2e8f0 !important;
      color: #0f172a !important;
    }

    /* Theme Toggle Moon / Sun Icon Switching */
    .pos-theme-toggle-btn .icon-moon {
      display: inline-block !important;
      font-size: 13px !important;
      color: #334155 !important;
      transition: transform 0.2s ease !important;
    }
    .pos-theme-toggle-btn .icon-sun {
      display: none !important;
      font-size: 13px !important;
      color: #eab308 !important;
      transition: transform 0.2s ease !important;
    }

    /* When in Dark Mode: Switch Moon -> Sun */
    body[light-mode="dark"] .pos-theme-toggle-btn .icon-moon,
    body[data-layout-mode="dark"] .pos-theme-toggle-btn .icon-moon,
    html[light-mode="dark"] .pos-theme-toggle-btn .icon-moon,
    body.dark-mode .pos-theme-toggle-btn .icon-moon {
      display: none !important;
    }
    body[light-mode="dark"] .pos-theme-toggle-btn .icon-sun,
    body[data-layout-mode="dark"] .pos-theme-toggle-btn .icon-sun,
    html[light-mode="dark"] .pos-theme-toggle-btn .icon-sun,
    body.dark-mode .pos-theme-toggle-btn .icon-sun {
      display: inline-block !important;
    }

    /* Fullscreen enter / leave icons */
    .pos-fullscreen-btn svg {
      width: 13px !important;
      height: 13px !important;
      display: block !important;
      stroke: currentColor !important;
    }
    .pos-fullscreen-btn .icon-fullscreen-enter {
      display: inline-block !important;
    }
    .pos-fullscreen-btn .icon-fullscreen-leave {
      display: none !important;
    }
    .pos-fullscreen-btn.on .icon-fullscreen-enter {
      display: none !important;
    }
    .pos-fullscreen-btn.on .icon-fullscreen-leave {
      display: inline-block !important;
    }

    /* Notification Bell Icon */
    .pos-noti-btn i {
      font-size: 13px !important;
      color: #334155 !important;
    }

    /* Notification Badge */
    #noti-count-badge {
      position: absolute !important;
      top: -4px !important;
      right: -4px !important;
      font-size: 9px !important;
      font-weight: 700 !important;
      padding: 1.5px 4.5px !important;
      border-radius: 999px !important;
      background-color: #ef4444 !important;
      color: #ffffff !important;
      border: 1.5px solid #ffffff !important;
      line-height: 1 !important;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
    }

    /* Action Buttons Dark Mode */
    body[light-mode="dark"] .pos-theme-toggle-btn,
    body[data-layout-mode="dark"] .pos-theme-toggle-btn,
    html[light-mode="dark"] .pos-theme-toggle-btn,
    body.dark-mode .pos-theme-toggle-btn,
    body[light-mode="dark"] .pos-fullscreen-btn,
    body[data-layout-mode="dark"] .pos-fullscreen-btn,
    html[light-mode="dark"] .pos-fullscreen-btn,
    body.dark-mode .pos-fullscreen-btn,
    body[light-mode="dark"] .pos-noti-btn,
    body[data-layout-mode="dark"] .pos-noti-btn,
    html[light-mode="dark"] .pos-noti-btn,
    body.dark-mode .pos-noti-btn {
      background: #1e293b !important;
      border-color: #334155 !important;
      color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .pos-theme-toggle-btn:hover,
    body[data-layout-mode="dark"] .pos-theme-toggle-btn:hover,
    html[light-mode="dark"] .pos-theme-toggle-btn:hover,
    body.dark-mode .pos-theme-toggle-btn:hover,
    body[light-mode="dark"] .pos-fullscreen-btn:hover,
    body[data-layout-mode="dark"] .pos-fullscreen-btn:hover,
    html[light-mode="dark"] .pos-fullscreen-btn:hover,
    body.dark-mode .pos-fullscreen-btn:hover,
    body[light-mode="dark"] .pos-noti-btn:hover,
    body[data-layout-mode="dark"] .pos-noti-btn:hover,
    html[light-mode="dark"] .pos-noti-btn:hover,
    body.dark-mode .pos-noti-btn:hover {
      background: #334155 !important;
      color: #ffffff !important;
    }
    body[light-mode="dark"] .pos-noti-btn i,
    body[data-layout-mode="dark"] .pos-noti-btn i,
    html[light-mode="dark"] .pos-noti-btn i,
    body.dark-mode .pos-noti-btn i {
      color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #noti-count-badge,
    body[data-layout-mode="dark"] #noti-count-badge,
    html[light-mode="dark"] #noti-count-badge,
    body.dark-mode #noti-count-badge {
      border-color: #1e293b !important;
    }

    /* ========================================================
       Modern Trendy Compact Notification Dropdown
       ======================================================== */
    .page-header-notifications-dropdown-v {
      width: 340px !important;
      max-width: 94vw !important;
      border-radius: 12px !important;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
      border: 1px solid #e2e8f0 !important;
      background: #ffffff !important;
      overflow: hidden !important;
      padding: 0 !important;
    }
    @media (max-width: 575.98px) {
      .page-header-notifications-dropdown-v {
        width: calc(100vw - 20px) !important;
        max-width: calc(100vw - 20px) !important;
        right: -50px !important;
      }
    }

    /* Notification Header */
    .stock-noti-header {
      padding: 8px 12px !important;
      background: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
    }
    .stock-noti-header .noti-title-wrap {
      display: flex !important;
      align-items: center !important;
      gap: 8px !important;
    }
    .stock-noti-header .noti-icon-badge {
      width: 24px !important;
      height: 24px !important;
      border-radius: 6px !important;
      background: #fee2e2 !important;
      color: #ef4444 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 11px !important;
    }
    .stock-noti-header .noti-title {
      font-size: 12.5px !important;
      font-weight: 700 !important;
      color: #0f172a !important;
      line-height: 1.2 !important;
      margin: 0 !important;
    }
    .stock-noti-header .noti-subtitle {
      font-size: 10.5px !important;
      color: #64748b !important;
      margin: 0 !important;
      line-height: 1.2 !important;
    }
    .stock-noti-header .noti-view-all-btn {
      font-size: 11px !important;
      font-weight: 600 !important;
      padding: 3px 8px !important;
      border-radius: 6px !important;
      background: #fef2f2 !important;
      color: #dc2626 !important;
      border: 1px solid #fecaca !important;
      text-decoration: none !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 4px !important;
      transition: all 0.15s ease !important;
    }
    .stock-noti-header .noti-view-all-btn:hover {
      background: #fee2e2 !important;
      color: #b91c1c !important;
    }

    /* Notification Items Container */
    #notification-items-list {
      max-height: 310px !important;
      overflow-y: auto !important;
      scrollbar-width: thin !important;
      scrollbar-color: #cbd5e1 transparent !important;
    }
    #notification-items-list::-webkit-scrollbar {
      width: 5px !important;
    }
    #notification-items-list::-webkit-scrollbar-track {
      background: transparent !important;
    }
    #notification-items-list::-webkit-scrollbar-thumb {
      background-color: #cbd5e1 !important;
      border-radius: 10px !important;
    }

    /* Compact Modern Item - Uses stock-noti-item to avoid navbar-sidebar.css conflict */
    .stock-noti-item {
      display: flex !important;
      align-items: center !important;
      gap: 10px !important;
      padding: 7px 12px !important;
      border-bottom: 1px solid #f1f5f9 !important;
      text-decoration: none !important;
      background: #ffffff !important;
      transition: background-color 0.15s ease !important;
    }
    .stock-noti-item:last-child {
      border-bottom: none !important;
    }
    .stock-noti-item:hover {
      background: #f8fafc !important;
    }
    .stock-noti-item .item-icon-box {
      width: 28px !important;
      height: 28px !important;
      min-width: 28px !important;
      border-radius: 6px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 12px !important;
      flex-shrink: 0 !important;
    }
    .stock-noti-item .item-body {
      flex: 1 !important;
      min-width: 0 !important;
    }
    .stock-noti-item .item-row-top {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 6px !important;
      margin-bottom: 2px !important;
    }
    .stock-noti-item .item-name {
      font-size: 12px !important;
      font-weight: 600 !important;
      color: #1e293b !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      max-width: 170px !important;
      line-height: 1.3 !important;
      margin: 0 !important;
    }
    .stock-noti-item .item-badge {
      font-size: 9px !important;
      font-weight: 700 !important;
      padding: 1.5px 5px !important;
      border-radius: 4px !important;
      white-space: nowrap !important;
      line-height: 1.2 !important;
    }
    .stock-noti-item .item-badge-danger {
      background: #fef2f2 !important;
      color: #dc2626 !important;
      border: 1px solid #fecaca !important;
    }
    .stock-noti-item .item-badge-warning {
      background: #fffbeb !important;
      color: #d97706 !important;
      border: 1px solid #fde68a !important;
    }
    .stock-noti-item .item-row-bottom {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 6px !important;
      line-height: 1.2 !important;
    }
    .stock-noti-item .item-code {
      font-size: 10.5px !important;
      color: #64748b !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      max-width: 140px !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 3px !important;
    }
    .stock-noti-item .item-stock {
      font-size: 11px !important;
      font-weight: 600 !important;
      white-space: nowrap !important;
    }

    /* Notification Footer */
    .stock-noti-footer {
      padding: 6px 12px !important;
      background: #f8fafc !important;
      border-top: 1px solid #e2e8f0 !important;
      text-align: center !important;
    }
    .stock-noti-footer a {
      font-size: 11px !important;
      font-weight: 600 !important;
      color: #dc2626 !important;
      text-decoration: none !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 5px !important;
    }
    .stock-noti-footer a:hover {
      color: #b91c1c !important;
      text-decoration: underline !important;
    }

    /* Dark Mode Notification Styles */
    body[light-mode="dark"] .page-header-notifications-dropdown-v,
    body[data-layout-mode="dark"] .page-header-notifications-dropdown-v,
    html[light-mode="dark"] .page-header-notifications-dropdown-v,
    body.dark-mode .page-header-notifications-dropdown-v {
      background: #1e293b !important;
      border-color: #334155 !important;
    }
    body[light-mode="dark"] .stock-noti-header,
    body[data-layout-mode="dark"] .stock-noti-header,
    html[light-mode="dark"] .stock-noti-header,
    body.dark-mode .stock-noti-header {
      background: #0f172a !important;
      border-bottom-color: #334155 !important;
    }
    body[light-mode="dark"] .stock-noti-header .noti-title,
    body[data-layout-mode="dark"] .stock-noti-header .noti-title,
    html[light-mode="dark"] .stock-noti-header .noti-title,
    body.dark-mode .stock-noti-header .noti-title {
      color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .stock-noti-header .noti-subtitle,
    body[data-layout-mode="dark"] .stock-noti-header .noti-subtitle,
    html[light-mode="dark"] .stock-noti-header .noti-subtitle,
    body.dark-mode .stock-noti-header .noti-subtitle {
      color: #94a3b8 !important;
    }
    body[light-mode="dark"] .stock-noti-item,
    body[data-layout-mode="dark"] .stock-noti-item,
    html[light-mode="dark"] .stock-noti-item,
    body.dark-mode .stock-noti-item {
      background: #1e293b !important;
      border-bottom-color: #334155 !important;
    }
    body[light-mode="dark"] .stock-noti-item:hover,
    body[data-layout-mode="dark"] .stock-noti-item:hover,
    html[light-mode="dark"] .stock-noti-item:hover,
    body.dark-mode .stock-noti-item:hover {
      background: #334155 !important;
    }
    body[light-mode="dark"] .stock-noti-item .item-name,
    body[data-layout-mode="dark"] .stock-noti-item .item-name,
    html[light-mode="dark"] .stock-noti-item .item-name,
    body.dark-mode .stock-noti-item .item-name {
      color: #f8fafc !important;
    }
    body[light-mode="dark"] .stock-noti-item .item-code,
    body[data-layout-mode="dark"] .stock-noti-item .item-code,
    html[light-mode="dark"] .stock-noti-item .item-code,
    body.dark-mode .stock-noti-item .item-code {
      color: #94a3b8 !important;
    }
    body[light-mode="dark"] .stock-noti-footer,
    body[data-layout-mode="dark"] .stock-noti-footer,
    html[light-mode="dark"] .stock-noti-footer,
    body.dark-mode .stock-noti-footer {
      background: #0f172a !important;
      border-top-color: #334155 !important;
    }
  </style>

</head>

<body>

  <div id="loader" class="LoadingOverlay d-none">
    <div class="Line-Progress">
      <div class="indeterminate"></div>
    </div>
  </div>




  <!-- Navbar Start -->
  <nav id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
      <div class="d-flex align-items-center">
        <button type="button" class="btn header-item waves-effect vertical-menu-btn d-inline-flex align-items-center justify-content-center ms-3"
          title="Sidebar Toggle" aria-label="Toggle Sidebar">
          <i class="fa-solid fa-bars-staggered"></i>
        </button>

        <a href="{{ url('/admin-dashboard-home') }}" class="navbar-top-logo-link d-flex d-lg-none align-items-center ms-2 text-decoration-none py-1">
          <img src="{{ asset('backend/assets/img/marss-corporation-logo.svg') }}" alt="মার্স কর্পোরেশন (MARSS CORPORATION)" class="navbar-top-logo" style="height: 38px; max-width: 170px; object-fit: contain;" />
        </a>

        <!-- navbar searchbar -->
        {{-- <div class="search-bar-box d-flex align-items-center">
          <input type="text" placeholder="Search..." />
          <button class="nav-src-btn">
            <svg width="22" height="22" viewBox="0 0 27 27" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M19.2967 16.9811H18.0695L17.6449 16.5566C19.1578 14.8045 20.0686 12.5274 20.0686 10.0343C20.0686 4.49228 15.5763 0 10.0343 0C4.49228 0 0 4.49228 0 10.0343C0 15.5763 4.49228 20.0686 10.0343 20.0686C12.5274 20.0686 14.8045 19.1578 16.5566 17.6527L16.9811 18.0772V19.2967L24.6998 27L27 24.6998L19.2967 16.9811ZM10.0343 16.9811C6.19811 16.9811 3.08748 13.8705 3.08748 10.0343C3.08748 6.19811 6.19811 3.08748 10.0343 3.08748C13.8705 3.08748 16.9811 6.19811 16.9811 10.0343C16.9811 13.8705 13.8705 16.9811 10.0343 16.9811Z"
                fill="#192045" />
            </svg>
          </button>
        </div> --}}
        <!-- end navbar searchbar -->
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="button" class="pos-theme-toggle-btn" aria-label="Toggle Light/Dark Mode"
            onclick="toggle_light_mode()" title="লাইট/ডার্ক থিম পরিবর্তন">
            <i class="fa-regular fa-moon icon-moon"></i>
            <i class="fa-regular fa-sun icon-sun"></i>
        </button>

        <div class="fullscreen d-flex align-items-center">
          <button type="button" class="js-toggle-fullscreen-btn pos-fullscreen-btn" aria-label="Enter fullscreen mode" title="ফুলস্ক্রিন মোড">
            <svg class="icon-fullscreen-enter" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
            </svg>
            <svg class="icon-fullscreen-leave" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 14h6v6M20 10h-6V4M14 10l7-7M3 21l7-7"/>
            </svg>
          </button>
        </div>

        <div class="dropdown d-inline-block position-relative">
          <button type="button" class="pos-noti-btn position-relative"
            id="page-header-notifications-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" title="কম স্টক নোটিফিকেশন">
            <i class="fa-regular fa-bell"></i>
            <span id="noti-count-badge" class="badge rounded-pill bg-danger" style="display: none;">0</span>
          </button>
          <div class="dropdown-menu dropdown-menu-end p-0 page-header-notifications-dropdown-v shadow-lg border-0"
            aria-labelledby="page-header-notifications-dropdown-v">
            <div class="stock-noti-header">
              <div class="noti-title-wrap">
                <div class="noti-icon-badge">
                  <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                  <h6 class="noti-title">স্টক নোটিফিকেশন</h6>
                  <p class="noti-subtitle">স্টক ১০ এর কম থাকা পণ্যসমূহ</p>
                </div>
              </div>
              <a href="/admin-dashboard-stock-out" class="noti-view-all-btn">
                <span>সব দেখুন</span> <i class="fa-solid fa-arrow-right" style="font-size: 8.5px;"></i>
              </a>
            </div>
            <div id="notification-items-list">
              <!-- Dynamic Low Stock Product Notifications Populated via JS -->
              <div class="text-center py-4 px-3">
                <div class="spinner-border spinner-border-sm text-danger me-2" role="status"></div>
                <span class="small text-muted">নোটিফিকেশন লোড হচ্ছে...</span>
              </div>
            </div>
            <div class="stock-noti-footer">
              <a href="/admin-dashboard-stock-out">
                <i class="fa-solid fa-boxes-stacked"></i> কম স্টক প্রোডাক্টের সম্পূর্ণ তালিকা দেখুন <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="dropdown d-inline-block">
          <button type="button" class="btn header-item user text-start d-flex align-items-center"
            id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img class="rounded-circle header-profile-user"
              id="UserProfileImg" src="{{ asset('backend/assets/img/profile-img.png') }}" onerror="this.src='{{ asset('backend/assets/img/profile-img.png') }}'" alt="Header Avatar" style="width: 36px; height: 36px; object-fit: cover;" />
          </button>
          <div class="dropdown-menu dropdown-menu-end pt-0 profile-dropdown">
            <div class="p-3 border-bottom">
              <h6 class="mb-0" id="AuthorizePersonProfileName"></h6>
              <a href="#" class="mb-0 font-size-11 text-muted" id="EmailShow">
              </a>
            </div>
            <a class="dropdown-item" href="{{url('admin-dashboard-user-profile')}}"><i
                class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i>
              <span class="align-middle">Profile</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="userlogout(event)"><i
                class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i>
              <span class="align-middle">Logout</span></a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Right Sidebar setting Start -->
  <div class="right-bar">
    <div data-simplebar class="h-100">
      <div class="rightbar-title d-flex align-items-center bg-dark p-3">
        <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

        <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
          <i class="mdi mdi-close noti-icon"></i>
        </a>
      </div>
      <!-- Settings -->
      <hr class="m-0" />

      <div class="p-4">
        <h6 class="mt-4 mb-3">Layout Mode</h6>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-light"
            value="light" />
          <label class="form-check-label" for="layout-mode-light">Light</label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-dark"
            value="dark" />
          <label class="form-check-label" for="layout-mode-dark">Dark</label>
        </div>

        <h6 class="mt-4 mb-3">Topbar Type</h6>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-light"
            value="light" onchange="document.body.setAttribute('data-topbar', 'light')" />
          <label class="form-check-label" for="topbar-color-light">Light</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-dark"
            value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')" />
          <label class="form-check-label" for="topbar-color-dark">Dark</label>
        </div>

        <div id="sidebar-setting">
          <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

          <div class="form-check sidebar-setting mt-2">
            <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-default"
              value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')" />
            <label class="form-check-label" for="sidebar-size-default">Default</label>
          </div>
          <div class="form-check sidebar-setting mt-2">
            <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-small"
              value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')" />
            <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
          </div>

          <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Color</h6>

          <div class="form-check sidebar-setting mt-2">
            <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-light"
              value="light" onchange="document.body.setAttribute('data-sidebar', 'light')" />
            <label class="form-check-label" for="sidebar-color-light">Light</label>
          </div>
          <div class="form-check sidebar-setting mt-2">
            <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-dark"
              value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')" />
            <label class="form-check-label" for="sidebar-color-dark">Dark</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Right Sidebar bar overlay-->
  <div class="rightbar-overlay"></div>
  <!-- Navbar End -->

  <!-- Left Sidebar Start -->
  <div class="vertical-menu">
    <!-- Synchronous Instant Permission CSS Filter (0ms Flash Fix) -->
    <script>
      (function() {
        try {
          var role = (localStorage.getItem('user_role') || '').toLowerCase();
          var perms = null;
          try {
            perms = JSON.parse(localStorage.getItem('user_permissions') || 'null');
          } catch (e) {}

          if (role && role !== 'admin' && role !== 'super_admin') {
            var effective = {
              pos: true,
              product: false,
              purchase: false,
              customer: false,
              expense: false,
              report: false,
              user: false
            };
            if (perms && typeof perms === 'object') {
              effective.pos = !!perms.pos;
              effective.product = !!perms.product;
              effective.purchase = !!perms.purchase;
              effective.customer = !!perms.customer;
              effective.expense = !!perms.expense;
              effective.report = !!perms.report;
              effective.user = !!perms.user;
            } else {
              if (role === 'manager') {
                effective = {
                  pos: true,
                  product: true,
                  purchase: true,
                  customer: true,
                  expense: true,
                  report: true,
                  user: false
                };
              } else if (role === 'cashier') {
                effective = {
                  pos: true,
                  product: false,
                  purchase: false,
                  customer: false,
                  expense: false,
                  report: false,
                  user: false
                };
              } else if (role === 'accountant') {
                effective = {
                  pos: false,
                  product: false,
                  purchase: false,
                  customer: true,
                  expense: true,
                  report: true,
                  user: false
                };
              }
            }

            var css = '';
            for (var k in effective) {
              if (effective[k] === false) {
                css += '[data-perm="' + k + '"] { display: none !important; }\n';
              }
            }
            if (css) {
              var style = document.createElement('style');
              style.id = 'instant-perm-style';
              style.innerHTML = css;
              document.head.appendChild(style);
            }
          }
        } catch (e) {
          console.error('Instant perm filter error:', e);
        }
      })();
    </script>
    <!-- LOGO Box -->
    <div class="navbar-brand-box">
      <a href="{{url('admin-dashboard')}}" class="logo logo-dark d-flex align-items-center text-decoration-none">
        <span class="logo-sm">
          <img src="{{ asset('backend/assets/img/marss-corporation-icon.svg') }}" alt="MARSS CORPORATION Icon" width="36" height="36" style="border-radius: 8px; object-fit: contain;" />
        </span>
        <span class="logo-lg d-flex align-items-center gap-2">
          <img src="{{ asset('backend/assets/img/marss-corporation-icon.svg') }}" alt="MARSS CORPORATION Icon" style="width: 36px; height: 36px; border-radius: 8px; object-fit: contain;" />
          <span class="fw-bold text-white fs-5" style="font-family: 'Baloo Da 2', sans-serif; font-size: 16px !important; letter-spacing: 0.3px;">
            মার্স কর্পোরেশন <span class="badge bg-success text-white px-2 py-1 ms-1" style="font-size: 10px; border-radius: 6px; font-weight: 600; font-family: 'Valley Sans', sans-serif;">POS</span>
          </span>
        </span>
      </a>
    </div>
    <!-- Logo Box End -->

    @php
      $activeParent = null;
      if (request()->is('admin-dashboard-product*') || request()->is('admin-dashboard-brand*') || request()->is('admin-dashboard-category*') || request()->is('admin-dashboard-barcode-genarate*')) {
          $activeParent = 'product';
      } elseif (request()->is('admin-dashboard-supplier*') || request()->is('supplier-due-page*') || request()->is('supplier-due-collection-page*')) {
          $activeParent = 'supplier';
      } elseif (request()->is('admin-dashboard-Purchase*')) {
          $activeParent = 'purchase';
      } elseif (request()->is('admin-dashboard-customer*') || request()->is('admin-dashboard-customer-due-list*') || request()->is('customer-due-collection-page*')) {
          $activeParent = 'customer';
      } elseif (request()->is('admin-dashboard-expence*')) {
          $activeParent = 'expense';
      } elseif (request()->is('admin-dashboard-return-list*')) {
          $activeParent = 'sales-return';
      } elseif (request()->is('admin-dashboard-opening-balance*')) {
          $activeParent = 'opening-balance';
      } elseif (request()->is('admin-dashboard-*-report*') || request()->is('admin-dashboard-stock-out*') || request()->is('admin-dashboard-daily-*') || request()->is('admin-dashboard-personal-*') || request()->is('admin-dashboard-income-*') || request()->is('admin-dashboard-sales-report*')) {
          $activeParent = 'report';
      } elseif (request()->is('admin-dashboard-user-role*')) {
          $activeParent = 'user-role';
      }
    @endphp

    <!--- Redesigned Sliding Drilldown Wrapper -->
    <div id="sidebar-slider-wrapper" class="relative flex-1 w-full overflow-hidden">
      
      <!-- Panel 1: Main Menu Panel -->
      <div id="sidebar-main-panel" class="sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent ? '-translate-x-full pointer-events-none' : 'translate-x-0 pointer-events-auto' }}">
        <ul class="space-y-1">
          
          <!-- 1. Dashboard -->
          <li class="sidebar-item relative group">
            <a href="{{ url('admin-dashboard') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->is('admin-dashboard') ? 'active-gradient' : '' }}">
              <i class="fa-solid fa-gauge text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
              <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Dashboard</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Dashboard
            </div>
          </li>

          <!-- 2. POS -->
          <li class="sidebar-item relative group" data-perm="pos">
            <a href="{{ url('admin-dashboard-pos') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->is('admin-dashboard-pos') ? 'active-gradient' : '' }}">
              <i class="fa-solid fa-cash-register text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
              <span class="sidebar-label text-[13.5px] font-medium tracking-wide">POS</span>
            </a>
            <div class="sidebar-mini-tooltip">
              POS
            </div>
          </li>

          <!-- 3. Invoice List -->
          <li class="sidebar-item relative group" data-perm="pos">
            <a href="{{ url('admin-dashboard-invoice') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 transition-all duration-200 {{ request()->is('admin-dashboard-invoice') ? 'active-gradient' : '' }}">
              <i class="fa-solid fa-file-invoice-dollar text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
              <span class="sidebar-label text-[13.5px] font-medium tracking-wide">Invoice List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Invoice List
            </div>
          </li>

          <!-- 4. Product (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="product" data-perm="product">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'product' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-product">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-boxes-stacked text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Product</span>
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
                  Product
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-product') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-product') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-list-ul text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Product List</span></a></li>
                <li><a href="{{ url('admin-dashboard-brand') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-brand') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-tag text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Brand List</span></a></li>
                <li><a href="{{ url('admin-dashboard-category') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-category') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-layer-group text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Category List</span></a></li>
                <li><a href="{{ url('admin-dashboard-barcode-genarate') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-barcode-genarate') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-barcode text-[10px] text-emerald-300/80 w-4 text-center"></i><span>BarCode Print</span></a></li>
                <li><a href="{{ url('admin-dashboard-stock-out') }}" class="sidebar-flyout-link text-red-300 hover:text-red-100 hover:bg-red-500/20 font-semibold"><i class="fa-solid fa-triangle-exclamation text-[10px] text-red-400 w-4 text-center"></i><span>কম স্টক প্রোডাক্ট</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 5. Supplier (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="supplier" data-perm="purchase">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'supplier' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-supplier">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-truck text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Supplier</span>
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
                  Supplier
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-supplier') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-supplier') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-truck text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Supplier List</span></a></li>
                <li><a href="{{ url('supplier-due-page') }}" class="sidebar-flyout-link {{ request()->is('supplier-due-page') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-receipt text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Supplier Due List</span></a></li>
                <li><a href="{{ url('supplier-due-collection-page') }}" class="sidebar-flyout-link {{ request()->is('supplier-due-collection-page') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-money-bill-wave text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Due collection List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 6. Purchase (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="purchase" data-perm="purchase">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'purchase' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-purchase">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-cart-shopping text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Purchase</span>
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
                  Purchase
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-Purchase') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-Purchase') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-cart-flatbed text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Purchase List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 7. Customer (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="customer" data-perm="customer">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'customer' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-customer">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-users text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Customer</span>
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
                  Customer
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-customer') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-customer') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-user-group text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Customer List</span></a></li>
                <li><a href="{{ url('admin-dashboard-customer-due-list') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-customer-due-list') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-file-invoice text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Customer Due List</span></a></li>
                <li><a href="{{ url('customer-due-collection-page') }}" class="sidebar-flyout-link {{ request()->is('customer-due-collection-page') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-hand-holding-dollar text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Due Collection List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 8. Expense (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="expense" data-perm="expense">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'expense' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-expense">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-wallet text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Expense</span>
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
                  Expense
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-expence-type') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-expence-type') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-tags text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Expense Type</span></a></li>
                <li><a href="{{ url('admin-dashboard-expence-list') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-expence-list') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-receipt text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Expense List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 9. Sales Return (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="sales-return" data-perm="pos">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'sales-return' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-sales-return">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-arrow-rotate-left text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Sales Return</span>
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
                  Sales Return
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-return-list') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-return-list') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-box-archive text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Return List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 10. Opening Balance (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="opening-balance" data-perm="expense">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'opening-balance' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-opening-balance">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-scale-balanced text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Opening Balance</span>
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
                  Opening Balance
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-opening-balance') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-opening-balance') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-wallet text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Opening Balance List</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 11. Report (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="report" data-perm="report">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'report' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-report">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-chart-pie text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Report</span>
              </div>
              <span class="sidebar-arrow shrink-0 w-5 h-5 rounded-md bg-white/10 flex items-center justify-center text-white/70 group-hover:text-white group-hover:bg-white/20 transition-all">
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
              </span>
            </button>
            <!-- Collapsed Flyout Popover -->
            <div class="sidebar-flyout !w-64">
              <div class="sidebar-flyout-header flex items-center justify-between px-3 py-2 border-b border-emerald-500/25 mb-1.5">
                <span class="text-[11px] font-bold tracking-wider text-emerald-300 uppercase flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399]"></span>
                  Report
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-daily-ledger-report') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-daily-ledger-report') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-book text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Daily Ledger Report (লেজার)</span></a></li>
                <li><a href="{{ url('admin-dashboard-sales-report') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-sales-report') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-chart-column text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Sales Report</span></a></li>
                <li><a href="{{ url('admin-dashboard-income-expense-report') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-income-expense-report') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-scale-unbalanced-flip text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Income & Expense Report</span></a></li>
                <li><a href="{{ url('admin-dashboard-daily-receipt-payment-report') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-daily-receipt-payment-report') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-receipt text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Daily Receipt & Payment</span></a></li>
                <li><a href="{{ url('admin-dashboard-personal-transaction-report') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-personal-transaction-report') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-user-check text-[10px] text-emerald-300/80 w-4 text-center"></i><span>Personal Transaction</span></a></li>
                <li><a href="{{ url('admin-dashboard-stock-out') }}" class="sidebar-flyout-link text-red-300 hover:text-red-100 hover:bg-red-500/20 font-semibold"><i class="fa-solid fa-triangle-exclamation text-[10px] text-red-400 w-4 text-center"></i><span>Low Stock Report (কম স্টক)</span></a></li>
              </ul>
            </div>
          </li>

          <!-- 12. Role & User (Has Submenu) -->
          <li class="sidebar-item has-submenu relative group" data-menu-id="user-role" data-perm="user">
            <button type="button" class="sidebar-drilldown-trigger w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-100 hover:text-white hover:bg-white/15 bg-transparent border-0 outline-none transition-all duration-200 text-start {{ $activeParent === 'user-role' ? 'active-parent' : '' }}" style="background-color: transparent;" data-target="submenu-panel-user-role">
              <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-user-shield text-emerald-200 group-hover:text-emerald-100 text-[15px] w-6 text-center shrink-0 transition-transform group-hover:scale-110"></i>
                <span class="sidebar-label text-[13.5px] font-medium tracking-wide truncate">Role & User</span>
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
                  Role & User
                </span>
                <span class="text-[9.5px] font-semibold text-emerald-200/80 bg-emerald-500/20 px-1.5 py-0.5 rounded border border-emerald-400/30">Menu</span>
              </div>
              <ul class="py-0.5 px-1 space-y-0.5">
                <li><a href="{{ url('admin-dashboard-user-role') }}" class="sidebar-flyout-link {{ request()->is('admin-dashboard-user-role') ? 'active-flyout-link' : '' }}"><i class="fa-solid fa-user-gear text-[10px] text-emerald-300/80 w-4 text-center"></i><span>User List & Roles</span></a></li>
              </ul>
            </div>
          </li>

        </ul>
      </div>

      <!-- Panel 2: Product Submenu Panel -->
      <div id="submenu-panel-product" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'product' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="product" data-perm="product">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Product</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-product') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-product') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-list-ul text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Product List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Product List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-brand') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-brand') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-tag text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Brand List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Brand List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-category') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-category') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-layer-group text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Category List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Category List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-barcode-genarate') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-barcode-genarate') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-barcode text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>BarCode Print</span>
            </a>
            <div class="sidebar-mini-tooltip">
              BarCode Print
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-stock-out') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-red-200 hover:text-white hover:bg-red-600/30 font-bold transition-all duration-150 {{ request()->is('admin-dashboard-stock-out') ? 'bg-red-600 text-white' : '' }}">
              <i class="fa-solid fa-triangle-exclamation text-xs text-red-300 w-4 text-center"></i>
              <span>কম স্টক প্রোডাক্ট তালিকা</span>
            </a>
            <div class="sidebar-mini-tooltip">
              কম স্টক প্রোডাক্ট
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 3: Supplier Submenu Panel -->
      <div id="submenu-panel-supplier" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'supplier' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="supplier" data-perm="purchase">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Supplier</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-supplier') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-supplier') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-address-book text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Supplier List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Supplier List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('supplier-due-page') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('supplier-due-page') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-file-invoice text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Supplier Due List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Supplier Due List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('supplier-due-collection-page') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('supplier-due-collection-page') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-hand-holding-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Due collection List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Due Collection List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 4: Purchase Submenu Panel -->
      <div id="submenu-panel-purchase" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'purchase' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="purchase" data-perm="purchase">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Purchase</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-Purchase') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-Purchase') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-cart-arrow-down text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Purchase List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Purchase List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 5: Customer Submenu Panel -->
      <div id="submenu-panel-customer" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'customer' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="customer" data-perm="customer">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Customer</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-customer') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-customer') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-address-card text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Customer List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Customer List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-customer-due-list') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-customer-due-list') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-file-invoice text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Customer Due List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Customer Due List
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('customer-due-collection-page') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('customer-due-collection-page') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-hand-holding-dollar text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Due Collection List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Due Collection List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 6: Expense Submenu Panel -->
      <div id="submenu-panel-expense" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'expense' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="expense" data-perm="expense">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Expense</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-expence-type') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-expence-type') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-tags text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Expense Type</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Expense Type
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-expence-list') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-expence-list') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-receipt text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Expense List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Expense List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 7: Sales Return Submenu Panel -->
      <div id="submenu-panel-sales-return" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'sales-return' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="sales-return" data-perm="pos">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Sales Return</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-return-list') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-return-list') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-rotate-left text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Return List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Sales Return List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 8: Opening Balance Submenu Panel -->
      <div id="submenu-panel-opening-balance" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'opening-balance' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="opening-balance" data-perm="expense">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Opening Balance</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-opening-balance') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-opening-balance') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-scale-balanced text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Opening Balance List</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Opening Balance List
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 9: Report Submenu Panel -->
      <div id="submenu-panel-report" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'report' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="report" data-perm="report">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Report</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-daily-ledger-report') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-daily-ledger-report') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-book-bookmark text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Daily Income & Expense Ledger (আয়-ব্যয়)</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Daily Ledger Report
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-sales-report') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-sales-report') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-chart-line text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Sales Report</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Sales Report
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-income-expense-report') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-income-expense-report') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-chart-column text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Income & Expense Report</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Income & Expense Report
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-daily-receipt-payment-report') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-daily-receipt-payment-report') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-file-waveform text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Daily Receipt & Payment</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Daily Receipt & Payment
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-personal-transaction-report') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-personal-transaction-report') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-user-tag text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>Personal Transaction Report</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Personal Transaction Report
            </div>
          </li>
          <li class="relative group">
            <a href="{{ url('admin-dashboard-stock-out') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-red-200 hover:text-white hover:bg-red-600/30 font-bold transition-all duration-150 {{ request()->is('admin-dashboard-stock-out') ? 'bg-red-600 text-white' : '' }}">
              <i class="fa-solid fa-triangle-exclamation text-xs text-red-300 w-4 text-center"></i>
              <span>Low Stock Report (কম স্টক)</span>
            </a>
            <div class="sidebar-mini-tooltip">
              Low Stock Report
            </div>
          </li>
        </ul>
      </div>

      <!-- Panel 10: Role & User Submenu Panel -->
      <div id="submenu-panel-user-role" class="sidebar-submenu-panel sidebar-panel-scroll absolute inset-0 w-full h-full overflow-y-auto overflow-x-hidden transition-transform duration-300 ease-in-out py-2 px-3 {{ $activeParent === 'user-role' ? 'translate-x-0 pointer-events-auto' : 'translate-x-full pointer-events-none' }}" data-parent-id="user-role" data-perm="user">
        <div class="sidebar-back-wrapper relative group mb-2">
          <button type="button" class="sidebar-back-btn w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-emerald-100 bg-white/10 hover:bg-white/20 border border-white/15 font-semibold text-sm transition-all duration-200 shadow-sm" data-target="main">
            <i class="fa-solid fa-chevron-left text-xs text-emerald-300"></i>
            <span class="truncate">Role & User</span>
          </button>
          <div class="sidebar-mini-tooltip">
            Main Menu
          </div>
        </div>
        <ul class="space-y-1">
          <li class="relative group">
            <a href="{{ url('admin-dashboard-user-role') }}" class="flex w-full items-center gap-2.5 px-3 py-2.5 rounded-xl text-[13px] text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-150 {{ request()->is('admin-dashboard-user-role') ? 'active-submenu-link' : '' }}">
              <i class="fa-solid fa-user-gear text-xs text-emerald-300/80 w-4 text-center"></i>
              <span>User List & Roles (ইউজার ও পারমিশন)</span>
            </a>
            <div class="sidebar-mini-tooltip">
              User List & Roles
            </div>
          </li>
        </ul>
      </div>

    </div>

    <!-- Fixed Bottom Logout Button -->
    <div class="sidebar-bottom-logout relative group">
      <a href="#" onclick="userlogout(event)" class="sidebar-logout-btn">
        <i class="fa-solid fa-right-from-bracket icon"></i>
        <span class="text">Log Out</span>
      </a>
      <div class="sidebar-mini-tooltip">
        Log Out
      </div>
    </div>
  </div>
  <!-- Left Sidebar End -->


  @yield('content')



  <script>
    // script.js

    document.addEventListener("DOMContentLoaded", () => {
      const preloader = document.getElementById("preloader");
      const content = document.getElementById("content");

      // Hide preloader and show content after 0.5 seconds
      setTimeout(() => {
        preloader.style.opacity = "0";
        preloader.style.visibility = "hidden";
        content.style.display = "block";

        // Fade in the content
        setTimeout(() => {
          content.style.opacity = "1";
        }, 100);
      }, 100);
    });
  </script>













  <!-- Modern Sliding Drilldown & Collapsed Popover Sidebar Controller -->
  <script>
    (function() {
      // Open Submenu Drilldown Panel
      window.openSubmenuPanel = function(panelId) {
        // In collapsed mode (data-sidebar-size="sm"), don't slide inside the 70px icon rail
        if (document.body.getAttribute('data-sidebar-size') === 'sm') {
          return;
        }

        const mainPanel = document.getElementById('sidebar-main-panel');
        const targetPanel = document.getElementById(panelId);
        if (!mainPanel || !targetPanel) return;

        // Hide any currently open submenu panels
        document.querySelectorAll('.sidebar-submenu-panel').forEach(function(p) {
          if (p !== targetPanel) {
            p.classList.remove('translate-x-0', 'pointer-events-auto');
            p.classList.add('translate-x-full', 'pointer-events-none');
          }
        });

        // Slide main panel out to the left
        mainPanel.classList.remove('translate-x-0', 'pointer-events-auto');
        mainPanel.classList.add('-translate-x-full', 'pointer-events-none');

        // Slide target panel in from the right
        targetPanel.classList.remove('translate-x-full', 'pointer-events-none');
        targetPanel.classList.add('translate-x-0', 'pointer-events-auto');
      };

      // Close Submenu Panel and Return to Main Menu
      window.closeSubmenuPanel = function() {
        const mainPanel = document.getElementById('sidebar-main-panel');
        if (!mainPanel) return;

        // Slide all submenu panels out to the right
        document.querySelectorAll('.sidebar-submenu-panel').forEach(function(p) {
          p.classList.remove('translate-x-0', 'pointer-events-auto');
          p.classList.add('translate-x-full', 'pointer-events-none');
        });

        // Slide main panel back in from the left
        mainPanel.classList.remove('-translate-x-full', 'pointer-events-none');
        mainPanel.classList.add('translate-x-0', 'pointer-events-auto');
      };

      document.addEventListener('DOMContentLoaded', function() {
        // Bind drilldown trigger buttons
        document.querySelectorAll('.sidebar-drilldown-trigger').forEach(function(btn) {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');

            // If sidebar is collapsed (sm): toggle pin on the flyout for touch/click
            if (document.body.getAttribute('data-sidebar-size') === 'sm') {
              const parent = this.closest('.has-submenu');
              if (parent) {
                const flyout = parent.querySelector('.sidebar-flyout');
                if (flyout) {
                  const isPinned = flyout.classList.contains('flyout-pinned');
                  document.querySelectorAll('.sidebar-flyout').forEach(function(f) {
                    f.classList.remove('flyout-pinned');
                  });
                  document.querySelectorAll('.has-submenu').forEach(function(p) {
                    p.classList.remove('flyout-open');
                  });
                  if (!isPinned) {
                    flyout.classList.add('flyout-pinned');
                    parent.classList.add('flyout-open');
                  }
                }
              }
              return;
            }

            if (targetId) {
              openSubmenuPanel(targetId);
            }
          });
        });

        // Bind back buttons
        document.querySelectorAll('.sidebar-back-btn').forEach(function(btn) {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            closeSubmenuPanel();
          });
        });

        // Dismiss pinned and open flyouts on outside click
        document.addEventListener('click', function(e) {
          if (!e.target.closest('.has-submenu')) {
            document.querySelectorAll('.sidebar-flyout.flyout-pinned').forEach(function(f) {
              f.classList.remove('flyout-pinned');
            });
            document.querySelectorAll('.has-submenu.flyout-open').forEach(function(p) {
              p.classList.remove('flyout-open');
            });
          }
        });

        // Debounced hover & smart vertical viewport positioning for flyouts
        let activeFlyoutTimer = null;
        document.querySelectorAll('.has-submenu').forEach(function(item) {
          item.addEventListener('mouseenter', function() {
            if (document.body.getAttribute('data-sidebar-size') !== 'sm') return;
            if (activeFlyoutTimer) clearTimeout(activeFlyoutTimer);

            // Close other unpinned flyouts
            document.querySelectorAll('.has-submenu').forEach(function(other) {
              if (other !== item && !other.querySelector('.sidebar-flyout.flyout-pinned')) {
                other.classList.remove('flyout-open');
              }
            });

            item.classList.add('flyout-open');

            const flyout = item.querySelector('.sidebar-flyout');
            if (!flyout) return;
            const rect = item.getBoundingClientRect();
            const flyoutHeight = flyout.offsetHeight || 260;
            if (rect.top + flyoutHeight > window.innerHeight - 20) {
              flyout.style.top = 'auto';
              flyout.style.bottom = '0px';
            } else {
              flyout.style.top = '0px';
              flyout.style.bottom = 'auto';
            }
          });

          item.addEventListener('mouseleave', function() {
            if (document.body.getAttribute('data-sidebar-size') !== 'sm') return;
            activeFlyoutTimer = setTimeout(function() {
              if (!item.querySelector('.sidebar-flyout.flyout-pinned')) {
                item.classList.remove('flyout-open');
              }
            }, 180);
          });
        });

        // Observer for body data-sidebar-size changes
        const observer = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-sidebar-size') {
              const currentSize = document.body.getAttribute('data-sidebar-size');
              if (currentSize === 'sm') {
                // When collapsed: close any pinned or open flyouts
                document.querySelectorAll('.sidebar-flyout.flyout-pinned').forEach(function(f) {
                  f.classList.remove('flyout-pinned');
                });
                document.querySelectorAll('.has-submenu.flyout-open').forEach(function(p) {
                  p.classList.remove('flyout-open');
                });
              }
            }
          });
        });
        observer.observe(document.body, { attributes: true });
      });
    })();
  </script>

  <script>
    async function userlogout(event) {
      event.preventDefault(); // Prevent the default behavior of the link

      try {
        let res = await axios.get("/naxus-pos-logout", HeaderToken());
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = "/admin-login-page";
      } catch (e) {
        console.error("Logout error:", e);

        // Show error message if available, or a default message
        errorToast(e.response?.data?.message || "Something went wrong");
      }
    }
  </script>
  {{--
<script>
    // Disable right-click
    document.addEventListener('contextmenu', function (e) {
      e.preventDefault();
    });

    // Disable F12 and Ctrl+Shift+I (Developer Tools)
    document.addEventListener('keydown', function (e) {
      if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
        e.preventDefault();
      }
    });
  </script> --}}

  <!-- Smart Role & Toggle Permission Control Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      applyUserRolePermissions();

      async function applyUserRolePermissions() {
        try {
          const response = await axios.get("/user-profile", HeaderToken());
          const user = response.data;

          window.currentUserRole = (user.role || '').toLowerCase();
          window.currentUserPermissions = user.permissions || null;

          // Cache in localStorage for instant 0ms pre-rendering on next page transitions
          localStorage.setItem('user_role', window.currentUserRole);
          if (user.permissions) {
            localStorage.setItem('user_permissions', JSON.stringify(user.permissions));
          }

          // Populate Header User Profile Info
          if (document.getElementById('UserProfileImg') && user.img_url) {
            document.getElementById('UserProfileImg').src = user.img_url;
          }
          if (document.getElementById('AuthorizePersonProfileName')) {
            document.getElementById('AuthorizePersonProfileName').innerText = user.name || "No Name";
          }
          if (document.getElementById('EmailShow')) {
            document.getElementById('EmailShow').innerText = user.email || "No Email";
          }

          // If Super Admin or Admin, show all menus and admin dashboard sections!
          const isAdmin = (window.currentUserRole === 'admin' || window.currentUserRole === 'super_admin');
          if (document.getElementById('adminOnlyFinancialSections')) {
            document.getElementById('adminOnlyFinancialSections').style.display = isAdmin ? 'block' : 'none';
          }

          if (isAdmin) {
            document.querySelectorAll('[data-perm]').forEach(el => el.style.display = '');
            return;
          }

          // Determine effective permission flags
          let perms = window.currentUserPermissions;
          let role = window.currentUserRole;

          let effective = {
            pos: true,
            product: false,
            purchase: false,
            customer: false,
            expense: false,
            report: false,
            user: false
          };

          if (perms && typeof perms === 'object') {
            effective.pos = !!perms.pos;
            effective.product = !!perms.product;
            effective.purchase = !!perms.purchase;
            effective.customer = !!perms.customer;
            effective.expense = !!perms.expense;
            effective.report = !!perms.report;
            effective.user = !!perms.user;
          } else {
            // Default role presets if custom toggles aren't explicitly saved
            if (role === 'manager') {
              effective = {
                pos: true,
                product: true,
                purchase: true,
                customer: true,
                expense: true,
                report: true,
                user: false
              };
            } else if (role === 'cashier') {
              effective = {
                pos: true,
                product: false,
                purchase: false,
                customer: false,
                false: false,
                report: false,
                user: false
              };
            } else if (role === 'accountant') {
              effective = {
                pos: false,
                product: false,
                purchase: false,
                customer: true,
                expense: true,
                report: true,
                user: false
              };
            }
          }

          // Apply display: none or display: '' to sidebar elements based on data-perm
          document.querySelectorAll('[data-perm]').forEach(el => {
            const key = el.getAttribute('data-perm');
            if (key && effective.hasOwnProperty(key)) {
              if (effective[key] === true) {
                el.style.display = '';
              } else {
                el.style.display = 'none';
              }
            }
          });

          // Route Protection: Prevent unauthorized direct URL access
          const path = window.location.pathname;
          if (path.includes('admin-dashboard-user-role') && !effective.user) {
            window.location.href = effective.pos ? '/admin-dashboard-pos' : '/admin-dashboard';
          } else if ((path.includes('admin-dashboard-product') || path.includes('admin-dashboard-brand') || path.includes('admin-dashboard-category')) && !effective.product) {
            window.location.href = effective.pos ? '/admin-dashboard-pos' : '/admin-dashboard';
          } else if ((path.includes('admin-dashboard-Purchase') || path.includes('admin-dashboard-supplier')) && !effective.purchase) {
            window.location.href = effective.pos ? '/admin-dashboard-pos' : '/admin-dashboard';
          }

        } catch (error) {
          console.error('Error applying user permissions:', error);
          if (error.response && error.response.status === 401) {
            unauthorized(401);
          }
        }
      }
    });
  </script>

  {{-- DatePicker Start  --}}
  <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker.min.js"></script>
  {{-- DatePicker end  --}}


  <!-- Popper.js for tooltips and popovers in Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
  <!-- XLSX.js for reading and writing Excel files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <!-- jsPDF for generating PDF documents -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <!-- jsPDF-AutoTable for adding tables to PDFs created with jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.26/jspdf.plugin.autotable.min.js"></script>

  <!-- JAVASCRIPT -->
  <script src="{{ asset('backend/assets/js/fontawesome.js') }}"></script>
  <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/full-screen-toggle.js') }}"></script>
  <script src="{{ asset('backend/assets/js/all-modals.js') }}"></script>
  <script src="{{ asset('backend/assets/js/table-funtion.js') }}"></script>
  <script src="{{ asset('backend/assets/js/app.js') }}"></script>
  <script src="{{ asset('backend/assets/js/style.js') }}"></script>

  <!-- Dynamic Low Stock Notification & Music Chime Script -->
  <script>
    let lastLowStockCount = 0;

    // Play pleasant 4-note ascending chime sound using Web Audio API
    function playStockNotificationChime() {
      try {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (!AudioContext) return;
        const ctx = new AudioContext();
        if (ctx.state === 'suspended') {
          ctx.resume();
        }

        const playNote = (freq, startTime, duration) => {
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();
          osc.type = 'sine';
          osc.frequency.setValueAtTime(freq, startTime);
          gain.gain.setValueAtTime(0.18, startTime);
          gain.gain.exponentialRampToValueAtTime(0.001, startTime + duration);
          osc.connect(gain);
          gain.connect(ctx.destination);
          osc.start(startTime);
          osc.stop(startTime + duration);
        };

        const now = ctx.currentTime;
        playNote(523.25, now, 0.18); // C5
        playNote(659.25, now + 0.12, 0.18); // E5
        playNote(783.99, now + 0.24, 0.18); // G5
        playNote(1046.50, now + 0.36, 0.35); // C6
      } catch (e) {
        console.log('Audio chime error:', e);
      }
    }

    async function loadLowStockNotifications(playSound = false) {
      try {
        const res = await axios.get('/admin-dashboard-low-stock-notifications');
        if (res.data && res.data.status === 'success') {
          const products = res.data.data || [];
          const count = res.data.count || 0;

          const badge = document.getElementById('noti-count-badge');
          const listContainer = document.getElementById('notification-items-list');

          if (badge) {
            if (count > 0) {
              badge.innerText = count;
              badge.style.display = 'inline-block';
            } else {
              badge.style.display = 'none';
            }
          }

          // Play chime sound if count increased or explicitly triggered
          if (playSound && count > 0) {
            playStockNotificationChime();
          }

          if (listContainer) {
            if (count === 0) {
              listContainer.innerHTML = `
                            <div class="text-center py-4 px-3">
                                <div class="rounded-circle bg-success-subtle text-success d-inline-flex p-3 mb-2">
                                    <i class="fa-solid fa-circle-check fs-3"></i>
                                </div>
                                <h6 class="fw-bold text-success mb-1">সকল প্রোডাক্টের পর্যাপ্ত স্টক রয়েছে!</h6>
                                <p class="small text-muted mb-0">কোনো প্রোডাক্টের স্টক ১০ এর নিচে নেই</p>
                            </div>
                        `;
            } else {
              let html = '';
              products.forEach(p => {
                let codeDisplay = "N/A";
                if (p.product_code) {
                  try {
                    const parsed = JSON.parse(p.product_code);
                    if (Array.isArray(parsed)) {
                      codeDisplay = parsed.filter(Boolean).join(", ") || "N/A";
                    } else {
                      codeDisplay = String(parsed).replace(/[\[\]"']/g, '').trim() || "N/A";
                    }
                  } catch (e) {
                    codeDisplay = String(p.product_code).replace(/[\[\]"']/g, '').trim() || "N/A";
                  }
                }
                const isOutOfStock = (Number(p.quantity) <= 0);
                const unitText = p.unit_name ? p.unit_name : 'টি';

                html += `
                  <a href="/admin-dashboard-stock-out" class="stock-noti-item">
                    <div class="item-icon-box" style="background: ${isOutOfStock ? '#fef2f2' : '#fffbeb'}; border: 1px solid ${isOutOfStock ? '#fecaca' : '#fef3c7'}; color: ${isOutOfStock ? '#dc2626' : '#d97706'};">
                      <i class="${isOutOfStock ? 'fa-solid fa-triangle-exclamation' : 'fa-solid fa-boxes-stacked'}"></i>
                    </div>
                    <div class="item-body">
                      <div class="item-row-top">
                        <span class="item-name" title="${p.product_name}">${p.product_name}</span>
                        <span class="item-badge ${isOutOfStock ? 'item-badge-danger' : 'item-badge-warning'}">
                          ${isOutOfStock ? 'স্টক শেষ!' : 'কম স্টক!'}
                        </span>
                      </div>
                      <div class="item-row-bottom">
                        <span class="item-code" title="${codeDisplay}">
                          <i class="fa-solid fa-barcode text-muted"></i> ${codeDisplay}
                        </span>
                        <span class="item-stock" style="color: ${isOutOfStock ? '#dc2626' : '#ea580c'};">
                          স্টক: <strong>${p.quantity}</strong> ${unitText}
                        </span>
                      </div>
                    </div>
                  </a>
                `;
              });
              listContainer.innerHTML = html;
            }
          }

          lastLowStockCount = count;
        }
      } catch (err) {
        console.log('Low stock notification fetch error:', err);
      }
    }

    // Modern Light / Dark Mode Toggle Function with Icon Switching
    function toggle_light_mode() {
      const body = document.body;
      const html = document.documentElement;
      const currentMode = body.getAttribute("light-mode") || localStorage.getItem("lightMode") || "light";
      const newMode = (currentMode === "dark") ? "light" : "dark";

      localStorage.setItem("lightMode", newMode);
      localStorage.setItem("layout-mode", newMode);

      body.setAttribute("light-mode", newMode);
      body.setAttribute("data-layout-mode", newMode);
      html.setAttribute("light-mode", newMode);

      // Sync settings radio buttons if available in sidebar
      const radioLight = document.getElementById("layout-mode-light");
      const radioDark = document.getElementById("layout-mode-dark");
      if (radioLight && radioDark) {
        if (newMode === "dark") {
          radioDark.checked = true;
        } else {
          radioLight.checked = true;
        }
      }
    }

    // Apply saved theme immediately
    (function() {
      const saved = localStorage.getItem("lightMode") || localStorage.getItem("layout-mode") || "light";
      if (saved === "dark") {
        document.body.setAttribute("light-mode", "dark");
        document.body.setAttribute("data-layout-mode", "dark");
        document.documentElement.setAttribute("light-mode", "dark");
      } else {
        document.body.setAttribute("light-mode", "light");
        document.body.setAttribute("data-layout-mode", "light");
        document.documentElement.setAttribute("light-mode", "light");
      }
    })();

    document.addEventListener("DOMContentLoaded", function() {
      loadLowStockNotifications(false);

      const bellBtn = document.getElementById('page-header-notifications-dropdown-v');
      if (bellBtn) {
        bellBtn.addEventListener('click', function() {
          loadLowStockNotifications(false);
        });
      }

      // Poll silently every 60 seconds for live stock alerts
      setInterval(() => {
        loadLowStockNotifications(false);
      }, 60000);
    });
  </script>
</body>

</html>