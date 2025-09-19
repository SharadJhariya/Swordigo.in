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
require_once $INCLUDES . '/common/head.php';

// Cart drawer (right sidebar)
require_once $INCLUDES . '/common/cart.php';

// Sidebar navigation
require_once $INCLUDES . '/common/sidebar.php';

// navbar navigation
require_once $INCLUDES . '/common/navbar.php';

// Bottom nav (mobile only)
require_once $INCLUDES . '/common/bottom-nav.php';

// --- MAIN PAGE CONTENT ---
echo "<main id=\"page-" . htmlspecialchars(str_replace('/', '-', $page)) . "\">\n";

if (file_exists($include_file)) {
    include $include_file;
} else {
    echo "<section class='container'><h1>Page not found</h1></section>";
}

echo "\n</main>\n";

// Footer (contact, socials, closes body/html)
require_once $INCLUDES . '/common/footer.php';
