/**
 * navbar.js
 * - Portal dropdowns (moved to body) with hover + click + keyboard support
 * - Marks portals with class from data-dropdown-name (e.g., "profile", "notifications")
 * - Search toggle: click to open/focus, click-outside/Escape to close
 */

document.addEventListener('DOMContentLoaded', function () {
    const DROPDOWN_OPEN_DELAY = 60;   // ms
    const DROPDOWN_CLOSE_DELAY = 180; // ms

    const dropdowns = Array.from(document.querySelectorAll('#main-navbar .dropdown'));

    // Keep references of portal data
    const store = [];

    // ========== MOVE DROPDOWN MENUS TO BODY (PORTAL) ==========
    dropdowns.forEach((drop, idx) => {
        const toggle = drop.querySelector('[data-dropdown-toggle]');
        const origMenu = drop.querySelector('.dropdown-menu');

        if (!toggle || !origMenu) return;

        // create portal wrapper and move menu content inside
        const portal = document.createElement('div');
        portal.className = 'portal-dropdown';
        while (origMenu.firstChild) portal.appendChild(origMenu.firstChild);
        origMenu.remove();

        portal.style.top = '0px';
        portal.style.left = '-9999px';
        portal.setAttribute('data-from-dropdown', idx);
        portal.setAttribute('role', 'menu');

        // If dropdown has a name (data-dropdown-name), add it as a class on the portal for styling hooks
        const ddName = (drop.getAttribute('data-dropdown-name') || '').trim();
        if (ddName) {
            // sanitize (allow only letters, digits, hyphen, underscore)
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
    });

    // ========== POSITIONING ==========
    function positionPortal(toggleEl, portalEl) {
        const rect = toggleEl.getBoundingClientRect();

        // hide to measure
        portalEl.style.visibility = 'hidden';
        portalEl.classList.remove('open');
        portalEl.style.left = '-9999px';
        portalEl.style.top = '-9999px';

        // force reflow for accurate sizes
        // eslint-disable-next-line no-unused-expressions
        portalEl.offsetWidth;

        const pw = portalEl.offsetWidth;
        const ph = portalEl.offsetHeight;

        const spaceRight = window.innerWidth - rect.right;
        const spaceLeft = rect.left;

        let left = rect.right - pw; // align right edges by default
        if (left < 8 && spaceRight < pw && spaceLeft > spaceRight) {
            left = rect.left; // align left edge if not enough space on right
        }
        left = Math.max(8, Math.min(left, window.innerWidth - pw - 8));

        let top = rect.bottom + 8; // below toggle
        if (top + ph > window.innerHeight - 8) {
            top = rect.top - ph - 8; // place above if not enough space
        }

        portalEl.style.left = `${Math.round(left)}px`;
        portalEl.style.top = `${Math.round(top)}px`;
        portalEl.style.visibility = 'visible';

        // arrow position: center of toggle relative to portal left
        const arrowCenter = Math.max(16, Math.min(rect.left + rect.width / 2 - left, pw - 16));
        portalEl.style.setProperty('--portal-arrow-left', `${arrowCenter}px`);
    }

    // ========== OPEN / CLOSE HELPERS ==========
    function openPortal(item) {
        clearTimeout(item.closeTimer);
        if (item.isOpen) return;
        item.openTimer = setTimeout(() => {
            positionPortal(item.toggle, item.portal);
            item.portal.classList.add('open');
            item.drop.classList.add('is-open');
            item.toggle.setAttribute('aria-expanded', 'true');
            item.isOpen = true;
            // When a dropdown opens, close the search if open
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

    // ========== ATTACH EVENTS TO DROPDOWNS ==========
    store.forEach(item => {
        // Hover handlers on toggle
        item.toggle.addEventListener('mouseenter', () => openPortal(item));
        item.toggle.addEventListener('mouseleave', () => {
            item.closeTimer = setTimeout(() => {
                if (!item.portal.matches(':hover') && !item.toggle.matches(':hover')) closePortal(item);
            }, DROPDOWN_CLOSE_DELAY);
        });

        // Click toggle for mobile/touch
        item.toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (item.isOpen) {
                closePortal(item);
            } else {
                store.forEach(s => { if (s !== item) closePortal(s); });
                openPortal(item);
            }
        });

        // Keyboard support
        item.toggle.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openPortal(item);
                const ff = item.portal.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                if (ff) ff.focus();
            } else if (e.key === 'Escape') {
                closePortal(item);
                item.toggle.focus();
            }
        });

        // Keep open when hovering portal
        item.portal.addEventListener('mouseenter', () => {
            clearTimeout(item.closeTimer);
        });
        item.portal.addEventListener('mouseleave', () => {
            item.closeTimer = setTimeout(() => {
                if (!item.toggle.matches(':hover') && !item.portal.matches(':hover')) closePortal(item);
            }, DROPDOWN_CLOSE_DELAY);
        });

        // prevent clicks inside portal from bubbling to document
        item.portal.addEventListener('click', (e) => e.stopPropagation());
    });

    // ========== GLOBAL DROPDOWN HANDLERS ==========
    // Click outside closes all
    document.addEventListener('click', function (e) {
        const target = e.target;
        const insideAny = store.some(s => s.toggle.contains(target) || s.portal.contains(target));
        if (!insideAny) store.forEach(s => closePortal(s));
    });

    // ESC closes
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

    // ========== SEARCH TOGGLE LOGIC ==========
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
        // click toggles search open/close
        searchIcon.addEventListener('click', function (e) {
            e.stopPropagation();
            const wasActive = searchContainer.classList.toggle('is-active');
            if (wasActive && searchInput) {
                searchInput.focus();
                // also close any open dropdowns
                store.forEach(s => closePortal(s));
            } else if (searchInput) {
                searchInput.value = '';
                searchInput.blur();
            }
        });

        // clicking inside the input shouldn't close it
        if (searchInput) {
            searchInput.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            // pressing Escape inside search closes it
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    maybeCloseSearch();
                }
            });
        }
    }

    // clicking anywhere else closes search as well (and dropdowns handled above)
    document.addEventListener('click', function (e) {
        // click outside search container?
        if (searchContainer && !searchContainer.contains(e.target)) {
            maybeCloseSearch();
        }
    });

    // ensure search closes on resize (avoid stuck state)
    window.addEventListener('resize', function () {
        maybeCloseSearch();
        // also reposition portals
        store.forEach(s => { if (s.isOpen) positionPortal(s.toggle, s.portal); });
    });

    // done
});
