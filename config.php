<?php
// config.php — site-wide settings (edit to match your context)
$SITE_NAME = "Gianni Bookings & Roster (GWRIS)";
$SITE_TAGLINE = "Simple online bookings and staff roster — MVP";
date_default_timezone_set("Australia/Sydney");

// Database configuration
$host = 'localhost';
$port = '3307'; // XAMPP MySQL port
$dbname = 'gianni_bookings';
$username = 'root';
$password = ''; // No password for XAMPP

try {
    // Try socket connection first
    $socket = '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
    $pdo = new PDO("mysql:unix_socket=$socket;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Fallback to TCP connection
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e2) {
        die("Database connection failed: " . $e2->getMessage());
    }
}
?>