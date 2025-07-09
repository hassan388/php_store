<?php
// Include the database configuration file.
require_once 'config.php';

// Initialize variables.
$error_msg = '';
$product = null;

// --- Fetch Product Data ---
// Check if a product ID is provided in the URL.
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Try to fetch the product from the database.
    try {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the product is not found, set an error message.
        if (!$product) {
            $error_msg = "Product not found.";
        }
    } catch (PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
} else {
    $error_msg = "No product ID specified.";
}

// --- Handle Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $product) {
    // Get and trim form data.
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $quantity = trim($_POST["quantity"]);
    $errors = [];

    // --- Validation ---
    if (empty($name)) {
        $errors[] = "Product name is required";
    }
    if (empty($price)) {
        $errors[] = "Price is required";
    } elseif (!is_numeric($price) || $price < 0) {
        $errors[] = "Price must be a valid positive number";
    }
    if (empty($quantity)) {
        $errors[] = "Quantity is required";
    } elseif (!is_numeric($quantity) || $quantity < 0 || floor($quantity) != $quantity) {
        $errors[] = "Quantity must be a valid positive integer";
    }

    // If there are no validation errors, update the database.
    if (empty($errors)) {
        try {
            // Prepare the SQL query to update the product.
            $query = "UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
            $stmt = $pdo->prepare($query);
            // Bind the new data to the prepared statement.
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':price', (float)$price, PDO::PARAM_STR);
            $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to the main page with a success message.
            header("Location: index.php?success=Product updated successfully");
            exit();
        } catch (PDOException $e) {
            $error_msg = "Error updating product: " . $e->getMessage();
        }
    } else {
        // If there are validation errors, combine them into a single message.
        $error_msg = implode("<br>", $errors);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 mt-5 shadow p-3 rounded">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Update Product</h2>
                    </div>
                    <!-- Main Body of update product form -->
                    <div class="card-body">
                        <!-- in case of error show messge alert  -->
                        <?php if ($error_msg): ?>
                        <div class="alert alert-danger"><?= $error_msg ?></div>
                        <?php endif; ?>
                        <!-- if product is found show form to update product  -->
                        <?php if ($product): ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <!-- product name -->
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <!-- product price -->
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" class="form-control" id="price"
                                        name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <!-- product quantity -->
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity"
                                    value="<?= htmlspecialchars($product['quantity']) ?>" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <!-- Back to index button and submit button  -->
                                <a href="index.php" class="btn btn-secondary">Back to List</a>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                        <!-- Else if product is not found  -->
                        <?php else: ?>
                        <div class="alert alert-warning">Product not found or error loading the product. <a
                                href="index.php">Go back to the list.</a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>