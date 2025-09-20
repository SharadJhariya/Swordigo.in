<?php
// pages/home.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = 'Home - Swordigo.IN';
?>
<link rel="stylesheet" href="/assets/css/home.css">
<script src="/assets/js/home.js" defer></script>

<div id="home-page" role="main" aria-labelledby="home-hero-heading">

    <!-- HERO -->
    <section class="home-hero" id="home-hero">
        <video class="home-hero__video" autoplay muted loop playsinline aria-hidden="true">
            <source src="/assets/videos/hero.mp4" type="video/mp4">
        </video>
        <div class="home-hero__overlay">
            <h1 id="home-hero-heading" class="home-hero__title">
                Welcome to Swordigo.IN ⚔️
            </h1>
            <p class="home-hero__subtitle">Premium Katanas, Samurai Blades & Collectibles</p>
        </div>
    </section>

    <div class="home-container">
        <!-- Products (same as before; omitted here for brevity in explanation) -->
        <section class="home-products" aria-label="Featured products">
            <header class="home-products__header">
                <h2>Featured Collections</h2>
            </header>

            <div class="home-products__grid" id="home-product-grid">
                <?php
                // demo product array (replace with DB loop in production)
                $products = [
                    ['id' => 1, 'title' => 'Kai Style Katana', 'category' => 'Samurai Blades', 'price' => 139.99, 'old' => 169.99, 'image' => '/assets/images/katana1.png', 'thumbs' => ['/assets/images/katana1.png']],
                    ['id' => 2, 'title' => 'Shinobi Tanto', 'category' => 'Tanto', 'price' => 89.99, 'old' => 119.99, 'image' => '/assets/images/katana2.png', 'thumbs' => ['/assets/images/katana2.png']],
                    ['id' => 3, 'title' => 'Seiryu Wakizashi', 'category' => 'Wakizashi', 'price' => 129.99, 'old' => 149.99, 'image' => '/assets/images/katana3.png', 'thumbs' => ['/assets/images/katana3.png']],
                    ['id' => 4, 'title' => 'Tetsubo Display', 'category' => 'Collectible', 'price' => 199.99, 'old' => 249.99, 'image' => '/assets/images/katana4.png', 'thumbs' => ['/assets/images/katana4.png']],
                    ['id' => 5, 'title' => 'Hikari Modern', 'category' => 'Modern Blades', 'price' => 159.99, 'old' => 189.99, 'image' => '/assets/images/katana5.png', 'thumbs' => ['/assets/images/katana5.png']],
                    ['id' => 6, 'title' => 'Yamato Custom', 'category' => 'Custom', 'price' => 299.99, 'old' => 349.99, 'image' => '/assets/images/katana6.png', 'thumbs' => ['/assets/images/katana6.png']],
                    ['id' => 7, 'title' => 'Kage Throwing', 'category' => 'Throwing', 'price' => 79.99, 'old' => 99.99, 'image' => '/assets/images/katana7.png', 'thumbs' => ['/assets/images/katana7.png']],
                    ['id' => 8, 'title' => 'Shiro Display Box', 'category' => 'Accessories', 'price' => 49.99, 'old' => 69.99, 'image' => '/assets/images/katana8.png', 'thumbs' => ['/assets/images/katana8.png']],
                ];

                foreach ($products as $p): ?>
                    <article class="product-card" data-id="<?= (int)$p['id'] ?>">
                        <button class="product-card__fav" aria-label="Add to wishlist" type="button">
                            <span class="icon-heart" aria-hidden="true">♡</span>
                        </button>

                        <div class="product-card__media">
                            <img class="product-card__main" src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>">
                        </div>

                        <div class="product-card__thumbs">
                            <?php $tidx = 0;
                            foreach ($p['thumbs'] as $t): ?>
                                <img class="product-card__thumb <?= $tidx === 0 ? 'is-active' : '' ?>"
                                    src="<?= htmlspecialchars($t) ?>"
                                    data-full="<?= htmlspecialchars($t) ?>"
                                    alt="thumb">
                            <?php $tidx++;
                            endforeach; ?>
                        </div>

                        <div class="product-card__meta">
                            <span class="product-card__badge"><?= htmlspecialchars($p['category']) ?></span>
                            <h3 class="product-card__title"><?= htmlspecialchars($p['title']) ?></h3>
                            <div class="product-card__price">
                                <strong class="price">₹<?= number_format($p['price'], 2) ?></strong>
                                <span class="price-old">₹<?= number_format($p['old'], 2) ?></span>
                            </div>
                            <div class="product-card__action">
                                <a class="btn btn-add" href="/?page=product&id=<?= (int)$p['id'] ?>">🛒 ADD TO CART</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- OFFER -->
        <section class="home-offer" aria-label="Offer">
            <div class="home-offer__bg" style="background-image:url('/assets/images/offer-bg.jpg');"></div>
            <div class="home-offer__content">
                <h3>Limited Time Offer</h3>
                <p>Free display stand with select premium blades. Limited stock — handcrafted stands included.</p>
            </div>
        </section>

        <!-- TESTIMONIALS (updated layout to match reference) -->
        <section class="home-testimonials" aria-label="Testimonials">
            <div class="home-testimonials__inner">
                <header class="home-testimonials__header">
                    <h2>We care about our customers' experience too</h2>
                </header>

                <div class="home-testimonials__grid" id="home-testimonials-grid">
                    <?php
                    // Demo testimonials - replace with DB-driven content if needed
                    $testimonials = [
                        ['name' => 'Ethan Miller', 'role' => 'Collector', 'avatar' => '/assets/images/testi1.jpg', 'text' => "I've been using Swordigo for a year now — great shipping and fantastic craftsmanship.", 'accent' => '#efe9ff'],
                        ['name' => 'Emily Johnson', 'role' => 'Martial Artist', 'avatar' => '/assets/images/testi2.jpg', 'text' => "Thanks to Swordigo, I feel more confident training with my wakizashi. Quality is top-notch.", 'accent' => '#fff1e6'],
                        ['name' => 'Olivia Carter', 'role' => 'Historian', 'avatar' => '/assets/images/testi3.jpg', 'text' => "The customer service team helped me choose the perfect blade for my collection.", 'accent' => '#e8fbf1'],
                        ['name' => 'Wyatt Turner', 'role' => 'Enthusiast', 'avatar' => '/assets/images/testi4.jpg', 'text' => "Packaging is simply the best — my katana arrived flawless and secure.", 'accent' => '#fff0f6'],
                    ];
                    foreach ($testimonials as $t): ?>
                        <article class="testi-card" style="--accent: <?= htmlspecialchars($t['accent']) ?>;">
                            <div class="testi-card__avatar">
                                <img src="<?= htmlspecialchars($t['avatar']) ?>" alt="<?= htmlspecialchars($t['name']) ?>">
                            </div>
                            <div class="testi-card__body">
                                <p class="testi-card__text">“<?= htmlspecialchars($t['text']) ?>”</p>
                                <div class="testi-card__who">
                                    <strong class="testi-name"><?= htmlspecialchars($t['name']) ?></strong>
                                    <span class="testi-role"><?= htmlspecialchars($t['role']) ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </div> <!-- .home-container -->
</div> <!-- #home-page -->

<script src="assets/js/common/pages/home.js"></script>