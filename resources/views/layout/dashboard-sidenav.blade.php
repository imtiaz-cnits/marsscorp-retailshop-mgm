<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>@yield('title') - মার্স কর্পোরেশন (MARSS CORPORATION)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('back-end/assets/icons/favicon.svg') }}" type="image/x-icon" />

  <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <!-- Bootstrap Css -->
  <link href="{{ asset('back-end/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
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




  <link href="{{ asset('back-end/assets/css/navbar-sidebar.css') }}" rel="stylesheet" />
  <link href="{{ asset('back-end/assets/css/user-profile.css') }}" rel="stylesheet" />
  <link href="{{ asset('back-end/assets/css/all-modal.css.css') }}" rel="stylesheet" />
  <link href="{{ asset('back-end/assets/css/style.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('back-end/assets/css/dark-mode.css') }}" />
  <link rel="stylesheet" href="{{ asset('back-end/assets/css/table-funtion.css') }}" />


  <link href="{{ asset('back-end/assets/css/toastify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('back-end/assets/css/progress.css') }}" rel="stylesheet" />
  <link href="{{ asset('back-end/assets/css/animate.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('back-end/assets/js/toastify-js.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/axios.min.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/config.js') }}"></script>

  <style>
    /* Vibrant Colorful Emerald Teal Mesh Gradient Theme for Sidebar */
    .vertical-menu {
      background: linear-gradient(165deg, #064e3b 0%, #047857 35%, #0d9488 70%, #0f766e 100%) !important;
      border-right: 1px solid rgba(255, 255, 255, 0.12) !important;
      box-shadow: 4px 0 25px rgba(4, 120, 87, 0.25) !important;
    }

    /* Prevent Duplicate Logo on Topbar */
    #page-topbar .navbar-brand-box {
      display: none !important;
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

    .vertical-menu .navbar-brand-box {
      background: rgba(6, 78, 59, 0.95) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
      height: 72px !important;
      display: flex !important;
      align-items: center !important;
      padding: 0 16px !important;
      box-shadow: none !important;
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

    .vertical-menu #sidebar-menu {
      padding-top: 12px !important;
    }

    .vertical-menu #sidebar-menu ul li a {
      color: #f1f5f9 !important;
      font-weight: 500 !important;
      font-size: 14px !important;
      padding: 10px 14px !important;
      margin: 4px 12px !important;
      border-radius: 10px !important;
      transition: all 0.22s ease-in-out !important;
      border-left: 4px solid transparent !important;
    }

    .vertical-menu #sidebar-menu ul li a i.icon {
      color: #a7f3d0 !important;
      font-size: 16px !important;
      width: 26px !important;
      text-align: center !important;
      transition: all 0.22s ease-in-out !important;
    }

    /* Hover State */
    .vertical-menu #sidebar-menu ul li a:hover {
      background: rgba(255, 255, 255, 0.18) !important;
      color: #ffffff !important;
    }

    .vertical-menu #sidebar-menu ul li a:hover i.icon {
      color: #6ee7b7 !important;
      transform: scale(1.12);
    }

    /* Active Link State */
    .vertical-menu #sidebar-menu ul li.active-link.active>a,
    .vertical-menu #sidebar-menu ul li.active-link>a:focus,
    .vertical-menu #sidebar-menu ul li.submenu-active>a.active {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: #ffffff !important;
      font-weight: 600 !important;
      border-left: 4px solid #34d399 !important;
      box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35) !important;
    }

    .vertical-menu #sidebar-menu ul li.active-link.active>a i.icon {
      color: #ffffff !important;
      filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.6)) !important;
    }

    .vertical-menu #sidebar-menu ul li.active-link.active>a .arrow,
    .vertical-menu #sidebar-menu ul li.submenu-active>a.active .arrow {
      color: #ffffff !important;
    }

    /* Submenu items */
    .vertical-menu .menu .sub-menu {
      background: rgba(0, 0, 0, 0.18) !important;
      margin-left: 20px !important;
      padding-left: 8px !important;
      border-left: 2px dashed rgba(255, 255, 255, 0.25) !important;
      border-radius: 0 0 10px 10px !important;
    }

    .vertical-menu .menu .sub-menu li a {
      color: #cbd5e1 !important;
      font-size: 13px !important;
      padding: 8px 12px !important;
      margin: 2px 4px !important;
    }

    .vertical-menu .menu .sub-menu li a:hover {
      color: #a7f3d0 !important;
      background: rgba(255, 255, 255, 0.12) !important;
    }

    /* Logout Button */
    .vertical-menu .log-out {
      background: rgba(6, 78, 59, 0.95) !important;
      border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
    }

    .vertical-menu .log-out a {
      color: #fca5a5 !important;
      font-weight: 600 !important;
      padding: 10px 14px !important;
      border-radius: 10px !important;
      transition: all 0.2s !important;
    }

    .vertical-menu .log-out a:hover {
      background: rgba(239, 68, 68, 0.2) !important;
      color: #ffffff !important;
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
  </style>

  {{-- <style>
    /* styles.css */

    /* Preloader Styling */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .Lodar-bar-container {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .Lodar-bar {
      width: 10px;
      height: 50px;
      background: linear-gradient(45deg, #dbeffd, #dbeffd);
      border-radius: 5px;
      animation: bounce 1.2s infinite ease-in-out;
    }

    .Lodar-bar:nth-child(1) {
      animation-delay: 0s;
    }

    .Lodar-bar:nth-child(2) {
      animation-delay: 0.2s;
    }

    .Lodar-bar:nth-child(3) {
      animation-delay: 0.4s;
    }

    .Lodar-bar:nth-child(4) {
      animation-delay: 0.6s;
    }

    .Lodar-bar:nth-child(5) {
      animation-delay: 0.8s;
    }

    #preloader .loder-loading {
      color: #fff;
      font-size: 16px;
      margin-top: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      animation: fadeIn 1s ease-in-out infinite;
    }

    /* Hide Content Initially */
    #Lodarcontent {
      display: none;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }

    /* Animations */
    @keyframes bounce {

      0%,
      100% {
        transform: scaleY(1);
      }

      50% {
        transform: scaleY(2);
      }
    }

    @keyframes fadeIn {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }
    }
  </style> --}}

