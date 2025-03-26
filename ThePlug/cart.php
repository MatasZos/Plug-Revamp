<?php
session_start();
include 'header.php';
include 'db_connect.php';

// Handle add-to-cart POST from product_detail.php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $quantity = 1; // default, can make dynamic later

    $db = new Database();
    $stmt = $db->query("SELECT * FROM products WHERE id = ?", "i", [$product_id]);
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        $item = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image_url'],
            'color' => $color,
            'size' => $size,
            'quantity' => $quantity
        ];

        // Avoid duplicate exact variants by merging quantities
        $found = false;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        foreach ($_SESSION['cart'] as &$cartItem) {
            if (
                $cartItem['product_id'] == $item['product_id'] &&
                $cartItem['color'] === $item['color'] &&
                $cartItem['size'] === $item['size']
            ) {
                $cartItem['quantity'] += $item['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        header("Location: cart.php");
        exit;
    }
}

// Handle remove
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<link rel="stylesheet" href="css/cart.css">

<div class="cart-container">
    <h2>Your Cart</h2>

    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
        <a href="products.php" class="button">Continue Shopping</a>
    <?php else: ?>
        <div class="cart-items">
            <?php foreach ($cart as $index => $item): ?>
                <div class="cart-item">
                    <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="item-info">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Color: <?= $item['color'] ?> | Size: <?= $item['size'] ?></p>
                        <p>Quantity: <?= $item['quantity'] ?></p>
                        <p>Price: €<?= number_format($item['price'], 2) ?></p>
                        <p>Subtotal: €<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                        <a href="cart.php?remove=<?= $index ?>" class="remove">Remove</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <h3>Total: €<?= number_format($total, 2) ?></h3>
            <a href="checkout.php" class="button">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
