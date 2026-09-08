@extends('layouts.app')
@section('title','Admin Login - MARSS CORPORATION')
@section('content')

<style>
  /* =========================================================
     MARSS LOGIN — MACS School Style (v2)
  ========================================================= */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body { font-family: 'Inter','Segoe UI',system-ui,sans-serif; }

  /* ---- Page Wrapper ---- */
  .auth-page {
    min-height: 100vh;
    display: flex;
  }

  /* =========================================================
     LEFT PANEL — #428A34 gradient + background image
  ========================================================= */
  .auth-left {
    width: 46%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
  }

  /* Background image layer */
  .auth-left-bg-img {
    position: absolute;
    inset: 0;
    background: url('{{ asset("backend/assets/img/login-bg.jpg") }}') center center / cover no-repeat;
    z-index: 0;
  }

  /* Deep green glass gradient overlay on top of image */
  .auth-left-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(
      150deg,
      rgba(10, 30, 8, 0.88)  0%,
      rgba(22, 58, 14, 0.85) 20%,
      rgba(36, 88, 22, 0.80) 45%,
      rgba(52, 110, 32, 0.75) 70%,
      rgba(66, 138, 52, 0.70) 100%
    );
    z-index: 1;
  }

  /* Animated mesh blobs */
  .auth-left-blob1,
  .auth-left-blob2 {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    opacity: 0.28;
    z-index: 2;
    animation: blobFloat 9s infinite alternate ease-in-out;
  }

  .auth-left-blob1 {
    width: 380px; height: 380px;
    background: #72c45e;
    top: -80px; left: -80px;
  }

  .auth-left-blob2 {
    width: 340px; height: 340px;
    background: #1a3d10;
    bottom: -80px; right: -80px;
    animation-delay: 4.5s;
  }

  @keyframes blobFloat {
    0%   { transform: scale(1)    translate(0,   0);   }
    100% { transform: scale(1.18) translate(25px,-20px); }
  }

  /* Pattern overlay (subtle dots) */
  .auth-left-pattern {
    position: absolute;
    inset: 0;
    z-index: 3;
    opacity: 0.07;
    background-image: radial-gradient(circle, #fff 1px, transparent 1px);
    background-size: 28px 28px;
  }

  /* ---- Brand card (glassmorphism) ---- */
  .auth-brand-card {
    position: relative;
    z-index: 4;
    background: rgba(8, 22, 6, 0.55);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(114, 196, 94, 0.18);
    border-radius: 24px;
    padding: 50px 44px;
    text-align: center;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 28px 64px rgba(0,0,0,0.55), inset 0 1px 0 rgba(255,255,255,0.08);
  }

  .auth-logo-box {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1.5px solid rgba(255, 255, 255, 0.28);
    border-radius: 18px;
    padding: 14px 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 22px;
    max-width: 220px;
    box-shadow: 0 10px 36px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.22);
  }

  .auth-logo-box img {
    max-height: 68px;
    max-width: 180px;
    object-fit: contain;
  }

  .auth-brand-name {
    font-size: 24px;
    font-weight: 800;
    color: #a3f08b;
    letter-spacing: 0.4px;
    line-height: 1.3;
    margin-bottom: 10px;
    text-transform: uppercase;
  }

  .auth-brand-tagline {
    font-size: 14px;
    color: #d1fae5;
    line-height: 1.6;
    margin-bottom: 26px;
  }

  .auth-brand-badge {
    display: inline-block;
    background: rgba(114, 196, 94, 0.18);
    border: 1px solid rgba(114, 196, 94, 0.40);
    color: #a3f08b;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 6px 18px;
    border-radius: 999px;
  }

  /* =========================================================
     RIGHT PANEL — form area (light / dark)
  ========================================================= */
  .auth-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 48px;
    background: #ffffff;
    position: relative;
    overflow-y: auto;
    transition: background 0.3s, color 0.3s;
  }

  /* ----------- DARK MODE (right panel) ----------- */
  .auth-right.dark-panel {
    background: #0f172a;
  }

  .auth-right.dark-panel .auth-form-title  { color: #f1f5f9; }
  .auth-right.dark-panel .auth-form-subtitle { color: #94a3b8; }
  .auth-right.dark-panel .auth-field label { color: #cbd5e1; }

  .auth-right.dark-panel .auth-input {
    background: #1e293b;
    border-color: #334155;
    color: #f1f5f9;
  }
  .auth-right.dark-panel .auth-input::placeholder { color: #475569; }
  .auth-right.dark-panel .auth-input:focus {
    border-color: #428A34;
    background: #1e293b;
    box-shadow: 0 0 0 4px rgba(66,138,52,0.22);
  }

  .auth-right.dark-panel .auth-eye-btn:hover { background: #1e293b; }
  .auth-right.dark-panel .auth-switch { color: #94a3b8; }
  .auth-right.dark-panel .auth-switch a { color: #5aab47; }
  .auth-right.dark-panel .auth-file-input {
    background: #1e293b;
    border-color: #334155;
    color: #cbd5e1;
  }
  .auth-right.dark-panel .auth-powered { color: #475569; }
  .auth-right.dark-panel .auth-powered strong { color: #5aab47; }

  /* ---- Toggle button (top-right) ---- */
  .auth-toggle-wrap {
    position: absolute;
    top: 22px;
    right: 28px;
  }

  .auth-theme-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, border-color 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  }

  .auth-theme-btn:hover {
    transform: rotate(20deg) scale(1.08);
    border-color: #428A34;
  }

  .auth-right.dark-panel .auth-theme-btn {
    background: #1e293b;
    border-color: #334155;
  }

  .auth-theme-btn svg { width: 20px; height: 20px; }

  /* Sun icon (visible in dark mode) */
  .icon-sun  { display: none; color: #f59e0b; }
  .icon-moon { display: block; color: #428A34; }
  .auth-right.dark-panel .icon-sun  { display: block; }
  .auth-right.dark-panel .icon-moon { display: none; }

  /* ---- Form container ---- */
  .auth-form-box {
    width: 100%;
    max-width: 460px;
  }

  .auth-form-title {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 4px;
    letter-spacing: -0.3px;
  }

  .auth-form-subtitle {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 18px;
  }

  /* ---- Fields ---- */
  .auth-field { margin-bottom: 13px; }

  .auth-field label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 5px;
  }

  .auth-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }

  .auth-input-wrap .auth-icon {
    position: absolute;
    left: 15px;
    width: 18px;
    height: 18px;
    color: #94a3b8;
    pointer-events: none;
    flex-shrink: 0;
  }

  .auth-input {
    width: 100%;
    height: 42px;
    padding: 0 44px 0 40px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
  }

  .auth-input:focus {
    border-color: #428A34;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(66,138,52,0.14);
  }

  .auth-input::placeholder { color: #94a3b8; }

  .auth-eye-btn {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    padding: 7px;
    cursor: pointer;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
  }
  .auth-eye-btn:hover { background: #f1f5f9; }
  .auth-eye-btn img, .auth-eye-btn svg { width: 19px; height: 19px; opacity: 0.6; }

  /* ---- Submit Button ---- */
  .auth-btn {
    width: 100%;
    height: 46px;
    background: linear-gradient(135deg, #428A34 0%, #2d6120 100%);
    color: #ffffff;
    font-size: 13.5px;
    font-weight: 700;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 6px 18px rgba(66,138,52,0.32);
    transition: all 0.25s ease;
    margin-top: 6px;
  }

  .auth-btn:hover {
    background: linear-gradient(135deg, #2d6120 0%, #1a3d10 100%);
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(66,138,52,0.45);
  }

  .auth-btn:active { transform: translateY(0); }

  /* ---- Switch footer ---- */
  .auth-switch {
    text-align: center;
    font-size: 13px;
    color: #64748b;
    margin-top: 14px;
  }

  .auth-switch a {
    color: #428A34;
    font-weight: 700;
    text-decoration: none;
    margin-left: 4px;
    transition: color 0.2s;
  }

  .auth-switch a:hover { color: #2d6120; text-decoration: underline; }

  /* ---- Powered by ---- */
  .auth-powered {
    position: absolute;
    bottom: 20px;
    right: 28px;
    font-size: 11px;
    color: #94a3b8;
    letter-spacing: 0.4px;
  }

  .auth-powered strong { color: #428A34; font-weight: 700; }

  /* ---- Profile image ---- */
  .avatar-preview {
    width: 52px; height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #428A34;
    flex-shrink: 0;
  }

  .auth-file-input {
    flex: 1;
    font-size: 13px;
    padding: 8px 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    color: #374151;
    cursor: pointer;
  }

  /* =========================================================
     RESPONSIVE
  ========================================================= */
  @media (max-width: 900px) {
    .auth-left { display: none; }
    .auth-right { min-height: 100vh; padding: 40px 24px; }
    .auth-form-box { max-width: 100%; }
  }

  @media (max-width: 480px) {
    .auth-right { padding: 28px 16px; }
    .auth-form-title { font-size: 23px; }
  }
</style>

<div class="auth-page">

  <!-- ============================
       LEFT PANEL — gradient + brand card
  ============================= -->
  <div class="auth-left">
    <div class="auth-left-bg-img"></div>
    <div class="auth-left-gradient"></div>
    <div class="auth-left-blob1"></div>
    <div class="auth-left-blob2"></div>
    <div class="auth-left-pattern"></div>

    <div class="auth-brand-card">
      <div class="auth-logo-box">
        <img src="{{ asset('backend/assets/img/marss-corporation-logo.svg') }}" alt="MARSS CORPORATION" />
      </div>
      <div class="auth-brand-name" id="leftPanelTitle">MARSS CORPORATION</div>
      <p class="auth-brand-tagline" id="leftPanelTagline">Retail &amp; Wholesale Management System</p>
      <span class="auth-brand-badge" id="leftPanelBadge">Admin Secure Portal</span>
    </div>
  </div>

  <!-- ============================
       RIGHT PANEL — form area
  ============================= -->
  <div class="auth-right" id="authRight">

    <!-- Dark / Light Toggle -->
    <div class="auth-toggle-wrap">
      <button class="auth-theme-btn" onclick="toggleAuthTheme()" title="Toggle dark mode" type="button">
        <!-- Moon (shown in light mode) -->
        <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
        </svg>
        <!-- Sun (shown in dark mode) -->
        <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="5"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
        </svg>
      </button>
    </div>

    <!-- ---- SIGN IN CARD ---- -->
    <div class="auth-form-box" id="signInCard" style="display:block;">
      <h1 class="auth-form-title">WELCOME BACK!</h1>
      <p class="auth-form-subtitle">Please sign in to your dashboard</p>

      <form onsubmit="SubmitLogin(event)">
        <div class="auth-field">
          <label for="email">EMAIL ADDRESS</label>
          <div class="auth-input-wrap">
            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <input type="email" id="email" class="auth-input" placeholder="admin@example.com" required />
          </div>
        </div>

        <div class="auth-field">
          <label for="password">PASSWORD</label>
          <div class="auth-input-wrap">
            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <input type="password" id="password" class="auth-input" placeholder="••••••••" required />
            <button type="button" class="auth-eye-btn" onclick="togglePassword('password','eyeIcon')" title="Toggle visibility">
              <img id="eyeIcon" src="{{ asset('backend/assets/icons/password-eye-icon.svg') }}" alt="Eye Icon" />
            </button>
          </div>
        </div>

        <button type="submit" class="auth-btn">
          SIGN IN TO DASHBOARD
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div class="auth-switch">
        Don't have an account?
        <a href="#" onclick="switchCard(event)">Create new account</a>
      </div>
    </div>

    <!-- ---- SIGN UP CARD ---- -->
    <div class="auth-form-box" id="signUpCard" style="display:none;">
      <h1 class="auth-form-title">CREATE ACCOUNT</h1>
      <p class="auth-form-subtitle">Fill in your details to register a new admin account</p>

      <form onsubmit="event.preventDefault();">
        <div class="auth-field">
          <label for="name">FULL NAME</label>
          <div class="auth-input-wrap">
            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <input type="text" id="name" class="auth-input" placeholder="Your full name" />
          </div>
        </div>

        <div class="auth-field">
          <label for="register-email">EMAIL ADDRESS</label>
          <div class="auth-input-wrap">
            <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <input type="email" id="register-email" class="auth-input" placeholder="email@example.com" />
          </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:13px;">

          <div class="auth-field" style="margin-bottom:0;">
            <label for="mobile">PHONE NUMBER</label>
            <div class="auth-input-wrap">
              <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              <input type="number" id="mobile" class="auth-input" placeholder="01700000000" />
            </div>
          </div>

          <div class="auth-field" style="margin-bottom:0;">
            <label for="register-password">PASSWORD</label>
            <div class="auth-input-wrap">
              <svg class="auth-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <input type="password" id="register-password" class="auth-input" placeholder="••••••••" />
              <button type="button" class="auth-eye-btn" onclick="togglePassword('register-password','regEyeIcon')" title="Toggle visibility">
                <img id="regEyeIcon" src="{{ asset('backend/assets/icons/password-eye-icon.svg') }}" alt="Eye Icon" />
              </button>
            </div>
          </div>

        </div><!-- end 2-col grid -->

        <input id="status" value="approved" type="hidden" />
        <input id="role" value="admin" type="hidden" />

        <div class="auth-field">
          <label>PROFILE IMAGE</label>
          <div style="display:flex;align-items:center;gap:10px;">
            <img id="newImg" src="{{ asset('images/default.jpg') }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #428A34;flex-shrink:0;" alt="Preview" />
            <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="auth-file-input" id="img_url" style="font-size:12px;padding:5px 10px;" />
          </div>
        </div>

        <button type="button" onclick="onRegistration()" class="auth-btn">
          SIGN UP
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div class="auth-switch">
        Already have an account?
        <a href="#" onclick="switchCard(event)">Sign In</a>
      </div>
    </div>

    <!-- Powered by -->
    <div class="auth-powered">POWERED BY <strong><a href="https://codenextit.com" target="_blank" style="color:inherit;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">CODE NEXT IT</a></strong></div>
  </div>

</div>

<script>
  /* ---- Dark / Light toggle (right panel only) ---- */
  function toggleAuthTheme() {
    const panel = document.getElementById('authRight');
    panel.classList.toggle('dark-panel');
    localStorage.setItem('authDark', panel.classList.contains('dark-panel') ? '1' : '0');
  }

  /* Restore on load */
  (function () {
    if (localStorage.getItem('authDark') === '1') {
      const panel = document.getElementById('authRight');
      if (panel) panel.classList.add('dark-panel');
    }
  })();

  /* ---- Switch Sign In / Sign Up ---- */
  function switchCard(event) {
    if (event) event.preventDefault();
    const signInCard = document.getElementById('signInCard');
    const signUpCard = document.getElementById('signUpCard');
    const title      = document.getElementById('leftPanelTitle');
    const tagline    = document.getElementById('leftPanelTagline');
    const badge      = document.getElementById('leftPanelBadge');

    if (!signInCard || !signUpCard) return;

    if (signInCard.style.display === 'none') {
      signInCard.style.display = 'block';
      signUpCard.style.display = 'none';
      if (title)   title.textContent   = 'MARSS CORPORATION';
      if (tagline) tagline.textContent = 'Retail & Wholesale Management System';
      if (badge)   badge.textContent   = 'Admin Secure Portal';
    } else {
      signInCard.style.display = 'none';
      signUpCard.style.display = 'block';
      if (title)   title.textContent   = 'ADMIN REGISTRATION';
      if (tagline) tagline.textContent = 'Create a new admin account for MARSS CORPORATION';
      if (badge)   badge.textContent   = 'New User Registration';
    }
  }

  /* ---- Password Toggle ---- */
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input) return;
    if (input.type === 'password') {
      input.type = 'text';
      if (icon) icon.style.opacity = '1';
    } else {
      input.type = 'password';
      if (icon) icon.style.opacity = '0.6';
    }
  }

  /* ---- Registration ---- */
  async function onRegistration() {
    try {
      let name     = document.getElementById('name').value.trim();
      let email    = document.getElementById('register-email').value.trim();
      let password = document.getElementById('register-password').value.trim();
      let mobile   = document.getElementById('mobile').value.trim();
      let status   = document.getElementById('status').value.trim();
      let role     = document.getElementById('role').value.trim();
      let imgInput = document.getElementById('img_url');
      let imgFile  = imgInput ? imgInput.files[0] : null;

      let formData = new FormData();
      if (imgFile) formData.append('img', imgFile);
      formData.append('name', name);
      formData.append('email', email);
      formData.append('password', password);
      formData.append('mobile', mobile);
      formData.append('status', status);
      formData.append('role', role);

      showLoader();
      let response = await axios.post('user-registration', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      hideLoader();

      if (response.status === 200 && response.data.status === 'success') {
        successToast('User registered successfully.');
        window.location.href = '/admin-login-page';
      } else {
        errorToast(response.data.message || 'Registration failed.');
      }
    } catch (error) {
      hideLoader();
      errorToast('An error occurred during registration. Please try again later.');
      console.error('Registration Error:', error);
    }
  }

  /* ---- Login ---- */
  async function SubmitLogin(event) {
    event.preventDefault();
    let email    = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email.length === 0) {
      errorToast('Email is required');
    } else if (password.length === 0) {
      errorToast('Password is required');
    } else {
      showLoader();
      try {
        let res      = null;
        let origin   = window.location.origin;
        let pathName = window.location.pathname;
        let baseDir  = pathName.substring(0, pathName.lastIndexOf('/'));

        let loginEndpoints = [
          "{{ url('/admin-login-page') }}",
          origin + '/admin-login-page',
          origin + '/index.php/admin-login-page',
          "{{ url('/api/admin-login-page') }}",
          origin + '/api/admin-login-page',
          origin + '/index.php/api/admin-login-page',
          "{{ url('/api/user-login') }}",
          origin + baseDir + '/admin-login-page',
          origin + baseDir + '/index.php/admin-login-page'
        ];

        let lastError = null;
        for (let endpoint of loginEndpoints) {
          if (!endpoint) continue;
          try {
            console.log('Trying login endpoint:', endpoint);
            let response = await axios.post(endpoint, { email, password });
            if (response && (response.status === 200 || response.status === 201)) {
              res = response; break;
            }
          } catch (err) {
            lastError = err;
            if (err.response && err.response.status === 404) { continue; }
            else { throw err; }
          }
        }

        if (!res && lastError) throw lastError;

        hideLoader();
        if (res && res.status === 200 && res.data['status'] === 'success') {
          setToken(res.data['token']);
          let userRole = (res.data['role'] || '').toLowerCase();
          localStorage.setItem('user_role', userRole);
          localStorage.setItem('user_permissions', JSON.stringify(res.data['permissions'] || null));

          if (userRole === 'cashier') {
            window.location.href = "{{ url('/admin-dashboard-pos') }}";
          } else {
            window.location.href = "{{ url('/admin-dashboard') }}";
          }
        } else {
          errorToast((res && res.data && res.data['message']) ? res.data['message'] : 'Login failed');
        }
      } catch (error) {
        hideLoader();
        console.error('Login Error Details:', error);
        let msg = 'An error occurred while logging in';
        if (error.response) {
          if (error.response.data && error.response.data.message) {
            msg = error.response.data.message;
          } else if (error.response.status === 419) {
            msg = 'CSRF Token Mismatch (419). Please refresh page.';
          } else if (error.response.status === 500) {
            msg = 'Server Error (500). Please check DB / personal_access_tokens table.';
          } else if (error.response.status === 404) {
            msg = 'Login endpoint 404. Please run /clear-cache.php on live server.';
          }
        } else if (error.request) {
          msg = 'Network Error: Unable to reach server.';
        }
        errorToast(msg);
      }
    }
  }
</script>
@endsection