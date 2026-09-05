@extends('layouts.dashboard-sidenav')
@section('title','Admin Profile - মার্স কর্পোরেশন (MARSS CORPORATION)')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid px-0">

            <!-- Profile Page Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-gear text-success"></i> Account Profile & Settings
                    </h1>
                    <p class="text-muted mb-0 small">মার্স কর্পোরেশন (MARSS CORPORATION) - অ্যাডমিন প্রোফাইল ও নিরাপত্তা সেটিংস</p>
                </div>
                <div>
                    <a href="/admin-dashboard" class="btn btn-outline-success fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                    </a>
                </div>
            </div>

            <!-- Profile Banner & Main Content -->
            <div class="row g-4">
                
                <!-- Left Sidebar Profile Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm text-center p-4 h-100" style="border-radius: 20px; background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%); border-top: 5px solid #16a34a !important;">
                        
                        <!-- Avatar Container with Hover Upload -->
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <div class="rounded-circle overflow-hidden shadow-sm border border-4 border-white" style="width: 140px; height: 140px;">
                                <img id="userProfileImage" src="/assets/img/default-avatar.png" alt="Profile Avatar" class="w-100 h-100 object-fit-cover" />
                            </div>
                            <label for="UpdatedProfileImage" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-2 shadow cursor-pointer" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Upload Avatar">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" id="UpdatedProfileImage" accept="image/png, image/jpeg, image/gif" class="d-none" onchange="previewImage(event)" />
                        </div>

                        <h4 id="sidebarUserName" class="fw-bold text-dark mb-1">Loading Name...</h4>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold mb-3 d-inline-block">
                            <i class="fa-solid fa-shield-halved me-1"></i> Store Administrator
                        </span>

                        <div class="text-start border-top pt-3 mt-2">
                            <div class="d-flex align-items-center gap-3 mb-3 text-muted">
                                <div class="rounded-circle bg-light p-2 text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-muted d-block font-size-11 text-uppercase fw-semibold">Email Address</small>
                                    <span id="sidebarUserEmail" class="fw-bold text-dark text-truncate d-block">admin@marsscorporation.com</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3 text-muted">
                                <div class="rounded-circle bg-light p-2 text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block font-size-11 text-uppercase fw-semibold">Mobile Number</small>
                                    <span id="sidebarUserMobile" class="fw-bold text-dark">01700000000</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 text-muted">
                                <div class="rounded-circle bg-light p-2 text-warning d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block font-size-11 text-uppercase fw-semibold">Store Location</small>
                                    <span class="fw-bold text-dark">মার্স কর্পোরেশন (MARSS CORPORATION)</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Form Column -->
                <div class="col-lg-8">
                    <form onsubmit="event.preventDefault(); onUpdate();">
                        
                        <!-- Personal Details Card -->
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                            <div class="card-header bg-white py-3 border-0">
                                <h5 class="fw-bold text-dark mb-0 fs-6">
                                    <i class="fa-solid fa-id-card text-success me-2"></i> Personal Information (ব্যক্তিগত তথ্য)
                                </h5>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">Full Name (পূর্ণ নাম) *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                                            <input type="text" id="userProfileFullName" class="form-control border-start-0 ps-0 fw-semibold" placeholder="Enter full name" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">Phone Number (মোবাইল নম্বর) *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="text" id="userMobileNumber" class="form-control border-start-0 ps-0 fw-semibold" placeholder="Enter phone number" required />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-muted small">Email Address (ইমেইল)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                            <input type="email" id="userEmail" class="form-control border-start-0 ps-0 fw-semibold bg-light" placeholder="Email address" disabled />
                                        </div>
                                        <small class="text-muted font-size-12 mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i> Email address is used for login identification and cannot be changed.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security & Change Password Card -->
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                            <div class="card-header bg-white py-3 border-0">
                                <h5 class="fw-bold text-dark mb-0 fs-6">
                                    <i class="fa-solid fa-lock text-danger me-2"></i> Security & Password (পাসওয়ার্ড পরিবর্তন)
                                </h5>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">New Password (নতুন পাসওয়ার্ড)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                                            <input type="password" id="newPassword" class="form-control border-start-0 border-end-0 ps-0 fw-semibold" placeholder="Leave blank to keep unchanged" />
                                            <button type="button" class="input-group-text bg-light" onclick="togglePassword('newPassword')">
                                                <i class="fa-solid fa-eye text-muted" id="newPassword_icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">Confirm Password (পাসওয়ার্ড নিশ্চিত করুন)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                                            <input type="password" id="confirmPassword" class="form-control border-start-0 border-end-0 ps-0 fw-semibold" placeholder="Confirm new password" />
                                            <button type="button" class="input-group-text bg-light" onclick="togglePassword('confirmPassword')">
                                                <i class="fa-solid fa-eye text-muted" id="confirmPassword_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Bar -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light fw-bold px-4 rounded-pill border">Reset</button>
                            <button type="submit" class="btn btn-success fw-bold px-5 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile Changes
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('userProfileImage').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        getProfile();
    });

    async function getProfile() {
        try {
            if (typeof showLoader === "function") showLoader();
            let res = await axios.get("/user-profile", HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            let data = res.data;

            const avatarSrc = data.img_url || "/assets/img/default-avatar.png";
            document.getElementById("userProfileImage").src = avatarSrc;
            document.getElementById("userProfileFullName").value = data.name || '';
            document.getElementById("userEmail").value = data.email || '';
            document.getElementById("userMobileNumber").value = data.mobile || '';

            // Update Left Sidebar Profile Summary
            document.getElementById("sidebarUserName").innerText = data.name || 'Admin User';
            document.getElementById("sidebarUserEmail").innerText = data.email || 'N/A';
            document.getElementById("sidebarUserMobile").innerText = data.mobile || 'N/A';

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Profile Fetch Error:", e);
            if (typeof unauthorized === "function" && e.response) {
                unauthorized(e.response.status);
            }
        }
    }

    async function onUpdate() {
        let formData = new FormData();

        formData.append("email", document.getElementById('userEmail').value);
        formData.append("name", document.getElementById('userProfileFullName').value);
        formData.append("mobile", document.getElementById('userMobileNumber').value);
        formData.append("password", document.getElementById('newPassword').value);
        formData.append("password_confirmation", document.getElementById('confirmPassword').value);

        const fileInput = document.getElementById('UpdatedProfileImage');
        if (fileInput.files.length > 0) {
            formData.append("img", fileInput.files[0]);
        }

        try {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };
            if (typeof showLoader === "function") showLoader();

            let res = await axios.post("/user-update", formData, config);
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data['status'] === "success") {
                if (typeof successToast === "function") successToast(res.data['message']);
                await getProfile();
            } else {
                if (typeof errorToast === "function") errorToast(res.data['message'] || 'Update failed');
                else alert(res.data['message'] || 'Update failed');
            }
        } catch (error) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Update Error:", error);
            if (typeof unauthorized === "function" && error.response) {
                unauthorized(error.response.status);
            }
        }
    }

    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + "_icon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

@endsection
