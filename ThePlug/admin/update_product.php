<?php
include_once '../require_admin.php';

include_once '../db_connect.php';
include_once '../header.php';
session_start();

$db = new Database();
$id = $_GET['id'] ?? null;
if (!$id) { echo "No product ID"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $size  = $_POST['size'];
    $avail = isset($_POST['availability']) ? 1 : 0;
    $img   = $_POST['image_url'];

    $db->query(
        "UPDATE products SET name=?, description=?, price=?, brand=?, size=?, availability=?, image_url=? WHERE id=?",
        "ssdsissi",
        [$name, $desc, $price, $brand, $size, $avail, $img, $id]
    );

    header("Location: admin_products.php");
    exit;
}

$stmt = $db->query("SELECT * FROM products WHERE id = ?", "i", [$id]);
$product = $stmt->get_result()->fetch_assoc();
?>

<link rel="stylesheet" href="../admin.css">

<div class="admin-main" style="padding: 40px;">
    <h2>Edit Product</h2>
    <form method="POST">
        <label>Name:</label><input type="text" name="name" value="<?= $product['name'] ?>" required><br>
        <label>Description:</label><textarea name="description" required><?= $product['description'] ?></textarea><br>
        <label>Price (€):</label><input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required><br>
        <label>Brand:</label><input type="text" name="brand" value="<?= $product['brand'] ?>" required><br>
        <label>Size:</label><input type="text" name="size" value="<?= $product['size'] ?>" required><br>
        <label>Availability:</label><input type="checkbox" name="availability" <?= $product['availability'] ? 'checked' : '' ?>><br>
        <label>Image URL:</label><input type="text" name="image_url" value="<?= $product['image_url'] ?>" required><br>
        <button type="submit">Update Product</button>
    </form>
</div>

<?php include_once '../footer.php'; ?>
