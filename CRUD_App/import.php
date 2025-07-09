<?php
// Include the database configuration file.
require_once 'config.php';

// --- CSV Import ---

// Check if a file was uploaded.
if (isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    // Open the uploaded CSV file for reading.
    if (($handle = fopen($file, 'r')) !== FALSE) {
        // Skip the header row of the CSV file.
        fgetcsv($handle);

        // Prepare the SQL query for inserting data.
        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)");

        // Read the CSV file row by row.
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Execute the prepared statement with the data from the CSV.
            $stmt->execute([
                ':name' => $data[1], // Assuming name is in the second column
                ':price' => $data[2], // Assuming price is in the third column
                ':quantity' => $data[3] // Assuming quantity is in the fourth column
            ]);
        }

        // Close the file handle.
        fclose($handle);
        // Redirect with a success message.
        header('Location: index.php?success=Products imported successfully.');
    } else {
        // Redirect if there's an error opening the file.
        header('Location: index.php?error=Error opening the file.');
    }
} else {
    // Redirect if no file was uploaded.
    header('Location: index.php?error=No file uploaded.');
}
?>