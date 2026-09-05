<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('backend/assets/css/toastify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/progress.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/animate.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/assets/js/toastify-js.js') }}"></script>
    <script src="{{ asset('backend/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/config.js') }}"></script>
</head>
<body>

<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h4 class="text-center mb-3">Verify OTP</h4>
        <p class="text-muted text-center">Enter the 6-digit code sent to your email</p>

        <form id="otpForm" onsubmit="submitOtp(event)">
            <input type="hidden" id="otp_email">

            <div class="mb-3">
                <input type="text" id="otp_code" class="form-control text-center fw-bold fs-4"
                       maxlength="6" placeholder="Enter OTP" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>

        <div class="mt-3 text-center">
            <small>Didn't receive the code? <a href="#" onclick="resendOtp()">Resend</a></small>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the email from localStorage or redirect to login if not found
    let email = localStorage.getItem('otp_email');
    if (!email) {
        alert("Email not found. Please login again.");
        window.location.href = "/"; // Redirect to login page if no email found
        return;
    }
    document.getElementById('otp_email').value = email;
});

async function submitOtp(event) {
    event.preventDefault();

    let email = document.getElementById('otp_email').value;  // Correct ID here
    let otp = document.getElementById('otp_code').value;     // Correct ID here

    if (otp.length !== 6) {
        alert("Please enter a 6-digit OTP.");
        return;
    }

    try {
        let res = await axios.post("/verify-otp", { email: email, otp: otp });

        if (res.status === 200 && res.data.status === 'success') {
            setToken(res.data['token']);
            alert("OTP verified successfully. Redirecting...");
            window.location.href = "/admin-dashboard"; // Redirect to the dashboard after success
        } else {
            alert(res.data.message); // Show error message from the server
        }
    } catch (error) {
        console.error("Error during OTP verification:", error);
        alert("Something went wrong. Try again.");
    }
}

function resendOtp() {
    const email = localStorage.getItem('otp_email');
    if (!email) {
        alert("Email not found. Please login again.");
        window.location.href = "/"; // Redirect to login page if no email found
        return;
    }

    axios.post("/resend-otp", { email: email })
        .then(res => {
            if (res.data.status === "otp_sent") {
                alert("OTP resent to your email.");
            } else {
                alert(res.data.message);
            }
        })
        .catch(() => {
            alert("Error resending OTP.");
        });
}
</script>

</body>
</html>