</head>

<body>

  {{-- <div id="preloader">
    <div class="Lodar-bar-container">
      <div class="Lodar-bar"></div>
      <div class="Lodar-bar"></div>
      <div class="Lodar-bar"></div>
      <div class="Lodar-bar"></div>
      <div class="Lodar-bar"></div>
    </div>
    <h1 class="loder-loading">Loading...</h1>
  </div> --}}

  <div id="loader" class="LoadingOverlay d-none">
    <div class="Line-Progress">
      <div class="indeterminate"></div>
    </div>
  </div>




  <!-- Navbar Start -->
  <nav id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
          <i class="fa-solid fa-bars-staggered"></i>
        </button>

        <a href="{{ url('/admin-dashboard-home') }}" class="d-flex align-items-center ms-2 text-decoration-none py-1">
          <img src="{{ asset('back-end/assets/img/marss-corporation-logo.svg') }}" alt="মার্স কর্পোরেশন (MARSS CORPORATION)" class="navbar-top-logo" style="height: 38px; max-width: 170px; object-fit: contain;" />
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

      <div class="d-flex align-items-center">
        <button class="light-mode-button" aria-label="Toggle Light Mode" onclick="toggle_light_mode()">
          <span></span>
          <span></span>
        </button>

        <div class="dropdown d-inline-block">
          <button type="button" class="btn header-item search-icon" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <svg width="25" height="25" viewBox="0 0 27 27" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M19.2967 16.9811H18.0695L17.6449 16.5566C19.1578 14.8045 20.0686 12.5274 20.0686 10.0343C20.0686 4.49228 15.5763 0 10.0343 0C4.49228 0 0 4.49228 0 10.0343C0 15.5763 4.49228 20.0686 10.0343 20.0686C12.5274 20.0686 14.8045 19.1578 16.5566 17.6527L16.9811 18.0772V19.2967L24.6998 27L27 24.6998L19.2967 16.9811ZM10.0343 16.9811C6.19811 16.9811 3.08748 13.8705 3.08748 10.0343C3.08748 6.19811 6.19811 3.08748 10.0343 3.08748C13.8705 3.08748 16.9811 6.19811 16.9811 10.0343C16.9811 13.8705 13.8705 16.9811 10.0343 16.9811Z"
                fill="#192045" />
            </svg>
          </button>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
            <form class="p-2">
              <div class="search-box">
                <div class="position-relative">
                  <input type="text" class="form-control rounded border-0"
                    placeholder="Search..." />
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="d-flex align-items-center toggle-full-screen">
          <button class="js-toggle-fullscreen-btn toggle-fullscreen-btn" aria-label="Enter fullscreen mode"
            hidden>
            <svg width="27" height="27" class="toggle-fullscreen-svg" viewBox="0 0 30 30"
              fill="none" xmlns="http://www.w3.org/2000/svg">
              <g class="icon-fullscreen-enter">
                <path
                  d="M2 7.5H0V3C0 2.20435 0.31607 1.44129 0.87868 0.87868C1.44129 0.31607 2.20435 0 3 0H7.5V2H2V7.5Z"
                  fill="#192045" />
                <path
                  d="M30 7.5H28V2H22.5V0H27C27.7956 0 28.5587 0.31607 29.1213 0.87868C29.6839 1.44129 30 2.20435 30 3V7.5Z"
                  fill="#192045" />
                <path
                  d="M7.5 30H3C2.20435 30 1.44129 29.6839 0.87868 29.1213C0.31607 28.5587 0 27.7956 0 27V22.5H2V28H7.5V30Z"
                  fill="#192045" />
                <path
                  d="M27 30H22.5V28H28V22.5H30V27C30 27.7956 29.6839 28.5587 29.1213 29.1213C28.5587 29.6839 27.7956 30 27 30Z"
                  fill="#192045" />
                <path
                  d="M9.00052 10.5C8.80311 10.5011 8.60742 10.4633 8.42466 10.3887C8.24191 10.314 8.07568 10.204 7.93552 10.065L6.43552 8.565C6.15307 8.28255 5.99438 7.89946 5.99438 7.5C5.99438 7.10055 6.15307 6.71746 6.43552 6.435C6.71798 6.15255 7.10107 5.99387 7.50052 5.99387C7.89998 5.99387 8.28307 6.15255 8.56552 6.435L10.0655 7.935C10.2061 8.07445 10.3177 8.24035 10.3939 8.42314C10.47 8.60593 10.5092 8.80199 10.5092 9C10.5092 9.19802 10.47 9.39408 10.3939 9.57687C10.3177 9.75966 10.2061 9.92556 10.0655 10.065C9.92536 10.204 9.75914 10.314 9.57638 10.3887C9.39363 10.4633 9.19793 10.5011 9.00052 10.5Z"
                  fill="#192045" />
                <path
                  d="M20.9995 10.5C20.8021 10.5011 20.6064 10.4633 20.4237 10.3887C20.2409 10.314 20.0747 10.204 19.9345 10.065C19.7939 9.92556 19.6824 9.75966 19.6062 9.57687C19.5301 9.39408 19.4908 9.19802 19.4908 9C19.4908 8.80199 19.5301 8.60593 19.6062 8.42314C19.6824 8.24035 19.7939 8.07445 19.9345 7.935L21.4345 6.435C21.717 6.15255 22.1001 5.99387 22.4995 5.99387C22.899 5.99387 23.2821 6.15255 23.5645 6.435C23.847 6.71746 24.0057 7.10055 24.0057 7.5C24.0057 7.89946 23.847 8.28255 23.5645 8.565L22.0645 10.065C21.9244 10.204 21.7582 10.314 21.5754 10.3887C21.3926 10.4633 21.197 10.5011 20.9995 10.5Z"
                  fill="#192045" />
                <path
                  d="M7.49991 24C7.3025 24.0011 7.10681 23.9633 6.92405 23.8887C6.74129 23.814 6.57507 23.704 6.43491 23.565C6.29432 23.4256 6.18272 23.2597 6.10657 23.0769C6.03042 22.8941 5.99121 22.698 5.99121 22.5C5.99121 22.302 6.03042 22.1059 6.10657 21.9231C6.18272 21.7403 6.29432 21.5744 6.43491 21.435L7.93491 19.935C8.21736 19.6525 8.60046 19.4939 8.99991 19.4939C9.39936 19.4939 9.78245 19.6525 10.0649 19.935C10.3474 20.2175 10.506 20.6006 10.506 21C10.506 21.3995 10.3474 21.7825 10.0649 22.065L8.56491 23.565C8.42475 23.704 8.25852 23.814 8.07577 23.8887C7.89301 23.9633 7.69732 24.0011 7.49991 24Z"
                  fill="#192045" />
                <path
                  d="M22.5 24C22.3026 24.0011 22.1069 23.9633 21.9242 23.8887C21.7414 23.814 21.5752 23.704 21.435 23.565L19.935 22.065C19.6526 21.7825 19.4939 21.3995 19.4939 21C19.4939 20.8022 19.5329 20.6064 19.6085 20.4236C19.6842 20.2409 19.7952 20.0749 19.935 19.935C20.0749 19.7951 20.2409 19.6842 20.4237 19.6085C20.6064 19.5328 20.8022 19.4939 21 19.4939C21.3995 19.4939 21.7826 19.6525 22.065 19.935L23.565 21.435C23.7056 21.5744 23.8172 21.7403 23.8934 21.9231C23.9695 22.1059 24.0087 22.302 24.0087 22.5C24.0087 22.698 23.9695 22.8941 23.8934 23.0769C23.8172 23.2597 23.7056 23.4256 23.565 23.565C23.4249 23.704 23.2587 23.814 23.0759 23.8887C22.8931 23.9633 22.6974 24.0011 22.5 24Z"
                  fill="#192045" />
              </g>
              <g class="icon-fullscreen-leave">
                <path
                  d="M9.00052 10.5C8.80311 10.5011 8.60742 10.4633 8.42466 10.3887C8.24191 10.314 8.07568 10.204 7.93552 10.065L6.43552 8.565C6.15307 8.28255 5.99438 7.89946 5.99438 7.5C5.99438 7.10055 6.15307 6.71746 6.43552 6.435C6.71798 6.15255 7.10107 5.99387 7.50052 5.99387C7.89998 5.99387 8.28307 6.15255 8.56552 6.435L10.0655 7.935C10.2061 8.07445 10.3177 8.24035 10.3939 8.42314C10.47 8.60593 10.5092 8.80199 10.5092 9C10.5092 9.19802 10.47 9.39408 10.3939 9.57687C10.3177 9.75966 10.2061 9.92556 10.0655 10.065C9.92536 10.204 9.75914 10.314 9.57638 10.3887C9.39363 10.4633 9.19793 10.5011 9.00052 10.5Z"
                  fill="#192045" />
                <path
                  d="M20.9995 10.5C20.8021 10.5011 20.6064 10.4633 20.4237 10.3887C20.2409 10.314 20.0747 10.204 19.9345 10.065C19.7939 9.92556 19.6824 9.75966 19.6062 9.57687C19.5301 9.39408 19.4908 9.19802 19.4908 9C19.4908 8.80199 19.5301 8.60593 19.6062 8.42314C19.6824 8.24035 19.7939 8.07445 19.9345 7.935L21.4345 6.435C21.717 6.15255 22.1001 5.99387 22.4995 5.99387C22.899 5.99387 23.2821 6.15255 23.5645 6.435C23.847 6.71746 24.0057 7.10055 24.0057 7.5C24.0057 7.89946 23.847 8.28255 23.5645 8.565L22.0645 10.065C21.9244 10.204 21.7582 10.314 21.5754 10.3887C21.3926 10.4633 21.197 10.5011 20.9995 10.5Z"
                  fill="#192045" />
                <path
                  d="M7.49991 24C7.3025 24.0011 7.10681 23.9633 6.92405 23.8887C6.74129 23.814 6.57507 23.704 6.43491 23.565C6.29432 23.4256 6.18272 23.2597 6.10657 23.0769C6.03042 22.8941 5.99121 22.698 5.99121 22.5C5.99121 22.302 6.03042 22.1059 6.10657 21.9231C6.18272 21.7403 6.29432 21.5744 6.43491 21.435L7.93491 19.935C8.21736 19.6525 8.60046 19.4939 8.99991 19.4939C9.39936 19.4939 9.78245 19.6525 10.0649 19.935C10.3474 20.2175 10.506 20.6006 10.506 21C10.506 21.3995 10.3474 21.7825 10.0649 22.065L8.56491 23.565C8.42475 23.704 8.25852 23.814 8.07577 23.8887C7.89301 23.9633 7.69732 24.0011 7.49991 24Z"
                  fill="#192045" />
                <path
                  d="M22.5 24C22.3026 24.0011 22.1069 23.9633 21.9242 23.8887C21.7414 23.814 21.5752 23.704 21.435 23.565L19.935 22.065C19.6526 21.7825 19.4939 21.3995 19.4939 21C19.4939 20.8022 19.5329 20.6064 19.6085 20.4236C19.6842 20.2409 19.7952 20.0749 19.935 19.935C20.0749 19.7951 20.2409 19.6842 20.4237 19.6085C20.6064 19.5328 20.8022 19.4939 21 19.4939C21.3995 19.4939 21.7826 19.6525 22.065 19.935L23.565 21.435C23.7056 21.5744 23.8172 21.7403 23.8934 21.9231C23.9695 22.1059 24.0087 22.302 24.0087 22.5C24.0087 22.698 23.9695 22.8941 23.8934 23.0769C23.8172 23.2597 23.7056 23.4256 23.565 23.565C23.4249 23.704 23.2587 23.814 23.0759 23.8887C22.8931 23.9633 22.6974 24.0011 22.5 24Z"
                  fill="#192045" />
              </g>
            </svg>
          </button>
        </div>

        <div class="dropdown d-inline-block position-relative">
          <button type="button" class="btn header-item noti-icon position-relative"
            id="page-header-notifications-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" title="কম স্টক নোটিফিকেশন">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.45455 3.4881C6.04947 4.61889 3.63669 7.33014 3.63653 10.5164V16.7253L0.375499 19.3629C0.144442 19.5409 0 19.7945 0 20.0759V20.2035C0 21.2802 1.05824 22.153 2.36364 22.153H8.30287C8.56913 24.0982 10.5705 25.6098 13 25.6098C15.4295 25.6098 17.4309 24.0982 17.6971 22.153H23.6364C24.9418 22.153 26 21.2802 26 20.2035V20.0761C26.0001 19.7947 25.8557 19.541 25.6245 19.3629L22.3638 16.7256V10.5167C22.3637 7.33036 19.9507 4.61872 16.5455 3.48799V2.43688C16.5455 1.16681 15.3593 0.540947 14.8932 0.348687C14.2864 0.0983808 13.6138 0 13 0C12.3862 0 11.7136 0.0983808 11.1068 0.348687C10.6407 0.540947 9.45455 1.16681 9.45455 2.43688V3.4881ZM14.0955 2.92425C14.0894 2.94107 14.083 2.95765 14.0764 2.97398C13.723 2.94113 13.364 2.92425 13.0001 2.92425C12.6362 2.92425 12.2771 2.94114 11.9237 2.97401C11.917 2.95767 11.9106 2.94108 11.9045 2.92425H11.8182V2.43688C11.8182 2.16773 12.3468 1.9495 13 1.9495C13.6532 1.9495 14.1818 2.16773 14.1818 2.43688V2.92425H14.0955ZM15.3025 22.153H10.6975C10.9403 23.0167 11.879 23.6603 13 23.6603C14.121 23.6603 15.0597 23.0167 15.3025 22.153ZM6.00016 10.5164C6.00035 7.41792 9.11241 4.87375 13.0001 4.87375C16.8879 4.87375 20 7.41792 20.0001 10.5164H6.00016ZM6.00016 10.5164H20.0001V16.7256C20.0001 17.2493 20.2555 17.7509 20.7089 18.1175L23.288 20.2035H2.71208L5.6376 17.8373C5.86065 17.6605 6.00016 17.4119 6.00016 17.1347V10.5164Z"
                fill="#192045" />
            </svg>

            <span id="noti-count-badge" class="badge rounded-pill bg-danger" style="position: absolute; top: 12px; right: 6px; font-size: 10px; font-weight: bold; border: 2px solid white; display: none;">0</span>
          </button>
          <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 page-header-notifications-dropdown-v shadow-lg border-0"
            aria-labelledby="page-header-notifications-dropdown-v" style="width: 340px; border-radius: 12px;">
            <div class="p-3 border-bottom bg-light rounded-top">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="m-0 font-size-15 fw-bold text-dark">
                    <i class="fa-solid fa-bell text-danger me-2"></i>স্টক নোটিফিকেশন (১০ এর নিচে)
                  </h6>
                </div>
                <div class="col-auto">
                  <a href="/admin-dashboard-stock-out" class="small fw-bold text-decoration-none text-danger">
                    সব দেখুন <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
            <div id="notification-items-list" data-simplebar style="max-height: 320px; overflow-y: auto;">
              <!-- Dynamic Low Stock Product Notifications Populated via JS -->
              <div class="text-center py-4 px-3">
                <div class="spinner-border spinner-border-sm text-danger me-2" role="status"></div>
                <span class="small text-muted">নোটিফিকেশন লোড হচ্ছে...</span>
              </div>
            </div>
            <div class="p-2 border-top bg-light rounded-bottom text-center">
              <a href="/admin-dashboard-stock-out" class="small fw-bold text-danger text-decoration-none">
                <i class="fa-solid fa-list-check me-1"></i> কম স্টক প্রোডাক্টের সম্পূর্ণ তালিকা দেখুন
              </a>
            </div>
          </div>
        </div>

        <div class="dropdown d-inline-block">
          <button type="button" class="btn header-item user text-start d-flex align-items-center"
            id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img class="rounded-circle header-profile-user"
              id="UserProfileImg" src="{{ asset('back-end/assets/img/profile-img.png') }}" onerror="this.src='{{ asset('back-end/assets/img/profile-img.png') }}'" alt="Header Avatar" style="width: 36px; height: 36px; object-fit: cover;" />
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
    <button type="button"
      class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn vertical-menu-btn2">
      <i class="fa-solid fa-angles-right"></i>
    </button>
    <!-- LOGO Box -->
    <div class="navbar-brand-box">
      <a href="{{url('admin-dashboard')}}" class="logo logo-dark d-flex align-items-center text-decoration-none">
        <span class="logo-sm">
          <img src="{{ asset('back-end/assets/img/marss-corporation-icon.svg') }}" alt="MARSS CORPORATION Icon" width="36" height="36" style="border-radius: 8px; object-fit: contain;" />
        </span>
        <span class="logo-lg d-flex align-items-center gap-2">
          <img src="{{ asset('back-end/assets/img/marss-corporation-icon.svg') }}" alt="MARSS CORPORATION Icon" style="width: 36px; height: 36px; border-radius: 8px; object-fit: contain;" />
          <span class="fw-bold text-white fs-5" style="font-family: 'Baloo Da 2', sans-serif; font-size: 16px !important; letter-spacing: 0.3px;">
            মার্স কর্পোরেশন <span class="badge bg-success text-white px-2 py-1 ms-1" style="font-size: 10px; border-radius: 6px; font-weight: 600; font-family: 'Valley Sans', sans-serif;">POS</span>
          </span>
        </span>
      </a>
    </div>
    <!-- Logo Box End -->

    <!--- Side Menu -->
    <div data-simplebar class="sidebar-menu-scroll">
      <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <div class="nav">
          <div class="menu">
            <ul>
              <li class="active-link">
                <a href="{{ url('admin-dashboard') }}">
                  <i class="fa-solid fa-gauge icon" style="width: 24px; text-align: center;"></i>

                  <span class="text">Dashboard</span>
                </a>
              </li>
              <li class="active-link" data-perm="pos">
                <a href="{{ url('admin-dashboard-pos') }}">
                  <i class="fa-solid fa-cash-register icon" style="width: 24px; text-align: center;"></i>

                  <span class="text">POS</span>
                </a>
              </li>
              <li class="active-link" data-perm="pos">
                <a href="{{ url('admin-dashboard-invoice') }}">
                  <i class="fa-solid fa-file-invoice-dollar icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Invoice List</span>
                </a>
              </li>

              <li class="submenu-active" data-perm="product">
                <a>
                  <i class="fa-solid fa-boxes-stacked icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Product</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-product') }}">
                      <span class="text">Product List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-brand') }}">
                      <span class="text">Brand List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-category') }}">
                      <span class="text">Category List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-barcode-genarate') }}">
                      <span class="text">BarCode Print</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-stock-out') }}">
                      <span class="text text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> কম স্টক প্রোডাক্ট তালিকা</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="purchase">
                <a>
                  <i class="fa-solid fa-truck icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Supplier</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-supplier') }}">
                      <span class="text">Supplier List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('supplier-due-page') }}">
                      <span class="text">Supplier Due List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('supplier-due-collection-page') }}">
                      <span class="text">Due collection List</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="purchase">
                <a>
                  <i class="fa-solid fa-cart-shopping icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Purchase</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-Purchase') }}">
                      <span class="text">Purchase List</span>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="submenu-active" data-perm="customer">
                <a>
                  <i class="fa-solid fa-users icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Customer</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-customer') }}">
                      <span class="text">Customer List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-customer-due-list') }}">
                      <span class="text">Customer Due List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('customer-due-collection-page') }}">
                      <span class="text">Due Collection List</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="expense">
                <a>
                  <i class="fa-solid fa-wallet icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Expense</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-expence-type') }}">
                      <span class="text">Expense Type</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-expence-list') }}">
                      <span class="text">Expense List</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="pos">
                <a>
                  <i class="fa-solid fa-arrow-rotate-left icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Sales Return</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-return-list') }}">
                      <span class="text">Return List</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="expense">
                <a>
                  <i class="fa-solid fa-scale-balanced icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Opening Balance</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-opening-balance') }}">
                      <span class="text">Opening Balance List</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="report">
                <a>
                  <i class="fa-solid fa-chart-pie icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Report</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-daily-ledger-report') }}">
                      <span class="text">Daily Income & Expense Ledger (আয়-ব্যয় লেজার)</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-sales-report') }}">
                      <span class="text">Sales Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-income-expense-report') }}">
                      <span class="text">Income & Expense Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-daily-receipt-payment-report') }}">
                      <span class="text">Daily Receipt & Payment Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-personal-transaction-report') }}">
                      <span class="text">Personal Transaction Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('admin-dashboard-stock-out') }}">
                      <span class="text text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Low Stock Report (কম স্টক)</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="submenu-active" data-perm="user">
                <a>
                  <i class="fa-solid fa-user-shield icon" style="width: 24px; text-align: center;"></i>
                  <span class="text">Role & User</span>
                  <i class="arrow fa-solid fa-angle-down"></i>
                </a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ url('admin-dashboard-user-role') }}">
                      <span class="text">User List & Roles (ইউজার ও পারমিশন)</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="log-out mt-3">
                <a href="#" onclick="userlogout(event)">
                  <i class="fa-solid fa-right-from-bracket icon" style="width: 24px; text-align: center; color: var(--accent-red);"></i>
                  <span class="text">Log Out</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Sidebar -->
    </div>
    </li>
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
  <script src="{{ asset('back-end/assets/js/datepicker.js') }}" type="text/javascript"></script>
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
  <script src="{{ asset('back-end/assets/js/fontawesome.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/full-screen-toggle.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/all-modals.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/table-funtion.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/app.js') }}"></script>


  <script src="{{ asset('back-end/assets/js/style.js') }}"></script>

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
                html += `
                                <a href="/admin-dashboard-stock-out" class="text-reset notification-item d-block p-3 border-bottom text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="rounded-circle bg-danger-subtle text-danger p-2 text-center" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold text-danger fs-6">${p.product_name}</h6>
                                                <span class="badge bg-danger text-white px-2 py-1" style="font-size: 10px; border-radius: 6px;">কম স্টক!</span>
                                            </div>
                                            <p class="mb-0 small text-muted">
                                                কোড: <strong>${p.product_code}</strong> | স্টক: <strong class="text-danger fs-6">${p.quantity} ${p.unit_name}</strong>
                                            </p>
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

    document.addEventListener("DOMContentLoaded", function() {
      loadLowStockNotifications(false);

      const bellBtn = document.getElementById('page-header-notifications-dropdown-v');
      if (bellBtn) {
        bellBtn.addEventListener('click', function() {
          loadLowStockNotifications(false);
        });
      }

      // Poll silently every 60 seconds for live stock alerts (without annoying continuous sound)
      setInterval(() => {
        loadLowStockNotifications(false);
      }, 60000);
    });
  </script>
</body>

</html>