-- =============================================
-- Product Management System - Database Setup
-- =============================================
-- 
-- This SQL script creates:
-- 1. Database: crud_db
-- 2. Table: products
-- 3. Sample data for testing
--
-- How to use:
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click "Import" tab
-- 3. Choose this file and click "Go"
-- OR
-- Copy and paste this SQL into the SQL tab
-- =============================================

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS crud_db;

-- Select the database to use
USE crud_db;

-- Drop table if exists (optional - uncomment if you want fresh start)
-- DROP TABLE IF EXISTS products;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for each product',
    name VARCHAR(100) NOT NULL COMMENT 'Product name',
    price DECIMAL(10,2) NOT NULL COMMENT 'Product price (up to 10 digits, 2 decimal places)',
    category VARCHAR(50) NOT NULL COMMENT 'Product category',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Sample Data for Testing (Optional)
-- =============================================
-- Uncomment the lines below to insert sample products

INSERT INTO products (name, price, category) VALUES
('Laptop Dell XPS 15', 1299.99, 'Electronics'),
('iPhone 14 Pro', 999.00, 'Electronics'),
('Samsung Galaxy S23', 849.99, 'Electronics'),
('Office Chair Ergonomic', 249.50, 'Furniture'),
('Standing Desk', 399.99, 'Furniture'),
('Bookshelf Oak Wood', 179.99, 'Furniture'),
('Nike Air Max Shoes', 129.99, 'Clothing'),
('Adidas T-Shirt', 29.99, 'Clothing'),
('Levi\'s Jeans', 79.99, 'Clothing'),
('Harry Potter Book Set', 59.99, 'Books'),
('The Lord of the Rings', 34.99, 'Books'),
('Python Programming Guide', 44.99, 'Books');

-- =============================================
-- Verify Installation
-- =============================================
-- Run this query to check if data was inserted successfully:
-- SELECT * FROM products;

-- Check table structure:
-- DESCRIBE products;

-- Count total products:
-- SELECT COUNT(*) as total_products FROM products;

-- Count products by category:
-- SELECT category, COUNT(*) as total FROM products GROUP BY category;
