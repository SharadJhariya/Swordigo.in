<?php
// includes/common/head.php
// Bootstraps session, DB connection, meta tags, favicon, loads Bootstrap, Material Icons, fonts, CSS and opens <body>

// Start session if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Find a file by walking up parent directories.
 * Example: find_up("global-db/db.php", __DIR__, 6);
 */
function find_up($relativePath, $startDir = __DIR__, $levels = 6)
{
    $dir = realpath($startDir);
    for ($i = 0; $i <= $levels && $dir !== false; $i++) {
        $candidate = $dir . DIRECTORY_SEPARATOR . $relativePath;
        if (file_exists($candidate)) {
            return realpath($candidate);
        }
        $parent = dirname($dir);
        if ($parent === $dir) break; // reached filesystem root
        $dir = $parent;
    }
    return null;
}

// Locate db.php (inside global-db/)
$dbPath = find_up('global/database/db.php', __DIR__, 6);

if ($dbPath === null) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    echo "Error: db.php not found.\n";
    echo "Searched upward from: " . __DIR__ . "\n";
    echo "Expected at: swordigo.in/global-db/db.php\n";
    exit(1);
}

// Include DB connection
require_once $dbPath;

// --- Site defaults (can be overridden per page) ---
$site_title = $site_title ?? "Swordigo.in";
$site_description = $site_description ?? "Premium Katana Swords, Samurai Blades & Collectibles";
$site_keywords = $site_keywords ?? "katana, samurai sword, swords, swordigo, collectibles";
$site_author = $site_author ?? "Swordigo Team";

// Page title (default if not set before including head.php)
if (!isset($page_title) || empty($page_title)) {
    $page_title = $site_title;
}

// Optional: allow pages to set a canonical URL
$canonical_url = $canonical_url ?? null;
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Basic Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO -->
    <title><?= htmlspecialchars($page_title, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($site_description, ENT_QUOTES) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($site_keywords, ENT_QUOTES) ?>">
    <meta name="author" content="<?= htmlspecialchars($site_author, ENT_QUOTES) ?>">
    <meta name="theme-color" content="#2a2a2a">

    <link rel="icon" href="assets/images/logos/icon.svg" type="image/svg+xml">


    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($site_description, ENT_QUOTES) ?>">
    <meta property="og:image" content="/assets/images/logos/logo-512.png">
    <meta property="og:url" content="https://swordigo.in/">
    <meta property="og:type" content="website">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($site_description, ENT_QUOTES) ?>">
    <meta name="twitter:image" content="/assets/images/logos/logo-512.png">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/logos/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/logos/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/logos/apple-touch-icon.png">
    

    <!-- Font Awesome (for social icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- Google Fonts (Inter for UI, Playfair Display for headings) -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

    <!-- Material Icons (minimalist) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main site CSS (compiled from SCSS) -->
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- Small inline critical styles (optional) -->
    <style>
        /* Ensure body background and base font are visible immediately */
        body {
            background: #ffffff;
            color: #000000;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        .sr-only {
            position: absolute !important;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>

    <!-- Core JS helpers (deferred) -->
    <!-- <script type="module" src="assets/js/core.js"></script> -->



    <!-- Bootstrap JS bundle (includes Popper) - defer to avoid render-block -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <?php
// head.php ends here; page content follows after including this file
