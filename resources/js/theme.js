// Theme & Fullscreen Utilities

export function toggle_light_mode() {
    const app = document.body;
    if (localStorage.lightMode === "dark") {
        localStorage.lightMode = "light";
        app.setAttribute("light-mode", "light");
    } else {
        localStorage.lightMode = "dark";
        app.setAttribute("light-mode", "dark");
    }
}

export function initFullscreenToggle() {
    if (document.fullscreenEnabled || document.webkitFullscreenEnabled) {
        const toggleBtn = document.querySelector(".js-toggle-fullscreen-btn");
        if (!toggleBtn) return;

        toggleBtn.hidden = false;
        toggleBtn.addEventListener("click", function () {
            if (document.fullscreenElement || document.webkitFullscreenElement) {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            } else {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen();
                }
            }
        });

        const handleFullscreen = () => {
            if (document.fullscreenElement || document.webkitFullscreenElement) {
                toggleBtn.classList.add("on");
                toggleBtn.setAttribute("aria-label", "Exit fullscreen mode");
            } else {
                toggleBtn.classList.remove("on");
                toggleBtn.setAttribute("aria-label", "Enter fullscreen mode");
            }
        };

        document.addEventListener("fullscreenchange", handleFullscreen);
        document.addEventListener("webkitfullscreenchange", handleFullscreen);
    }
}

// Global Storage Listener for Theme Mode Sync across Tabs
if (typeof window !== 'undefined') {
    window.addEventListener("storage", function () {
        if (localStorage.lightMode === "dark") {
            document.body.setAttribute("light-mode", "dark");
        } else {
            document.body.setAttribute("light-mode", "light");
        }
    }, false);
}
