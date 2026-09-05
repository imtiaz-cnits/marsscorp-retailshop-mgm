@extends('layouts.app')
@section('title','Admin Login - মার্স কর্পোরেশন (MARSS CORPORATION)')
@section('content')

<style>
  /* Base Container & Background */
  .admin-login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #042f2e 0%, #064e3b 30%, #047857 65%, #0d9488 100%);
    position: relative;
    overflow: hidden;
    padding: 24px;
    font-family: 'Valley Sans', 'Baloo Da 2', sans-serif;
  }

  /* Animated Glowing Mesh Blobs */
  .admin-login-wrapper::before,
  .admin-login-wrapper::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.45;
    z-index: 1;
    animation: blob-pulse 8s infinite alternate ease-in-out;
  }

  .admin-login-wrapper::before {
    width: 420px;
    height: 420px;
    background: #10b981;
    top: -100px;
    left: -100px;
  }

  .admin-login-wrapper::after {
    width: 450px;
    height: 450px;
    background: #34d399;
    bottom: -120px;
    right: -120px;
    animation-delay: 4s;
  }

  @keyframes blob-pulse {
    0% {
      transform: scale(1) translate(0, 0);
    }

    100% {
      transform: scale(1.15) translate(30px, -20px);
    }
  }

  /* Card Layout */
  .login-card-container {
    width: 100%;
    max-width: 960px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 24px;
    box-shadow: 0 25px 60px -15px rgba(4, 120, 87, 0.45), 0 0 30px rgba(16, 185, 129, 0.15);
    overflow: hidden;
    position: relative;
    z-index: 2;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .login-card-grid {
    display: flex;
    flex-wrap: wrap;
  }

  /* Left Hero Branding Section */
  .hero-sidebar {
    width: 45%;
    background: linear-gradient(165deg, #064e3b 0%, #047857 40%, #0d9488 75%, #0f766e 100%);
    padding: 44px 36px;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
  }

  .hero-sidebar::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 20%, rgba(52, 211, 153, 0.15) 0%, transparent 60%);
    pointer-events: none;
  }

  .brand-logo-box {
    background: #ffffff;
    padding: 16px 20px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    max-width: 220px;
    margin-bottom: 28px;
  }

  .brand-logo-box img {
    max-width: 100%;
    height: auto;
    max-height: 75px;
    object-fit: contain;
  }

  .hero-tag {
    display: inline-block;
    background: rgba(52, 211, 153, 0.2);
    border: 1px solid rgba(52, 211, 153, 0.4);
    color: #a7f3d0;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    text-transform: uppercase;
  }

  .hero-title {
    font-size: 26px;
    font-weight: 700;
    line-height: 1.35;
    color: #ffffff;
    margin-bottom: 12px;
  }

  .hero-desc {
    color: #d1fae5;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 30px;
  }

  .feature-list {
    margin-top: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    padding-top: 24px;
  }

  .feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
    font-size: 13px;
    color: #e6f4ea;
  }

  .feature-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6ee7b7;
    flex-shrink: 0;
  }

  /* Right Form Area */
  .form-section {
    width: 55%;
    padding: 44px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #ffffff;
  }

  .form-header {
    margin-bottom: 28px;
  }

  .form-header h3 {
    font-size: 24px;
    font-weight: 700;
    color: #064e3b;
    margin-bottom: 6px;
  }

  .form-header p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
  }

  /* Form Elements */
  .custom-form-group {
    margin-bottom: 20px;
  }

  .custom-form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .input-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-icon-wrapper i,
  .input-icon-wrapper .field-icon {
    position: absolute;
    left: 14px;
    color: #0d9488;
    width: 20px;
    height: 20px;
    pointer-events: none;
    transition: all 0.2s;
  }

  .custom-input {
    width: 100%;
    height: 48px;
    padding: 10px 16px 10px 44px;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    font-size: 14px;
    color: #0f172a;
    background-color: #f8fafc;
    transition: all 0.22s ease-in-out;
  }

  .custom-input:focus {
    border-color: #10b981;
    background-color: #ffffff;
    outline: none;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.18);
  }

  .custom-input::placeholder {
    color: #94a3b8;
  }

  .password-toggle-btn {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    padding: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: background 0.2s;
  }

  .password-toggle-btn:hover {
    background: #f1f5f9;
  }

  .password-toggle-btn img,
  .password-toggle-btn svg {
    width: 20px;
    height: 20px;
    opacity: 0.65;
  }

  /* Submit Button */
  .btn-submit-theme {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
    transition: all 0.25s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 10px;
  }

  .btn-submit-theme:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(16, 185, 129, 0.45);
  }

  .btn-submit-theme:active {
    transform: translateY(0);
  }

  /* Switch Footer */
  .form-switch-footer {
    margin-top: 24px;
    text-align: center;
    font-size: 13px;
    color: #64748b;
  }

  .form-switch-footer a {
    color: #059669;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
    margin-left: 4px;
  }

  .form-switch-footer a:hover {
    color: #047857;
    text-decoration: underline !important;
  }

  /* Responsive Design */
  @media (max-width: 820px) {
    .hero-sidebar {
      width: 100%;
      padding: 32px 24px;
    }

    .form-section {
      width: 100%;
      padding: 32px 24px;
    }

    .login-card-container {
      max-width: 500px;
    }
  }
