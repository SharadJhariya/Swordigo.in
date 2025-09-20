<?php
// index.php — Swordigo Customer Frontend Entry

// Show errors during development (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define paths
$PROJECT_ROOT = __DIR__;
$INCLUDES     = $PROJECT_ROOT . '/includes';
$PAGES_DIR    = $PROJECT_ROOT . '/pages';

// Requested page (?page=...)
$page = $_GET['page'] ?? 'home';
$page = preg_replace('#\.+[/\\\]#', '', $page); // prevent directory traversal
$page = trim($page, "/\\");
if ($page === '') $page = 'home';

// Allowed pages
$allowed_pages = [
    'home',
    'product',
    'product-reviews',
    'category',
    'search',
    'checkout',
    'payment',
    'payment-failed',
    'thank-you',
    'invoice',
    'profile',
    'account-settings',
    'addresses',
    'orders',
    'track-order',
    'reviews',
    'wishlist',
    'compare',
    'contact',
    'faq',
    'blog',
    'blog-post',
    'sitemap',
    '404',
    '500',
    'maintenance'
];
$allowed_auth_pages = [
    'auth/login',
    'auth/register',
    'auth/verify',
    'auth/welcome',
    'auth/resend-verification'
];

// Resolve file path
$include_file = null;
if (in_array($page, $allowed_auth_pages, true)) {
    $include_file = $PAGES_DIR . '/' . $page . '.php';
} elseif (in_array($page, $allowed_pages, true)) {
    $include_file = $PAGES_DIR . '/' . $page . '.php';
} else {
    $include_file = $PAGES_DIR . '/404.php';
    http_response_code(404);
    $page = '404';
}

// Default page title (can be overridden in page file)
if (!isset($page_title)) {
    $page_title = ucwords(str_replace(['-', '/'], [' ', ' - '], $page)) . ' - Swordigo.IN';
}

// --- COMMON PARTS ---
// Head (meta + db + opens <body>)
$head_file = $INCLUDES . '/common/head.php';
if (file_exists($head_file)) {
    require_once $head_file;
} else {
    // Minimal head fallback (so page doesn't break completely)
    echo "<!doctype html><html><head><meta charset='utf-8'><title>{$page_title}</title></head><body>";
}

// Cart drawer (right sidebar)
$cart_file = $INCLUDES . '/common/cart.php';
if (file_exists($cart_file)) {
    require_once $cart_file;
}

// Sidebar navigation
$sidebar_file = $INCLUDES . '/common/sidebar.php';
if (file_exists($sidebar_file)) {
    require_once $sidebar_file;
}

// navbar navigation
$navbar_file = $INCLUDES . '/common/navbar.php';
if (file_exists($navbar_file)) {
    require_once $navbar_file;
}

// Bottom nav (mobile only)
$bottom_nav_file = $INCLUDES . '/common/bottom-nav.php';
if (file_exists($bottom_nav_file)) {
    require_once $bottom_nav_file;
}

// --- MAIN PAGE CONTENT ---
// include the resolved page file (fall back to 404 if it doesn't exist)
if ($include_file && file_exists($include_file)) {
    require_once $include_file;
} else {
    // If something unexpected happened, show 404
    http_response_code(404);
    $page_title = '404 - Swordigo.IN';
    $fallback_404 = $PAGES_DIR . '/404.php';
    if (file_exists($fallback_404)) {
        require_once $fallback_404;
    } else {
        echo '<main style="padding:32px;font-family:Arial,Helvetica,sans-serif;">';
        echo '<h1>404 Not Found</h1><p>The page you requested could not be found.</p>';
        echo '</main>';
    }
}

// Footer (contact, socials, closes body/html)
$footer_file = $INCLUDES . '/common/footer.php';
if (file_exists($footer_file)) {
    require_once $footer_file;
} else {
    // Close HTML if head fallback was used
    if (!file_exists($head_file)) {
        echo "</body></html>";
    }
}
