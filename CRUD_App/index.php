<?php
// Include the database configuration file. `require_once` ensures it's included only once.
require_once 'config.php';

// --- Pagination Setup ---
// Set the number of products to display per page.
$limit = 10;
// Get the current page number from the URL, default to 1 if not set.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Ensure the page number is not less than 1.
$page = max($page, 1);
// Calculate the starting record for the current page.
$start = ($page - 1) * $limit;
// --- Search Functionality ---
// Get the search term from the URL, default to an empty string if not set.
$search = isset($_GET['search']) ? $_GET['search'] : '';
// Initialize search condition and parameters for the SQL query.
$search_condition = '';
$params = [];
// If a search term is provided, create a WHERE clause for the SQL query.
if (!empty($search)) {
    $search_condition = "WHERE name LIKE :search";
    $params[':search'] = "%$search%";
}
// --- Fetch Products ---
// Prepare the SQL query to select products with search and pagination.
$stmt = $pdo->prepare("SELECT * FROM products $search_condition LIMIT :start, :limit");
// Bind the search parameter if it exists.
if (!empty($search)) {
    $stmt->bindValue(":search", $params[':search'], PDO::PARAM_STR);
}
// Bind pagination parameters.
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
// Execute the query and fetch the results.
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Calculate Total Pages ---
// Prepare and execute a query to count the total number of products (with search filter).
$count_query = $pdo->prepare("SELECT COUNT(*) as total FROM products $search_condition");
if (!empty($search)) {
    $count_query->bindValue(":search", $params[':search'], PDO::PARAM_STR);
}
$count_query->execute();
// Get the total number of products.
$total_products = (int)$count_query->fetchColumn();
// Calculate the total number of pages required for pagination.
$total_pages = ceil($total_products / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</head>

<body>
    <div class="comtainer">
        <div class="row">
            <div class="col-lg-8 col-sm-10 mt-5 mb-5 shadow p-2 rounded mx-auto ">

                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Products and Items</h1>
                    </div>
                    <!-- shows alert when product is deleted or added -->

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!-- main body of the page -->

                    <div class="card-body">
                        <div class="row mb-3 ">
                            <div class="col-lg-12 d-flex justify-content-between">
                                <!-- search bar new product button download to excel and upload to axcel buttons -->

                                <div>
                                    <a href="add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Product</a>
                                    <a href="export.php" class="btn btn-success"><i class="bi bi-download"></i> Export to CSV</a>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload"></i> Import from CSV</button>
                                </div>
                                <!-- search bar -->

                                <form action="" method="get" class="search-form d-lg-flex">
                                    <input type="text" name="search" placeholder="Search Product By Name"
                                        class="form-control me-2">
                                    <button class="btn btn-primary d-flex align-items-center gap-2"><i
                                            class="bi bi-search"></i>

                                        Search</button>
                                </form>
                            </div>
                        </div>
                        <!-- products table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered  ">
                                <thead class="table-light">
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Price</td>
                                        <td>Quantity</td>
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Products table display logic -->
                                    <?php if(count($results)>0): ?>
                                    <?php foreach($results as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id'])?></td>
                                        <td><?= htmlspecialchars($row['name'])?></td>
                                        <td>$<?= number_format($row['price'],2)?></td>
                                        <td><?= htmlspecialchars($row['quantity'])?></td>
                                        <td>
                                            <a href='update.php?id=<?=$row['id']?>' class='btn btn-success me-2'><i
                                                    class='bi bi-pen'></i>Edit</a>
                                            <a href='delete.php?id=<?= $row['id']?>' class='btn btn-danger' onclick="return confirm('Are you sure you want to delete this product?');"><i
                                                    class='bi bi-trash'></i>Delete </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else :  ?>
                                    <tr>
                                        <td colspan="5" class="text-centerd">No Products Found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <?php if($total_pages > 1): ?>
                        <nav aria-label="page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?> ">
                                    <a class="page-link" href="?page=<?= $page - 1  ?>&seach=<?= urlencode($search) ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?> ">
                                    <a class="page-link"
                                        href="?page=<?= $i ?> &search=<?= urlencode($search) ?>"><?= $i?></a>
                                </li>
                                <?php endfor; ?>
                                <li class="page-item <?=($page >= $total_pages) ? 'disabled' : '' ?> ">
                                    <a class="page-link"
                                        href="?page=<?=$page + 1?> & search=<?= urlencode($search) ?>"><span
                                            aria-hidden="true">&raquo;</span></a>
                                </li>
                                </li>
                            </ul>
                        </nav>
                        <?php endif; ?>
                        <div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>


<!-- Import Modal for uploading a excel file  -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Products from CSV</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="import.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="file" class="form-label">Select CSV File</label>
            <input type="file" name="file" id="file" class="form-control" accept=".csv" required>
          </div>
          <button type="submit" class="btn btn-primary">Upload and Import</button>
        </form>
      </div>
    </div>
  </div>
</div>

</body>

</html>