<?php


// Include database connection
require "../config/db.php";

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize and retrieve form data
    // trim() removes extra spaces from beginning and end
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $category = trim($_POST['category']);

    
    
    // Check if any field is empty
    if (empty($name) || empty($price) || empty($category)) {
        die("Error: All fields are required. Please fill in all fields.");
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

    // ================= DATABASE INSERT =================
    
    try {
        // Prepare SQL statement with placeholders (?)
        // This prevents SQL injection attacks
        $stmt = $pdo->prepare(
            "INSERT INTO products (name, price, category) VALUES (?, ?, ?)"
        );
        
        // Execute the prepared statement with actual values
        // PDO automatically sanitizes the data
        $stmt->execute([$name, $price, $category]);
        
        // Optional: You can get the last inserted ID
        // $lastInsertId = $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        // If there's a database error, display error message
        die("Database Insert Error: " . $e->getMessage());
    }
}

// Redirect back to main page after successful insertion
header("Location: ../index.php");
exit();
?>
