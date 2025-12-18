<?php

require "../config/db.php";

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    
    // Get the product ID from URL parameter
    $id = $_GET['id'];
    
    // ================= VALIDATION =================
    
    // Validate that ID is a valid number
    if (!is_numeric($id) || $id <= 0) {
        die("Error: Invalid product ID.");
    }
    
    // ================= DATABASE DELETE =================
    
    try {
        // First, check if the product exists before deleting
        $checkStmt = $pdo->prepare("SELECT id, name FROM products WHERE id = ?");
        $checkStmt->execute([$id]);
        $product = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            die("Error: Product not found or already deleted.");
        }
        
        // Prepare SQL DELETE statement with placeholder (?)
        // This prevents SQL injection attacks
        $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
        
        // Execute the prepared statement with actual value
        $stmt->execute([$id]);
       
        
    } catch (PDOException $e) {
        // If there's a database error, display error message
        die("Database Delete Error: " . $e->getMessage());
    }
    
} else {
    // If no ID is provided, show error message
    die("Error: No product ID provided for deletion.");
}

// Redirect back to main page after successful deletion
header("Location: ../index.php");
exit();
?>
