// assets/js/sidebar.js
// Individual script — no core.js dependency.
// Loaded with: <script src="/assets/js/sidebar.js" defer></script>

document.addEventListener('DOMContentLoaded', function () {
    const aside = document.getElementById('comp-sidebar');          // <aside id="comp-sidebar">
    const toggle = document.getElementById('sidebar-toggle');       // menu button
    const closeBtn = document.getElementById('sidebar-close');     // close button inside sidebar
    const backdrop = document.getElementById('sidebar-backdrop');  // backdrop element

    if (!aside || !toggle || !closeBtn || !backdrop) {
        // Required elements not found — safely abort initialization.
        return;
    }

    const OPEN_CLASS = 'is-open';
    const VISIBLE_CLASS = 'is-visible';
    const TOGGLE_ACTIVE = 'active';
    const TOGGLE_HIDDEN = 'hidden';

    function openSidebar() {
        aside.classList.add(OPEN_CLASS);
        backdrop.classList.add(VISIBLE_CLASS);
        toggle.classList.add(TOGGLE_ACTIVE, TOGGLE_HIDDEN); // color change + hide toggle
        aside.setAttribute('aria-hidden', 'false');
        backdrop.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        const first = aside.querySelector('.sidebar__nav a');
        if (first) first.focus();
    }

    function closeSidebar() {
        aside.classList.remove(OPEN_CLASS);
        backdrop.classList.remove(VISIBLE_CLASS);
        toggle.classList.remove(TOGGLE_ACTIVE, TOGGLE_HIDDEN); // restore toggle
        aside.setAttribute('aria-hidden', 'true');
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        toggle.focus();
    }

    // Toggle handler
    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        if (aside.classList.contains(OPEN_CLASS)) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Close button inside sidebar
    closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        closeSidebar();
    });

    // Click backdrop to close
    backdrop.addEventListener('click', function () {
        closeSidebar();
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && aside.classList.contains(OPEN_CLASS)) {
            closeSidebar();
        }
    });

    // Basic focus trap: keep focus inside sidebar when open
    document.addEventListener('focusin', function (e) {
        if (!aside.classList.contains(OPEN_CLASS)) return;
        if (!aside.contains(e.target) && e.target !== toggle) {
            const first = aside.querySelector('.sidebar__close') || aside.querySelector('.sidebar__nav a');
            if (first) first.focus();
        }
    });

    // Keyboard interaction: toggle with Enter/Space
    toggle.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggle.click();
        }
    });
    closeBtn.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            closeBtn.click();
        }
    });
});
