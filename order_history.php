<?php
session_start();
include 'header.php';
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = "order_history.php";
    header("Location: sign_in.php");
    exit;
}

$db = new Database();
$user_id = $_SESSION['user_id'];

$stmt = $db->query(
    "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC",
    "i",
    [$user_id]
);
$orders = $stmt->get_result();
?>

<link rel="stylesheet" href="css/order_history.css">

<div class="orders-page">
    <h2>My Orders</h2>

    <?php if ($orders->num_rows === 0): ?>
        <p>You haven't placed any orders yet.</p>
    <?php else: ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <div class="order-card">
                <h3>Order #<?= $order['id'] ?> — €<?= number_format($order['total'], 2) ?></h3>
                <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>Date:</strong> <?= date("F j, Y", strtotime($order['created_at'])) ?></p>

                <div class="order-items">
                    <?php
                    $itemStmt = $db->query(
                        "SELECT oi.*, p.name, p.image_url
                         FROM order_items oi
                         JOIN products p ON oi.product_id = p.id
                         WHERE oi.order_id = ?",
                        "i",
                        [$order['id']]
                    );
                    $items = $itemStmt->get_result();
                    while ($item = $items->fetch_assoc()):
                        ?>
                        <div class="order-item">
                            <img src="<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div>
                                <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
                                <p>Color: <?= $item['color'] ?> | Size: <?= $item['size'] ?></p>
                                <p>Quantity: <?= $item['quantity'] ?> | Price: €<?= number_format($item['price'], 2) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
