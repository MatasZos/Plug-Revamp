<?php
include 'header.php';
session_start();
$order_id = $_GET['order_id'] ?? 0;
?>

<link rel="stylesheet" href="checkout.css">

<div class="checkout-section">
    <h2>Order Confirmed 🎉</h2>
    <p>Your order has been placed successfully.</p>
    <p><strong>Order ID:</strong> #<?= htmlspecialchars($order_id) ?></p>
    <a href="index.php" style="display: block; text-align: center; margin-top: 20px;">Return to Home</a>
</div>

<?php include 'footer.php'; ?>
