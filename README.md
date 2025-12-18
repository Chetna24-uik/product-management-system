# Product Management System

A simple and clean PHP-based CRUD application for managing product inventory with analytics visualization.

## Features

- **Add Products** - Create new products with name, price, and category
- **View Products** - Display all products in a clean table format
- **Edit Products** - Update existing product information
- **Delete Products** - Remove products from inventory
- **Analytics Dashboard** - Visual bar chart showing product distribution by category

## Screenshots

The application features a modern, color-coded interface with:
- Purple header for main title
- Green card for adding products
- Blue card for product listing
- Cyan badges for categories
- Color-coded action buttons (Yellow for Edit, Red for Delete)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache server (XAMPP recommended)
- Modern web browser

## Installation

1. **Clone or download** this project to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\crud-app
   ```

2. **Import the database**:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `crud_db`
   - Import the `sql/database.sql` file

3. **Configure database connection**:
   - Open `config/db.php`
   - Update credentials if needed (default: root with no password)

4. **Start XAMPP**:
   - Start Apache and MySQL services

5. **Access the application**:
   - Open your browser and go to: `http://localhost/crud-app`

## Project Structure

```
crud-app/
├── index.php           # Main page with product list and add form
├── chart.php           # Analytics page with bar chart
├── config/
│   └── db.php         # Database connection
├── actions/
│   ├── create.php     # Add new product
│   ├── update.php     # Edit product
│   └── delete.php     # Remove product
├── assets/
│   └── css/
│       └── style.css  # Custom styles
└── sql/
    └── database.sql   # Database schema
```

## Usage

### Adding a Product
1. Fill in the product name, price, and category in the form
2. Click the green "Add" button
3. Product will be added to the list below

### Editing a Product
1. Click the yellow "Edit" button on any product
2. Update the information in the modal
3. Click "Update Product" to save changes

### Deleting a Product
1. Click the red "Delete" button
2. Confirm the deletion
3. Product will be removed from the database

### Viewing Analytics
1. Click the "View Analytics" button at the top
2. See the bar chart showing products by category
3. View the category summary below the chart

## Technologies Used

- **Backend**: PHP with PDO for secure database operations
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Charts**: Chart.js for data visualization
- **Icons**: Bootstrap Icons

## Database Schema

The `products` table includes:
- `id` - Auto-increment primary key
- `name` - Product name (VARCHAR 255)
- `price` - Product price (DECIMAL 10,2)
- `category` - Product category (VARCHAR 100)
- `created_at` - Timestamp

## Notes


- All database operations use prepared statements for security
- Clean and modern UI with smooth animations



