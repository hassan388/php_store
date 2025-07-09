<?php
// Include the database configuration file.
require_once 'config.php';

// --- CSV Export ---

// Set HTTP headers to force a CSV file download.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=products.csv');

// Open a file pointer to the output stream.
$output = fopen('php://output', 'w');

// Write the CSV column headers.
fputcsv($output, array('ID', 'Name', 'Price', 'Quantity'));

// Fetch all products from the database.
$stmt = $pdo->query("SELECT id, name, price, quantity FROM products ORDER BY id ASC");

// Loop through the results and write each product row to the CSV.
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

// Close the file pointer.
fclose($output);
?>