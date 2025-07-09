<?php
// Include the database configuration file.
require_once 'config.php';

// Initialize variables for error and success messages.
$error_msg = '';
$success_message = '';

// Check if the form has been submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // If there are no validation errors, insert the data into the database.
    if (empty($errors)) {
        try {
            // Prepare the SQL query to insert a new product.
            $query = "INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)";
            $stmt = $pdo->prepare($query);
            // Bind the form data to the prepared statement.
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":price", (float)$price, PDO::PARAM_STR);
            $stmt->bindValue(":quantity", (int)$quantity, PDO::PARAM_INT);
            // Execute the query.
            $stmt->execute();
            // Redirect to the main page with a success message.
            header("Location: index.php?success=Product added successfully");
            exit();
        } catch (PDOException $e) {
            // If there's a database error, set an error message.
            $error_msg = "Error adding product: " . $e->getMessage();
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-mg-6 col-sm-8 mt-5 shadow p-2 rounded ">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Add New Product</h2>
                    </div>
                    <!-- main body -->
                    <div class="card-body">
                        <!-- form to add data to database -->
                        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                            <div class="mb-3">
                                <!-- Product name -->
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <!-- Product price -->

                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" class="form-control" id="price"
                                        name="price" value="<?= isset($price) ? htmlspecialchars($price) : '' ?>"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <!-- Product quantity -->

                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity"
                                    value="<?= isset($quantity) ? htmlspecialchars($quantity) : '' ?>" required>
                            </div>
                            <!-- back to index button  and submit button-->
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>