// assets/js/home.js
// Behaviors for #home-page: thumb swap, wishlist toggle, testimonial keyboard accessibility, mobile parallax fallback.

document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('home-page');
    if (!root) return;

    // 1) Thumbnail click -> swap main image
    root.querySelectorAll('.product-card').forEach(function (card) {
        const main = card.querySelector('.product-card__main');
        const thumbs = card.querySelectorAll('.product-card__thumb');
        thumbs.forEach(function (t) {
            t.addEventListener('click', function () {
                const full = t.dataset.full || t.src;
                if (main && full) main.src = full;
                thumbs.forEach(x => x.classList.remove('is-active'));
                t.classList.add('is-active');
            });
        });
    });

    // 2) Wishlist heart toggle
    root.querySelectorAll('.product-card__fav').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.classList.toggle('fav-active');
            const pressed = btn.getAttribute('aria-pressed') === 'true';
            btn.setAttribute('aria-pressed', String(!pressed));
            // TODO: send AJAX request to persist wishlist (if backend endpoint available)
        });
    });

    // 3) Accessibility: make testimonial cards focusable
    root.querySelectorAll('.testi-card').forEach((card) => {
        card.setAttribute('tabindex', '0');
    });

    // 4) Mobile parallax fallback: disable background-attachment for performance
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        document.querySelectorAll('.home-offer__bg').forEach(el => {
            el.style.backgroundAttachment = 'scroll';
        });
    }

    // 5) Optional: implement keyboard accessible thumbnail navigation (left/right arrows)
    root.querySelectorAll('.product-card').forEach(card => {
        const thumbs = Array.from(card.querySelectorAll('.product-card__thumb'));
        if (!thumbs.length) return;
        thumbs.forEach((thumb, idx) => {
            thumb.setAttribute('tabindex', '0');
            thumb.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    thumb.click();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    const next = thumbs[(idx + 1) % thumbs.length];
                    next.focus();
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const prev = thumbs[(idx - 1 + thumbs.length) % thumbs.length];
                    prev.focus();
                }
            });
        });
    });
});