</style>

<div class="admin-login-wrapper">
  <div class="login-card-container">

    <!-- Sign In Card Start -->
    <div class="login-card-grid" id="signInCard" style="display: flex;">
      <!-- Left Hero Sidebar -->
      <div class="hero-sidebar">
        <div>
          <div class="brand-logo-box">
            <img src="{{asset('backend/assets/img/marss-corporation-logo.svg')}}" alt="MARSS CORPORATION Logo" />
          </div>
          <span class="hero-tag">অ্যাডমিন সিকিউর পোর্টাল</span>
          <h2 class="hero-title">মার্স কর্পোরেশন (MARSS CORPORATION)</h2>
          <p class="hero-desc">আপনার রিটেইল ও হোলসেল পস কন্ট্রোল প্যানেলে নিরাপদে প্রবেশ করুন।</p>
        </div>

        <div class="feature-list">
          <div class="feature-item">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
              </svg>
            </div>
            <span>হাই-সিকিউরিটি এনক্রিপ্টেড সাইন-ইন</span>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
              </svg>
            </div>
            <span>ইনভেন্টরি, সেলস ও রিয়েলটাইম রিপোর্ট</span>
          </div>
        </div>
      </div>

      <!-- Right Form Section -->
      <div class="form-section">
        <div class="form-header">
          <h3>লগইন করুন</h3>
          <p>অ্যাডমিন প্যানেলে প্রবেশের জন্য আপনার ইমেইল ও পাসওয়ার্ড প্রদান করুন</p>
        </div>

        <form onsubmit="SubmitLogin(event)">
          <div class="custom-form-group">
            <label for="email">ইমেইল ঠিকানা (Email Address)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <input type="email" id="email" class="custom-input" placeholder="admin@example.com" required />
            </div>
          </div>

          <div class="custom-form-group">
            <label for="password">পাসওয়ার্ড (Password)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              <input type="password" id="password" class="custom-input" style="padding-right: 48px;" placeholder="••••••••" required />
              <button type="button" class="password-toggle-btn" onclick="togglePassword('password', 'eyeIcon')" title="Toggle visibility">
                <img id="eyeIcon" src="{{ asset('backend/assets/icons/password-eye-icon.svg') }}" alt="Eye Icon" />
              </button>
            </div>
          </div>

          <button type="submit" class="btn-submit-theme">
            <span>সাইন ইন (SIGN IN)</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </form>

        <div class="form-switch-footer">
          অ্যাকাউন্ট নেই? <a href="#" onclick="switchCard(event)">নতুন অ্যাকাউন্ট তৈরি করুন</a>
        </div>
      </div>
    </div>
    <!-- Sign In Card End -->

    <!-- Registration Card Start -->
    <div class="login-card-grid" id="signUpCard" style="display: none;">
      <!-- Left Hero Sidebar -->
      <div class="hero-sidebar">
        <div>
          <div class="brand-logo-box">
            <img src="{{asset('backend/assets/img/marss-corporation-logo.svg')}}" alt="MARSS CORPORATION Logo" />
          </div>
          <span class="hero-tag">নতুন ইউজার রেজিস্ট্রেশন</span>
          <h2 class="hero-title">অ্যাডমিন রেজিস্ট্রেশন</h2>
          <p class="hero-desc">মার্স কর্পোরেশন (MARSS CORPORATION) ম্যানেজমেন্ট সিস্টেমে নতুন অ্যাডমিন অ্যাকাউন্ট খুলুন।</p>
        </div>

        <div class="feature-list">
          <div class="feature-item">
            <div class="feature-icon">✓</div>
            <span>সম্পূর্ণ সিস্টেম অ্যাক্সেস কন্ট্রোল</span>
          </div>
          <div class="feature-item">
            <div class="feature-icon">✓</div>
            <span>সহজ ও দ্রুত প্রোফাইল ভেরিফিকেশন</span>
          </div>
        </div>
      </div>

      <!-- Right Form Section -->
      <div class="form-section">
        <div class="form-header">
          <h3>রেজিস্ট্রেশন করুন</h3>
          <p>আপনার ব্যক্তিগত ও অ্যাকাউন্টের বিবরণ দিন</p>
        </div>

        <form onsubmit="event.preventDefault();">
          <div class="custom-form-group">
            <label for="name">পূর্ণ নাম (Full Name)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <input type="text" id="name" class="custom-input" placeholder="আপনার নাম লিখুন" />
            </div>
          </div>

          <div class="custom-form-group">
            <label for="register-email">ইমেইল (Email Address)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <input type="email" id="register-email" class="custom-input" placeholder="email@example.com" />
            </div>
          </div>

          <div class="custom-form-group">
            <label for="mobile">মোবাইল নম্বর (Phone Number)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <input type="number" id="mobile" class="custom-input" placeholder="01700000000" />
            </div>
          </div>

          <div class="custom-form-group">
            <label for="register-password">পাসওয়ার্ড (Password)</label>
            <div class="input-icon-wrapper">
              <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              <input type="password" id="register-password" class="custom-input" style="padding-right: 48px;" placeholder="••••••••" />
              <button type="button" class="password-toggle-btn" onclick="togglePassword('register-password', 'regEyeIcon')" title="Toggle visibility">
                <img id="regEyeIcon" src="{{ asset('backend/assets/icons/password-eye-icon.svg') }}" alt="Eye Icon" />
              </button>
            </div>
          </div>

          <input id="status" value="approved" type="hidden" />
          <input id="role" value="admin" type="hidden" />

          <div class="custom-form-group">
            <label>প্রোফাইল ছবি (Profile Image)</label>
            <div class="d-flex align-items-center gap-3">
              <img id="newImg" src="{{asset('images/default.jpg')}}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #10b981;" />
              <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control form-control-sm" id="img_url" />
            </div>
          </div>

          <button type="button" onclick="onRegistration()" class="btn-submit-theme">
            <span>সাইন আপ (SIGN UP)</span>
          </button>
        </form>

        <div class="form-switch-footer">
          ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="#" onclick="switchCard(event)">সাইন ইন করুন</a>
        </div>
      </div>
    </div>
    <!-- Registration Card End -->

  </div>
