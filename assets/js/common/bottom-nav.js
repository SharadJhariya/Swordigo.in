// bottom navbar behaviour - append to sidebar.js (after DOMContentLoaded init)
(function () {
    // helper to wait until DOMContentLoaded part of original script ran
    const initBottomNavbar = () => {
        const bnToggle = document.getElementById('bn-toggle');
        const bnSearch = document.getElementById('bn-search');
        const mobileSearch = document.getElementById('mobile-search');
        const mobileSearchClose = document.getElementById('mobile-search-close');

        // open sidebar as bottom drawer on small screens: reuse existing logic if available
        function openAsBottomDrawer() {
            const aside = document.getElementById('comp-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggle = document.getElementById('sidebar-toggle');

            if (!aside || !backdrop) return;

            // add classes - your CSS already handles mobile bottom drawer when #comp-sidebar.is-open
            aside.classList.add('is-open');
            backdrop.classList.add('is-visible');

            // hide toggle (desktop toggle) visually to avoid overlap (if present)
            if (toggle) toggle.classList.add('hidden', 'active');

            aside.setAttribute('aria-hidden', 'false');
            backdrop.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            // focus the first nav item
            const first = aside.querySelector('.sidebar__nav a');
            if (first) first.focus();
        }

        function closeBottomDrawer() {
            const aside = document.getElementById('comp-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggle = document.getElementById('sidebar-toggle');

            if (!aside || !backdrop) return;

            aside.classList.remove('is-open');
            backdrop.classList.remove('is-visible');

            if (toggle) toggle.classList.remove('hidden', 'active');

            aside.setAttribute('aria-hidden', 'true');
            backdrop.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if (toggle) toggle.focus();
        }

        if (bnToggle) {
            bnToggle.addEventListener('click', function (e) {
                e.preventDefault();
                const aside = document.getElementById('comp-sidebar');
                if (!aside) return;
                if (aside.classList.contains('is-open')) closeBottomDrawer();
                else openAsBottomDrawer();
            });
        }

        // Mobile search open/close
        if (bnSearch && mobileSearch) {
            bnSearch.addEventListener('click', function (e) {
                e.preventDefault();
                mobileSearch.classList.add('is-open');
                mobileSearch.setAttribute('aria-hidden', 'false');
                const input = mobileSearch.querySelector('input[type="search"]');
                if (input) {
                    input.focus();
                }
            });

            if (mobileSearchClose) {
                mobileSearchClose.addEventListener('click', function (e) {
                    e.preventDefault();
                    mobileSearch.classList.remove('is-open');
                    mobileSearch.setAttribute('aria-hidden', 'true');
                });
            }

            // close search on Esc
            document.addEventListener('keydown', function (ev) {
                if (ev.key === 'Escape' && mobileSearch.classList.contains('is-open')) {
                    mobileSearch.classList.remove('is-open');
                    mobileSearch.setAttribute('aria-hidden', 'true');
                }
            });

            // clicking outside the panel closes modal
            mobileSearch.addEventListener('click', function (ev) {
                if (ev.target === mobileSearch) {
                    mobileSearch.classList.remove('is-open');
                    mobileSearch.setAttribute('aria-hidden', 'true');
                }
            });
        }
    };

    // Run after DOM loads (if DOMContentLoaded already happened, run immediately)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBottomNavbar);
    } else {
        initBottomNavbar();
    }
})();
