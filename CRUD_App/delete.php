<?php
// Include the database configuration file.
require_once 'config.php';

// Initialize variables for messages.
$error_msg = '';

// Check if a product ID is provided in the URL.
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the SQL query to delete the product.
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        // Bind the product ID to the prepared statement.
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Execute the query.
        if ($stmt->execute()) {
            // If deletion is successful, redirect with a success message.
            header("Location: index.php?success=Product deleted successfully");
            exit();
        } else {
            // If deletion fails, set an error message.
            $error_msg = "Error deleting product.";
        }
    } catch (PDOException $e) {
        // If there's a database error, set an error message.
        $error_msg = "Database error: " . $e->getMessage();
    }
} else {
    // If no product ID is provided, set an error message.
    $error_msg = "No product ID specified.";
}

// If an error occurred, redirect to the main page with the error message.
if (!empty($error_msg)) {
    header("Location: index.php?error=" . urlencode($error_msg));
    exit();
}
?>