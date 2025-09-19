<?php
// pages/home.php
// This is the homepage main body

// Optional: set page title (overrides default from index.php)
$page_title = "Welcome to Swordigo.IN — Premium Katanas";

// Example query: get latest products
$stmt = $db->query("SELECT id, name, price, mrp FROM products ORDER BY created_at DESC LIMIT 5");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section id="page-home" class="container">
    <h1>Welcome to Swordigo.IN ⚔️</h1>
    <p>Premium Katanas, Samurai Blades & Collectibles</p>

    <h2>Latest Products</h2>
    <ul>
        <?php foreach ($products as $p): ?>
            <li>
                <?= htmlspecialchars($p['name']) ?> —
                <span class="price">₹<?= number_format($p['price']) ?></span>
                <?php if (!empty($p['mrp']) && $p['mrp'] > $p['price']): ?>
                    <span class="mrp"><s>₹<?= number_format($p['mrp']) ?></s></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>