</div>

<script>
  function togglePassword(inputId = 'password', iconId = 'eyeIcon') {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);

    if (!passwordInput) return;

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      if (eyeIcon) eyeIcon.style.opacity = "1";
    } else {
      passwordInput.type = "password";
      if (eyeIcon) eyeIcon.style.opacity = "0.65";
    }
  }

  function switchCard(event) {
    if (event) {
      event.preventDefault();
    }
    const signInCard = document.getElementById("signInCard");
    const signUpCard = document.getElementById("signUpCard");

    if (!signInCard || !signUpCard) return;

    if (signInCard.style.display === "none") {
      signInCard.style.display = "flex";
      signUpCard.style.display = "none";
    } else {
      signInCard.style.display = "none";
      signUpCard.style.display = "flex";
    }
  }

  async function onRegistration() {
    try {
      let name = document.getElementById('name').value.trim();
      let email = document.getElementById('register-email').value.trim();
      let password = document.getElementById('register-password').value.trim();
      let mobile = document.getElementById('mobile').value.trim();
      let status = document.getElementById('status').value.trim();
      let role = document.getElementById('role').value.trim();
      let imgInput = document.getElementById('img_url');
      let imgFile = imgInput ? imgInput.files[0] : null;

      let formData = new FormData();
      if (imgFile) formData.append('img', imgFile);
      formData.append('name', name);
      formData.append('email', email);
      formData.append('password', password);
      formData.append('mobile', mobile);
      formData.append('status', status);
      formData.append('role', role);

      showLoader();
      let response = await axios.post("user-registration", formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      hideLoader();

      if (response.status === 200 && response.data.status === 'success') {
        successToast('User registered successfully.');
        window.location.href = "/admin-login-page";
      } else {
        errorToast(response.data.message || 'Registration failed.');
      }
    } catch (error) {
      hideLoader();
      errorToast('An error occurred during registration. Please try again later.');
      console.error('Registration Error:', error);
    }
  }

  async function SubmitLogin(event) {
    event.preventDefault();
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email.length === 0) {
      errorToast("Email is required");
    } else if (password.length === 0) {
      errorToast("Password is required");
    } else {
      showLoader();
      try {
        let res = null;
        let origin = window.location.origin;
        let pathName = window.location.pathname;
        let baseDir = pathName.substring(0, pathName.lastIndexOf('/'));

        let loginEndpoints = [
          "{{ url('/admin-login-page') }}",
          origin + "/admin-login-page",
          origin + "/index.php/admin-login-page",
          "{{ url('/api/admin-login-page') }}",
          origin + "/api/admin-login-page",
          origin + "/index.php/api/admin-login-page",
          "{{ url('/api/user-login') }}",
          origin + baseDir + "/admin-login-page",
          origin + baseDir + "/index.php/admin-login-page"
        ];

        let lastError = null;
        for (let endpoint of loginEndpoints) {
          if (!endpoint) continue;
          try {
            console.log("Trying login endpoint:", endpoint);
            let response = await axios.post(endpoint, {
              email: email,
              password: password
            });
            if (response && (response.status === 200 || response.status === 201)) {
              res = response;
              break;
            }
          } catch (err) {
            lastError = err;
            if (err.response && err.response.status === 404) {
              continue;
            } else {
              throw err;
            }
          }
        }

        if (!res && lastError) {
          throw lastError;
        }

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
          errorToast((res && res.data && res.data['message']) ? res.data['message'] : "Login failed");
        }
      } catch (error) {
        hideLoader();
        console.error("Login Error Details:", error);
        let msg = "An error occurred while logging in";
        if (error.response) {
          if (error.response.data && error.response.data.message) {
            msg = error.response.data.message;
          } else if (error.response.status === 419) {
            msg = "CSRF Token Mismatch (419). Please refresh page.";
          } else if (error.response.status === 500) {
            msg = "Server Error (500). Please check DB / personal_access_tokens table.";
          } else if (error.response.status === 404) {
            msg = "Login endpoint 404. Please run /clear-cache.php on live server.";
          }
        } else if (error.request) {
          msg = "Network Error: Unable to reach server.";
        }
        errorToast(msg);
      }
    }
  }
</script>
@endsection