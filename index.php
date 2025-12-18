<?php

require "config/db.php";

$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
  
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- Main Container -->
<div class="container my-5">

    <!-- ================= HEADER SECTION ================= -->
    <div class="main-header fade-in">
        <h1>Product Management System</h1>
        
        <!-- Navigation Button to Chart Page -->
        <div class="text-center mb-20">
            <a href="chart.php" class="btn-analytics">
                <i class="bi bi-bar-chart-fill"></i> View Analytics
            </a>
        </div>
    </div>

    <div class="row mb-30">
        <!-- ================= ADD PRODUCT SECTION (CREATE) ================= -->
        <div class="col-lg-12 mb-4 slide-up">
            <div class="card">
                <div class="card-header card-header-green">
                    <h5><i class="bi bi-plus-circle"></i> Add New Product</h5>
                </div>
                <div class="card-body">
                    
                    <!-- CREATE Form -->
                    <form method="POST" action="actions/create.php">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" name="name" id="productName" class="form-control" placeholder="Enter product name" required>
                            </div>
                            <div class="form-group">
                                <label for="productPrice">Price (₹)</label>
                                <input type="number" name="price" id="productPrice" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="productCategory">Category</label>
                                <input type="text" name="category" id="productCategory" class="form-control" placeholder="e.g., Electronics" required>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn-add-product">
                                    <i class="bi bi-check-circle"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= PRODUCT TABLE SECTION (READ) ================= -->
        <div class="col-lg-12 slide-up" style="animation-delay: 0.1s;">
            <div class="card">
                <div class="card-header card-header-blue">
                    <h5><i class="bi bi-list-ul"></i> Product List</h5>
                </div>
                <div class="card-body">
                    
                    <p class="table-description">Below is the list of all products currently in the inventory.</p>
                    
                    <?php if (count($products) > 0): ?>
                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Price (₹)</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $p): ?>
                                <tr>
                                    <!-- ID -->
                                    <td><?= $p['id'] ?></td>
                                    
                                    <!-- Product Name -->
                                    <td><?= htmlspecialchars($p['name']) ?></td>
                                    
                                    <!-- Price with Indian Rupee symbol -->
                                    <td><span class="price-text">₹<?= number_format($p['price'], 2) ?></span></td>
                                    
                                    <!-- Category -->
                                    <td>
                                        <span class="category-badge">
                                            <i class="bi bi-tag-fill"></i>
                                            <?= htmlspecialchars($p['category']) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Action Buttons (UPDATE & DELETE) -->
                                    <td>
                                        <div class="action-buttons">
                                            <!-- UPDATE: Edit Button -->
                                            <button class="btn-edit" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal<?= $p['id'] ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>

                                            <!-- DELETE: Delete Button -->
                                            <a href="actions/delete.php?id=<?= $p['id'] ?>"
                                               class="btn-delete"
                                               onclick="return confirm('Are you sure you want to delete this product?\n\nProduct: <?= htmlspecialchars($p['name']) ?>\n\nThis action cannot be undone.');">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ================= UPDATE MODAL ================= -->
                                <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- UPDATE Form -->
                                            <form method="POST" action="actions/update.php">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $p['id'] ?>">
                                                        <i class="bi bi-pencil-square"></i> Edit Product
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <!-- Hidden field to pass product ID -->
                                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                    
                                                    <!-- Product Name Field -->
                                                    <div class="mb-3">
                                                        <label for="editName<?= $p['id'] ?>" class="form-label">Product Name</label>
                                                        <input type="text" name="name" id="editName<?= $p['id'] ?>" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required>
                                                    </div>
                                                    
                                                    <!-- Price Field -->
                                                    <div class="mb-3">
                                                        <label for="editPrice<?= $p['id'] ?>" class="form-label">Price (₹)</label>
                                                        <input type="number" name="price" id="editPrice<?= $p['id'] ?>" class="form-control" value="<?= $p['price'] ?>" step="0.01" min="0" required>
                                                    </div>
                                                    
                                                    <!-- Category Field -->
                                                    <div class="mb-3">
                                                        <label for="editCategory<?= $p['id'] ?>" class="form-label">Category</label>
                                                        <input type="text" name="category" id="editCategory<?= $p['id'] ?>" class="form-control" value="<?= htmlspecialchars($p['category']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle"></i> Cancel
                                                    </button>
                                                    <button type="submit" class="btn-primary">
                                                        <i class="bi bi-check-circle"></i> Update Product
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <!-- Empty State Message -->
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5>No Products Found</h5>
                        <p>Add your first product using the form above to get started.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
