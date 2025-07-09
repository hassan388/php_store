<?php
// --- Database Connection Details ---
$host = 'localhost';    // Database host
$db   = 'task';         // Database name
$user = 'root';         // Database username
$pass = '';             // Database password
$charset = 'utf8mb4';   // Character set

// --- Data Source Name (DSN) ---
// This string contains the information required to connect to the database.
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// --- PDO Connection Options ---
$options = [
    // Set the PDO error mode to exception to catch and handle errors.
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Set the default fetch mode to associative array for easier access to data.
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// --- Create a PDO instance ---
// Try to connect to the database using the DSN, username, password, and options.
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If the connection fails, display an error message and stop the script.
    echo "Database connection failed: " . $e->getMessage();
    exit;
}
?>