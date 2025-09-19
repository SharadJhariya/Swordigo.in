<?php
// includes/common/footer.php
// Immediate footer fix: inline critical CSS + structured markup.
// Replace the file contents with this to see instant changes.

?>
<footer class="site-footer" role="contentinfo" aria-label="Footer">
  <style>
    /* Inline critical footer styles (override cache) */
    .site-footer{background:#262626;color:#fff;padding:28px 12px 34px;margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;}
    .site-footer__inner{max-width:1100px;margin:0 auto;display:flex;flex-direction:column;align-items:center;gap:14px;text-align:center;padding:0 12px;}
    .site-footer__brand{display:flex;flex-direction:column;align-items:center;gap:8px;width:100%;}
    .site-footer__logo{width:150px;max-width:60%;height:auto;display:block;margin:0 auto;}
    .site-footer__blurb{max-width:700px;color:rgba(255,255,255,0.85);font-size:0.95rem;line-height:1.45;margin:0 6px;}
    .site-footer__socials{display:flex;gap:18px;margin-top:6px;margin-bottom:6px;}
    .site-footer__socials .social{width:40px;height:40px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.04);color:#fff;text-decoration:none;transition:all .16s ease;}
    .site-footer__socials .social i{font-size:16px;line-height:1;}
    .site-footer__socials .social:hover{transform:translateY(-3px);background:rgba(255,255,255,0.12);}
    .site-footer__divider{width:60%;max-width:600px;height:1px;background:rgba(255,255,255,0.04);margin:12px auto;}
    .site-footer__links{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;margin:6px 0;}
    .site-footer__links a{color:rgba(255,255,255,0.88);text-decoration:none;font-size:0.95rem;padding:4px;}
    .site-footer__bottom{color:rgba(255,255,255,0.65);font-size:0.85rem;margin-top:6px;}
    @media(min-width:768px){
      .site-footer__logo{width:190px;}
      .site-footer__divider{width:45%;}
      .site-footer__inner{gap:18px;}
    }
  </style>

  <div class="site-footer__inner">

    <div class="site-footer__brand">
      <img class="site-footer__logo" src="assets/images/logos/logo-white.svg" alt="Swordigo Logo">
      <p class="site-footer__blurb">Swordigo crafts premium hand-finished katanas — designed for collectors and enthusiasts. Quality materials, authentic feel.</p>
    </div>

    <div class="site-footer__socials" aria-label="Social links">
      <a href="https://facebook.com" class="social" target="_blank" rel="noopener" aria-label="Facebook">
        <i class="fab fa-facebook-f" aria-hidden="true"></i>
      </a>
      <a href="https://instagram.com" class="social" target="_blank" rel="noopener" aria-label="Instagram">
        <i class="fab fa-instagram" aria-hidden="true"></i>
      </a>
      <a href="https://facebook.com" class="social" target="_blank" rel="noopener" aria-label="Facebook">
        <i class="fab fa-facebook-f" aria-hidden="true"></i>
      </a>
      <a href="https://instagram.com" class="social" target="_blank" rel="noopener" aria-label="Instagram">
        <i class="fab fa-instagram" aria-hidden="true"></i>
      </a>
    </div>

    <div class="site-footer__divider" role="separator" aria-hidden="true"></div>

    <nav class="site-footer__links" aria-label="Footer navigation">
      <a href="?page=about">About Us</a>
      <a href="?page=contact">Contact</a>
      <a href="?page=faq">FAQ</a>
      <a href="?page=blog">Blog</a>
    </nav>

    <div class="site-footer__bottom">
      <small>&copy; <?= date('Y') ?> Swordigo.IN — All Rights Reserved</small>
    </div>
  </div>
</footer>

<!-- you can keep app.bundle.js here or move to head/footer as before -->
<!-- <script src="/assets/js/app.bundle.js" defer></script> -->
</body>
</html>
