function showLoader() {
    document.getElementById('loader').classList.remove('d-none')
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none')
}

function successToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
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
}

function errorToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
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
}

let logoutTimer; // Variable to store the logout timer

function startLogoutTimer() {
    // Clear existing timer, if any
    if (logoutTimer) {
        clearTimeout(logoutTimer);
    }
    // Start a new timer for 24 hours (86,400,000 milliseconds)
    logoutTimer = setTimeout(logout, 43200000); // 6 hours in milliseconds
}

function resetLogoutTimer() {
    // Restart the logout timer
    startLogoutTimer();
}


function logout() {
    localStorage.clear();
    sessionStorage.clear();
    window.location.href = "/nexus-login-page";
}

function unauthorized(code){
    if(code===401){
        localStorage.clear();
        sessionStorage.clear();

        window.location.href="/nexus-login-page"
    }
}

function setToken(token){
    localStorage.setItem("token",`Bearer ${token}`)
}

function getToken(){
    return  localStorage.getItem("token")
}

function HeaderToken() {
    let token = getToken();
    // Start or reset the logout timer whenever the token is used
    startLogoutTimer();
    return {
        headers: {
            Authorization: token
        }
    }
}
function HeaderTokenWithBlob() {
    let token = getToken();
    // Start or reset the logout timer whenever the token is used
    startLogoutTimer();
    return {
        responseType: 'blob',
        headers: {
            Authorization: token
        }
    }
}

document.addEventListener("mousemove", resetLogoutTimer);
document.addEventListener("keypress", resetLogoutTimer);
