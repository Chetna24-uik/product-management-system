<?php


// Include database connection
require "../config/db.php";

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Retrieve product ID (this identifies which product to update)
    $id = $_POST['id'];
    
    // Sanitize and retrieve form data
    // trim() removes extra spaces from beginning and end
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $category = trim($_POST['category']);

    
    // Check if any field is empty
    if (empty($name) || empty($price) || empty($category)) {
        die("Error: All fields are required. Please fill in all fields.");
    }

    // Validate that ID is a valid number
    if (!is_numeric($id) || $id <= 0) {
        die("Error: Invalid product ID.");
    }

    // Validate that price is a valid number
    if (!is_numeric($price)) {
        die("Error: Price must be a valid number.");
    }

    // Validate that price is not negative
    if ($price < 0) {
        die("Error: Price cannot be negative.");
    }

    // Validate product name length (minimum 2 characters)
    if (strlen($name) < 2) {
        die("Error: Product name must be at least 2 characters long.");
    }

    // Validate category length (minimum 2 characters)
    if (strlen($category) < 2) {
        die("Error: Category must be at least 2 characters long.");
    }

    // ================= DATABASE UPDATE =================
    
    try {
        // First, check if the product exists
        $checkStmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $checkStmt->execute([$id]);
        
        if ($checkStmt->rowCount() === 0) {
            die("Error: Product not found.");
        }
        
        // Prepare SQL UPDATE statement with placeholders (?)
        // This prevents SQL injection attacks
        $stmt = $pdo->prepare(
            "UPDATE products SET name=?, price=?, category=? WHERE id=?"
        );
        
        // Execute the prepared statement with actual values
        // PDO automatically sanitizes the data
        $stmt->execute([$name, $price, $category, $id]);
        
        // Optional: Check if any row was actually updated
        // $affectedRows = $stmt->rowCount();
        
    } catch (PDOException $e) {
        // If there's a database error, display error message
        die("Database Update Error: " . $e->getMessage());
    }
}

// Redirect back to main page after successful update
header("Location: ../index.php");
exit();
?>
