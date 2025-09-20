document.addEventListener('DOMContentLoaded', function () {
  const aside = document.getElementById('comp-sidebar');
  const toggle = document.getElementById('sidebar-toggle');
  const closeBtn = document.getElementById('sidebar-close');
  const backdrop = document.getElementById('sidebar-backdrop');

  if (!aside || !toggle || !backdrop) return;

  const OPEN_CLASS = 'is-open';
  const VISIBLE_CLASS = 'is-visible';
  const TOGGLE_ACTIVE = 'active';
  const TOGGLE_HIDDEN = 'hidden';

  function openSidebar() {
    aside.classList.add(OPEN_CLASS);
    backdrop.classList.add(VISIBLE_CLASS);
    toggle.classList.add(TOGGLE_ACTIVE, TOGGLE_HIDDEN); // add hidden
    aside.setAttribute('aria-hidden', 'false');
    backdrop.setAttribute('aria-hidden', 'false');
    toggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    const first = aside.querySelector('.sidebar__nav a, .sidebar__close');
    if (first) first.focus();
  }

  function closeSidebar() {
    aside.classList.remove(OPEN_CLASS);
    backdrop.classList.remove(VISIBLE_CLASS);
    toggle.classList.remove(TOGGLE_ACTIVE, TOGGLE_HIDDEN); // remove hidden
    aside.setAttribute('aria-hidden', 'true');
    backdrop.setAttribute('aria-hidden', 'true');
    toggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    toggle.focus();
  }

  toggle.addEventListener('click', function (e) {
    e.preventDefault();
    if (aside.classList.contains(OPEN_CLASS)) {
      closeSidebar();
    } else {
      openSidebar();
    }
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function (e) {
      e.preventDefault();
      closeSidebar();
    });
  }

  backdrop.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && aside.classList.contains(OPEN_CLASS)) {
      closeSidebar();
    }
  });
});
