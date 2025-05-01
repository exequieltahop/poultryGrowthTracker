// Cookie utilities
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const cname = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(cname) === 0) {
            return c.substring(cname.length, c.length);
        }
    }
    return "";
}

function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

// Check if app is installed
function isAppInstalled() {
    return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
}

let deferredPrompt;

// Detect prompt
window.addEventListener('beforeinstallprompt', (e) => {
    // e.preventDefault();
    deferredPrompt = e;

    // Don't prompt if app is installed, or user clicked maybe later recently
    if (!getCookie('pwa_installed') && !getCookie('pwa_maybe_later')) {
        const btn = document.getElementById('installPwaBtn');
        btn.style.display = 'block'; // Make sure the button is visible

        btn.addEventListener('click', click_btn); // Bind the click_btn function to the install button
    }
});

// Reset flag if app is uninstalled
document.addEventListener('DOMContentLoaded', () => {
    if (!isAppInstalled()) {
        deleteCookie('pwa_installed');
    }
});

// Button click handler for installing the app
function click_btn() {
    if (deferredPrompt) {
        // Show the install prompt
        deferredPrompt.prompt();

        // Handle the user's response to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('✅ App installed');
                setCookie('pwa_installed', true, 365);
            } else {
                console.log('❌ App install dismissed');
            }
            deferredPrompt = null;
        });
    }
}
