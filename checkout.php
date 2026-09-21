<?php
session_start();
include 'header.php';
include 'db_connect.php';

$db = new Database();

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// --- HANDLE FORM SUBMIT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $delivery_method = $_POST['delivery_method'];
    $payment_method = $_POST['payment_method'] ?? null;
    $card_number = $_POST['card_number'] ?? null;
    $discount_code = trim($_POST['discount_code']);

    // Apply discount if valid
    if ($discount_code !== "") {
        $check = $db->query("SELECT * FROM discounts WHERE code = ?", "s", [$discount_code])->get_result();
        if ($check->num_rows > 0) {
            $discount = $check->fetch_assoc();
            $total -= $discount['amount'];
            if ($total < 0) $total = 0;
        }
    }

    // Determine status
    $status = $delivery_method === 'pickup'
        ? 'Pick up at store'
        : 'Processing';

    // Insert order
    $db->query(
        "INSERT INTO orders (user_id, total, status, created_at, full_name, address, contact, delivery_method, payment_method, discount_code)
         VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)",
        "idsssssss",
        [$user_id, $total, $status, $full_name, $address, $contact, $delivery_method, $payment_method, $discount_code]
    );

    $order_id = $db->query("SELECT LAST_INSERT_ID()")->get_result()->fetch_row()[0];

    // Insert items & reduce stock
    foreach ($cart as $item) {
        $db->query(
            "INSERT INTO order_items (order_id, product_id, color, size, quantity, price)
             VALUES (?, ?, ?, ?, ?, ?)",
            "iissid",
            [$order_id, $item['product_id'], $item['color'], $item['size'], $item['quantity'], $item['price']]
        );

        $db->query(
            "UPDATE product_variants
             SET quantity = quantity - ?
             WHERE product_id = ? AND color = ? AND size = ?",
            "iiss",
            [$item['quantity'], $item['product_id'], $item['color'], $item['size']]
        );
    }

    unset($_SESSION['cart']);
    header("Location: order_history.php");
    exit;
}
?>

<link rel="stylesheet" href="css/checkout.css">

<div class="checkout-form">
    <h2>Checkout</h2>
    <form method="POST" id="checkout-form">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Address</label>
        <textarea name="address" required></textarea>

        <label>Contact Info</label>
        <input type="text" name="contact" required>

        <label>Delivery Method</label>
        <select name="delivery_method" id="delivery-method" required>
            <option value="delivery">Delivery</option>
            <option value="pickup">Pick Up</option>
        </select>

        <div id="payment-options">
            <label>Payment Method</label>
            <select name="payment_method" id="payment-method" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="Revolut">Revolut</option>
                <option value="PayPal">PayPal</option>
            </select>

            <div id="card-info">
                <label>Card Number</label>
                <input type="text" name="card_number" placeholder="1234 5678 9012 3456">
            </div>
        </div>

        <label>Discount Code (optional)</label>
        <input type="text" name="discount_code">

        <p><strong>Total: €<?= number_format($total, 2) ?></strong></p>

        <button type="submit">Place Order</button>
    </form>
</div>

<script src="js/checkout.js"></script>
<?php include 'footer.php'; ?>
