<?php
// global-db/db.php
// PDO database connection for Swordigo (XAMPP local)

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';  // local MySQL
$DB_NAME = getenv('DB_DATABASE') ?: 'swordigo';   // your database name
$DB_USER = getenv('DB_USERNAME') ?: 'root';       // default XAMPP user
$DB_PASS = getenv('DB_PASSWORD') ?: '';           // default XAMPP password is empty

$dsn = "mysql:host={$DB_HOST};port=3306;dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
