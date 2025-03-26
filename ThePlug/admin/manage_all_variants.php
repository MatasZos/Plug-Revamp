<?php
include 'admin_header.php';

$db = new Database();
$message = "";
$product_stmt = $db->query("SELECT id, name FROM products ORDER BY name");
$products = $product_stmt->get_result();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $quantity = (int)$_POST['quantity'];

    $db->query(
        "INSERT INTO product_variants (product_id, color, size, quantity) VALUES (?, ?, ?, ?)",
        "issi",
        [$product_id, $color, $size, $quantity]
    );

    $message = "Variant added successfully.";
}
$query = "
    SELECT pv.id, pv.product_id, p.name AS product_name, pv.color, pv.size, pv.quantity
    FROM product_variants pv
    JOIN products p ON pv.product_id = p.id
    ORDER BY pv.product_id, pv.color, pv.size
";
$result = $db->query($query)->get_result();
?>

    <h2>Manage Product Variants</h2>

<?php if ($message): ?><p style="color: green;"><?= $message ?></p><?php endif; ?>

    <form method="POST" action="">
        <label>Product</label>
        <select name="product_id" required>
            <option value="">Select Product</option>
            <?php while ($row = $products->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <label>Color</label><input type="text" name="color" required><br>
        <label>Size</label><input type="text" name="size" required><br>
        <label>Quantity</label><input type="number" name="quantity" min="0" required><br>

        <button type="submit">Add Variant</button>
    </form>

    <h3>All Variants</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['color']) ?></td>
                <td><?= htmlspecialchars($row['size']) ?></td>
                <td><?= $row['quantity'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

<?php include 'admin_footer.php'; ?>