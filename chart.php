<?php

// Include database connection
require "config/db.php";

// Fetch data for bar chart - Group products by category and count them
// This query groups all products by their category and counts how many products exist in each category
$chartData = $pdo->query(
    "SELECT category, COUNT(*) AS total FROM products GROUP BY category"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Analytics - Category-wise Distribution</title>

    <!-- Bootstrap 5 CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- Main Container -->
<div class="container my-5">

    <!-- ================= HEADER SECTION ================= -->
    <div class="chart-header fade-in">
        <h1><i class="bi bi-bar-chart-fill"></i> Product Analytics</h1>

        
        <!-- Back to Product List Button -->
        <div class="text-center">
            <a href="index.php" class="btn-back">
                <i class="bi bi-arrow-left-circle"></i> Back to Product List
            </a>
        </div>
    </div>

    <!-- ================= BAR CHART SECTION ================= -->
    <div class="card mb-4 slide-up">
        <div class="card-header card-header-cyan">
            <h5><i class="bi bi-bar-chart-fill"></i> Category-wise Product Distribution</h5>
        </div>
        <div class="card-body">
            
            <?php if (count($chartData) > 0): ?>
            
            <!-- Chart Info Alert -->
            <div class="chart-info">
                <i class="bi bi-info-circle-fill"></i>
                <strong>The bar chart below shows the distribution of products across different categories.</strong>
            </div>
            
            <!-- Chart Container -->
            <div class="chart-container">
                <canvas id="categoryBarChart"></canvas>
            </div>
            
            <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>No data available for chart</h5>
                <p>Please add products first to see analytics.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- ================= CATEGORY SUMMARY ================= -->
    <?php if (count($chartData) > 0): ?>
    <div class="card shadow-sm mb-4 slide-up" style="animation-delay: 0.1s;">
        <div class="card-header card-header-gray">
            <h5><i class="bi bi-list-columns"></i> Category Summary</h5>
        </div>
        <div class="card-body">
            <div class="category-summary">
                <h6>Products by Category</h6>
                <div class="summary-grid">
                    <?php foreach ($chartData as $data): ?>
                    <div class="summary-item">
                        <i class="bi bi-tag-fill"></i>
                        <span><?= htmlspecialchars($data['category']) ?>: <strong><?= $data['total'] ?> products</strong></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Total Count -->
                <div class="total-summary">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Total Products: <strong><?= array_sum(array_column($chartData, 'total')) ?></strong></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ================= ABOUT SECTION ================= -->
    <div class="card shadow-sm slide-up" style="animation-delay: 0.2s;">
        <div class="card-header card-header-gray">
            <h5><i class="bi bi-info-circle"></i> About This Analytics Page</h5>
        </div>
        <div class="card-body">
            <div class="about-content">
                <p><strong>This analytics dashboard provides visual insights into your product inventory.</strong></p>
                <p>The bar chart displays the number of products in each category, helping you understand which categories have the most products. This information can be useful for inventory management and decision making.</p>
                
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js Configuration Script -->
<?php if (count($chartData) > 0): ?>
<script>
// ================= PREPARE DATA FROM PHP =================
const categories = <?= json_encode(array_column($chartData, 'category')) ?>;
const totals = <?= json_encode(array_column($chartData, 'total')) ?>;

// ================= DEFINE COLOR PALETTE =================
// Using pink, blue, yellow colors to match screenshots
const colors = [
    'rgba(255, 99, 132, 0.8)',   // Pink
    'rgba(54, 162, 235, 0.8)',   // Blue
    'rgba(255, 206, 86, 0.8)',   // Yellow
    'rgba(75, 192, 192, 0.8)',   // Teal
    'rgba(153, 102, 255, 0.8)',  // Purple
    'rgba(255, 159, 64, 0.8)',   // Orange
    'rgba(201, 203, 207, 0.8)',  // Gray
    'rgba(255, 99, 132, 0.6)',   // Light Pink
    'rgba(54, 162, 235, 0.6)',   // Light Blue
    'rgba(255, 206, 86, 0.6)'    // Light Yellow
];

// ================= ASSIGN COLORS TO BARS =================
const barColors = categories.map((_, index) => colors[index % colors.length]);

// ================= CREATE CHART =================
const ctx = document.getElementById('categoryBarChart').getContext('2d');

const categoryChart = new Chart(ctx, {
    type: 'bar',
    
    data: {
        labels: categories,
        datasets: [{
            label: 'Number of Products',
            data: totals,
            backgroundColor: barColors,
            borderColor: barColors.map(color => color.replace('0.8', '1')),
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: barColors.map(color => color.replace('0.8', '1'))
        }]
    },
    
    options: {
        responsive: true,
        maintainAspectRatio: true,
        
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
        },
        
        plugins: {
            title: {
                display: false
            },
            
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 13,
                        weight: '500'
                    },
                    padding: 15,
                    color: '#495057',
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(13, 110, 253, 0.9)',
                titleFont: {
                    size: 15,
                    weight: '600'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12,
                cornerRadius: 6,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed.y;
                        label += (context.parsed.y === 1) ? ' Product' : ' Products';
                        return label;
                    }
                }
            }
        },
        
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: {
                        size: 12,
                        weight: '500'
                    },
                    color: '#6c757d'
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    drawBorder: false
                },
                title: {
                    display: true,
                    text: 'Number of Products',
                    font: {
                        size: 14,
                        weight: '600'
                    },
                    color: '#495057',
                    padding: 10
                }
            },
            
            x: {
                ticks: {
                    font: {
                        size: 12,
                        weight: '500'
                    },
                    color: '#6c757d'
                },
                grid: {
                    display: false,
                    drawBorder: false
                },
                title: {
                    display: true,
                    text: 'Product Categories',
                    font: {
                        size: 14,
                        weight: '600'
                    },
                    color: '#495057',
                    padding: 10
                }
            }
        }
    }
});
</script>
<?php endif; ?>

</body>
</html>

