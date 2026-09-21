<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "<p>Access denied. Admins only.</p>";
    exit;
}
include '../db_connect.php';
include 'admin_header.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $image_url = $_POST["image_url"];

    $db->query(
        "INSERT INTO products (name, price, category, description, image_url) VALUES (?, ?, ?, ?, ?)",
        "sdsss",
        [$name, $price, $category, $description, $image_url]
    );

    echo "<p>Product inserted successfully.</p>";
}
?>

<h2>Add Product</h2>
<form method="POST">
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Price (€):</label><input type="number" step="0.01" name="price" required><br>
    <label>Category:</label><input type="text" name="category" required><br>
    <label>Description:</label><textarea name="description" required></textarea><br>
    <label>Image URL:</label><input type="text" name="image_url" required><br>
    <button type="submit">Add Product</button>
</form>

<?php include 'admin_footer.php'; ?>
