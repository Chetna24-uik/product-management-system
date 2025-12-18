<?php

// ================= DATABASE CREDENTIALS =================

$host = "localhost";         // Database server (usually localhost for XAMPP)
$dbname = "crud_db";         // Database name - MUST match your database
$username = "root";          // Default XAMPP username
$password = "";              // Default XAMPP password (empty)

// ================= PDO CONNECTION =================

try {
    // Create new PDO instance
    // DSN (Data Source Name) format: "mysql:host=hostname;dbname=database_name"
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",  // Connection string with UTF-8 support
        $username,
        $password
    );
    
    // Set PDO error mode to exceptions
    // This means PDO will throw exceptions on errors instead of just warnings
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    // This makes fetching data easier: $row['column_name']
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Disable emulated prepared statements for better security
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Optional: Uncomment below to test connection
    // echo "Database connected successfully!";

} catch (PDOException $e) {
    // If connection fails, stop execution and display error
    // In production, you should log errors instead of displaying them
    die("Database Connection Failed: " . $e->getMessage() . "<br><br>
         <strong>Common Solutions:</strong><br>
         1. Make sure XAMPP MySQL service is running<br>
         2. Check if database '$dbname' exists in phpMyAdmin<br>
         3. Verify username and password are correct<br>
         4. Import sql/database.sql file to create tables");
}
?>

