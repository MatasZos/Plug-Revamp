<?php
include_once '../require_admin.php';

include_once '../db_connect.php';
include_once '../header.php';
session_start();

$db = new Database();
$stmt = $db->query("SELECT id, name, price, image_url FROM products");
$result = $stmt->get_result();
?>

<link rel="stylesheet" href="../products.css">

<div class="admin-container">
    <div class="admin-sidebar">
        <h3>Admin Panel</h3>
        <ul>
            <li><a href="admin_products.php">Manage Products</a></li>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="view_products.php" class="active">View Products</a></li>
        </ul>
    </div>

    <div class="admin-main">
        <h2>All Products</h2>
        <div class="products">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <div class="price">€<?= number_format($row['price'], 2) ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include_once '../footer.php'; ?>
