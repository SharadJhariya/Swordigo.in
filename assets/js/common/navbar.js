// assets/js/common/navbar.js
// Robust navbar script: portals (dropdowns), search toggle, cart sidebar (desktop-only)
// Drop-in replacement — defensive and logs helpful warnings.

(function () {
    'use strict';

    // Small helpers
    const log = (...args) => console.debug('[navbar]', ...args);
    const warn = (...args) => console.warn('[navbar]', ...args);
    const isTouchDevice = () => ('ontouchstart' in window) || navigator.maxTouchPoints > 0;

    document.addEventListener('DOMContentLoaded', function () {
        try {
            // Config
            const DROPDOWN_OPEN_DELAY = 60;
            const DROPDOWN_CLOSE_DELAY = 180;
            const CART_BREAKPOINT_PX = 992; // desktop threshold

            // Find dropdowns inside navbar
            const dropdownEls = Array.from(document.querySelectorAll('#main-navbar .dropdown'));
            if (!dropdownEls.length) log('No dropdowns found (profile/notifications)');

            // store per-dropdown state
            const store = [];

            // Move each dropdown's .dropdown-menu to a portal on body
            dropdownEls.forEach((drop, idx) => {
                try {
                    const toggle = drop.querySelector('[data-dropdown-toggle]');
                    const origMenu = drop.querySelector('.dropdown-menu');

                    if (!toggle) {
                        warn('Dropdown toggle missing for dropdown index', idx, drop);
                        return;
                    }
                    if (!origMenu) {
                        warn('Dropdown menu element missing for toggle', toggle);
                        return;
                    }

                    // Create portal element
                    const portal = document.createElement('div');
                    portal.className = 'portal-dropdown';
                    portal.setAttribute('role', 'menu');
                    portal.setAttribute('data-from-dropdown', String(idx));

                    // Move content: prefer to move nodes, but fallback to innerHTML copy if moving fails.
                    try {
                        while (origMenu.firstChild) portal.appendChild(origMenu.firstChild);
                        origMenu.remove();
                    } catch (errMove) {
                        // fallback to innerHTML copy
                        portal.innerHTML = origMenu.innerHTML || '';
                        try { origMenu.remove(); } catch (_) { }
                    }

                    // Add optional name-based class
                    const ddName = (drop.getAttribute('data-dropdown-name') || '').trim();
                    if (ddName) {
                        const safe = ddName.toLowerCase().replace(/[^a-z0-9-_]/g, '');
                        if (safe) portal.classList.add(safe);
                    }

                    document.body.appendChild(portal);
                    const portalId = 'portal_dropdown_' + idx;
                    portal.id = portalId;
                    toggle.setAttribute('aria-controls', portalId);

                    store.push({
                        drop,
                        toggle,
                        portal,
                        openTimer: null,
                        closeTimer: null,
                        isOpen: false
                    });
                } catch (err) {
                    warn('Failed processing dropdown index', idx, err);
                }
            });

            // Positioning helper
            function positionPortal(toggleEl, portalEl) {
                if (!toggleEl || !portalEl) return;
                const rect = toggleEl.getBoundingClientRect();

                // temporarily hide for measurement
                portalEl.style.visibility = 'hidden';
                portalEl.classList.remove('open');
                portalEl.style.left = '-9999px';
                portalEl.style.top = '-9999px';

                // force reflow
                // eslint-disable-next-line no-unused-expressions
                portalEl.offsetWidth;

                const pw = portalEl.offsetWidth || 220;
                const ph = portalEl.offsetHeight || 120;

                // compute left
                const spaceRight = window.innerWidth - rect.right;
                const spaceLeft = rect.left;
                let left = rect.right - pw; // align right by default

                if (left < 8 && spaceRight < pw && spaceLeft > spaceRight) {
                    left = rect.left;
                }
                left = Math.max(8, Math.min(left, window.innerWidth - pw - 8));

                // compute top below toggle, but place above if not enough space
                let top = rect.bottom + 8;
                if (top + ph > window.innerHeight - 8) {
                    top = rect.top - ph - 8;
                }

                portalEl.style.left = `${Math.round(left)}px`;
                portalEl.style.top = `${Math.round(top)}px`;
                portalEl.style.visibility = 'visible';

                // arrow center
                const arrowCenter = Math.max(16, Math.min(rect.left + rect.width / 2 - left, pw - 16));
                portalEl.style.setProperty('--portal-arrow-left', `${arrowCenter}px`);
            }

            // Open/close helpers
            function openPortal(item) {
                clearTimeout(item.closeTimer);
                if (item.isOpen) return;
                item.openTimer = setTimeout(() => {
                    positionPortal(item.toggle, item.portal);
                    item.portal.classList.add('open');
                    item.drop.classList.add('is-open');
                    item.toggle.setAttribute('aria-expanded', 'true');
                    item.isOpen = true;
                    // close search if open (search logic defined below)
                    maybeCloseSearch();
                }, DROPDOWN_OPEN_DELAY);
            }

            function closePortal(item) {
                clearTimeout(item.openTimer);
                if (!item.isOpen) return;
                item.closeTimer = setTimeout(() => {
                    item.portal.classList.remove('open');
                    item.drop.classList.remove('is-open');
                    item.toggle.setAttribute('aria-expanded', 'false');
                    item.isOpen = false;
                }, DROPDOWN_CLOSE_DELAY);
            }

            // Attach events per dropdown
            store.forEach(item => {
                const { toggle, portal } = item;

                // Hover on non-touch devices
                if (!isTouchDevice()) {
                    toggle.addEventListener('mouseenter', () => openPortal(item));
                    toggle.addEventListener('mouseleave', () => {
                        item.closeTimer = setTimeout(() => {
                            if (!portal.matches(':hover') && !toggle.matches(':hover')) closePortal(item);
                        }, DROPDOWN_CLOSE_DELAY);
                    });

                    portal.addEventListener('mouseenter', () => {
                        clearTimeout(item.closeTimer);
                    });
                    portal.addEventListener('mouseleave', () => {
                        item.closeTimer = setTimeout(() => {
                            if (!toggle.matches(':hover') && !portal.matches(':hover')) closePortal(item);
                        }, DROPDOWN_CLOSE_DELAY);
                    });
                }

                // Click toggles (works for touch & mouse)
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (item.isOpen) {
                        closePortal(item);
                    } else {
                        // close others
                        store.forEach(s => { if (s !== item) closePortal(s); });
                        openPortal(item);
                    }
                });

                // Keyboard support
                toggle.addEventListener('keydown', (e) => {
                    const key = e.key;
                    if (key === 'ArrowDown' || key === 'Enter' || key === ' ') {
                        e.preventDefault();
                        openPortal(item);
                        const first = item.portal.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                        if (first) first.focus();
                    } else if (key === 'Escape') {
                        closePortal(item);
                        toggle.focus();
                    }
                });

                // Prevent clicks from bubbling out of portal
                portal.addEventListener('click', (ev) => ev.stopPropagation());
            });

            // Global handlers: click outside closes all portals
            document.addEventListener('click', function (e) {
                const target = e.target;
                const insideAny = store.some(s => s.toggle.contains(target) || s.portal.contains(target));
                if (!insideAny) store.forEach(s => closePortal(s));
            });

            // ESC closes all
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') store.forEach(s => closePortal(s));
            });

            // reposition on resize/scroll
            window.addEventListener('resize', () => {
                store.forEach(s => { if (s.isOpen) positionPortal(s.toggle, s.portal); });
            });
            window.addEventListener('scroll', () => {
                store.forEach(s => { if (s.isOpen) positionPortal(s.toggle, s.portal); });
            }, true);

            // ========== SEARCH TOGGLE ==========
            const searchContainer = document.querySelector('.search-container');
            const searchIcon = document.querySelector('.search-icon');
            const searchInput = document.querySelector('.search-input');

            function maybeCloseSearch() {
                if (searchContainer && searchContainer.classList.contains('is-active')) {
                    searchContainer.classList.remove('is-active');
                    if (searchInput) {
                        searchInput.value = '';
                        searchInput.blur();
                    }
                }
            }

            if (searchIcon && searchContainer) {
                searchIcon.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isActive = searchContainer.classList.toggle('is-active');
                    if (isActive && searchInput) {
                        searchInput.focus();
                        store.forEach(s => closePortal(s));
                    } else if (searchInput) {
                        searchInput.value = '';
                        searchInput.blur();
                    }
                });

                if (searchInput) {
                    searchInput.addEventListener('click', (e) => e.stopPropagation());
                    searchInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') maybeCloseSearch();
                    });
                }
            }

            // close search when clicking outside
            document.addEventListener('click', function (e) {
                if (searchContainer && !searchContainer.contains(e.target)) {
                    maybeCloseSearch();
                }
            });

            // close search on resize to avoid stuck state
            window.addEventListener('resize', function () {
                maybeCloseSearch();
                store.forEach(s => { if (s.isOpen) positionPortal(s.toggle, s.portal); });
            });

            // ========== CART SIDEBAR (desktop only) ==========
            (function initCartSidebar() {
                try {
                    const cartTrigger = document.querySelector('.cart-container .cart-icon, .cart-container a');
                    const cartSidebar = document.getElementById('cart-sidebar');
                    const cartClose = document.getElementById('cart-close');
                    const cartBackdrop = document.getElementById('cart-backdrop');

                    if (!cartTrigger) {
                        log('Cart trigger not found — cart icon may be missing.');
                        return;
                    }
                    if (!cartSidebar || !cartBackdrop) {
                        log('Cart sidebar or backdrop not present in DOM — skipping cart sidebar init.');
                        return;
                    }

                    const OPEN_CLASS = 'is-open';
                    const VISIBLE_CLASS = 'is-visible';

                    function isLarge() {
                        return window.matchMedia && window.matchMedia(`(min-width: ${CART_BREAKPOINT_PX}px)`).matches;
                    }

                    function openCart() {
                        if (!isLarge()) return; // allow link navigation on small screens
                        cartSidebar.classList.add(OPEN_CLASS);
                        cartBackdrop.classList.add(VISIBLE_CLASS);
                        cartSidebar.setAttribute('aria-hidden', 'false');
                        cartBackdrop.setAttribute('aria-hidden', 'false');
                        document.body.style.overflow = 'hidden';
                        const focusable = cartSidebar.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                        if (focusable) focusable.focus();
                    }

                    function closeCart() {
                        cartSidebar.classList.remove(OPEN_CLASS);
                        cartBackdrop.classList.remove(VISIBLE_CLASS);
                        cartSidebar.setAttribute('aria-hidden', 'true');
                        cartBackdrop.setAttribute('aria-hidden', 'true');
                        document.body.style.overflow = '';
                        if (cartTrigger && typeof cartTrigger.focus === 'function') cartTrigger.focus();
                    }

                    cartTrigger.addEventListener('click', function (e) {
                        if (!isLarge()) {
                            // do not intercept on small screens
                            return;
                        }
                        e.preventDefault();
                        if (cartSidebar.classList.contains(OPEN_CLASS)) closeCart(); else openCart();
                    });

                    if (cartClose) cartClose.addEventListener('click', (e) => { e.preventDefault(); closeCart(); });
                    cartBackdrop.addEventListener('click', closeCart);

                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && cartSidebar.classList.contains(OPEN_CLASS)) closeCart();
                    });

                    document.addEventListener('focusin', (e) => {
                        if (!cartSidebar.classList.contains(OPEN_CLASS)) return;
                        if (!cartSidebar.contains(e.target) && e.target !== cartTrigger) {
                            const first = cartSidebar.querySelector('a, button');
                            if (first) first.focus();
                        }
                    });

                    window.addEventListener('resize', () => {
                        if (!isLarge() && cartSidebar.classList.contains(OPEN_CLASS)) closeCart();
                    });
                } catch (err) {
                    warn('Cart sidebar initialization failed', err);
                }
            })();

            log('Navbar script initialized successfully.');
        } catch (errTop) {
            console.error('[navbar] initialization failed:', errTop);
        }
    });
})();
