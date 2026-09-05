import './bootstrap';

import {
    showLoader,
    hideLoader,
    successToast,
    errorToast,
    startLogoutTimer,
    resetLogoutTimer,
    logout,
    unauthorized,
    setToken,
    getToken,
    HeaderToken,
    HeaderTokenWithBlob
} from './config.js';

import {
    toggle_light_mode,
    initFullscreenToggle
} from './theme.js';

import {
    bindSimpleModal,
    initGlobalModals
} from './modals.js';

import {
    printBarCard,
    initTableUtils
} from './table-utils.js';

// Expose functions to window for global inline Blade & JS compatibility
if (typeof window !== 'undefined') {
    window.showLoader = showLoader;
    window.hideLoader = hideLoader;
    window.successToast = successToast;
    window.errorToast = errorToast;
    window.startLogoutTimer = startLogoutTimer;
    window.resetLogoutTimer = resetLogoutTimer;
    window.logout = logout;
    window.unauthorized = unauthorized;
    window.setToken = setToken;
    window.getToken = getToken;
    window.HeaderToken = HeaderToken;
    window.HeaderTokenWithBlob = HeaderTokenWithBlob;

    window.toggle_light_mode = toggle_light_mode;
    window.bindSimpleModal = bindSimpleModal;
    window.printBarCard = printBarCard;

    document.addEventListener("DOMContentLoaded", () => {
        initFullscreenToggle();
        initGlobalModals();
        initTableUtils();
    });
}
