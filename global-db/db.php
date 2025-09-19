<?php
// global-db/db.php
// PDO database connection for Swordigo
// NOTE: your DB name contains a dot: "swordigo.in"

$DB_HOST = "127.0.0.1";      // or "localhost"
$DB_NAME = "swordigo.in";    // exact database name as shown in phpMyAdmin
$DB_USER = "root";           // XAMPP default
$DB_PASS = "";               // XAMPP default (empty)

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO($dsn, $DB_USER, $DB_PASS, $options);
    // Optional: small sanity check — remove/comment out in production
    // $db->query("SELECT 1");
} catch (PDOException $e) {
    // Friendly error; in production you should log and show a generic message instead
    die("Database connection failed: " . $e->getMessage());
}
