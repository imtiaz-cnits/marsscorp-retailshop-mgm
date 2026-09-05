// Global App Configuration & Authentication Helpers

export function showLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.classList.remove('d-none', 'hidden');
    }
}

export function hideLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.classList.add('d-none', 'hidden');
    }
}

export function successToast(msg) {
    if (typeof Toastify === 'function') {
        Toastify({
            gravity: "bottom",
            position: "left",
            text: msg,
            className: "mb-4 ms-2",
            style: {
                background: "linear-gradient(135deg, #15803d 0%, #16a34a 100%)",
                borderRadius: "8px",
                boxShadow: "0 4px 14px rgba(0, 0, 0, 0.25)",
                fontSize: "13.5px",
                fontWeight: "600",
                zIndex: "999999",
            }
        }).showToast();
    } else {
        console.log('SUCCESS:', msg);
    }
}

export function errorToast(msg) {
    if (typeof Toastify === 'function') {
        Toastify({
            gravity: "bottom",
            position: "left",
            text: msg,
            className: "mb-4 ms-2",
            style: {
                background: "linear-gradient(135deg, #b91c1c 0%, #dc2626 100%)",
                borderRadius: "8px",
                boxShadow: "0 4px 14px rgba(0, 0, 0, 0.25)",
                fontSize: "13.5px",
                fontWeight: "600",
                zIndex: "999999",
            }
        }).showToast();
    } else {
        console.error('ERROR:', msg);
    }
}

let logoutTimer;

export function startLogoutTimer() {
    if (logoutTimer) {
        clearTimeout(logoutTimer);
    }
    logoutTimer = setTimeout(logout, 43200000); // 12 hours in ms
}

export function resetLogoutTimer() {
    startLogoutTimer();
}

export function logout() {
    localStorage.clear();
    sessionStorage.clear();
    window.location.href = "/nexus-login-page";
}

export function unauthorized(code) {
    if (code === 401) {
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = "/nexus-login-page";
    }
}

export function setToken(token) {
    localStorage.setItem("token", `Bearer ${token}`);
}

export function getToken() {
    return localStorage.getItem("token");
}

export function HeaderToken() {
    let token = getToken();
    startLogoutTimer();
    return {
        headers: {
            Authorization: token
        }
    };
}

export function HeaderTokenWithBlob() {
    let token = getToken();
    startLogoutTimer();
    return {
        responseType: 'blob',
        headers: {
            Authorization: token
        }
    };
}

// Global Activity Listeners for Session Timeout Reset
if (typeof window !== 'undefined') {
    window.addEventListener("mousemove", resetLogoutTimer);
    window.addEventListener("keypress", resetLogoutTimer);
}
