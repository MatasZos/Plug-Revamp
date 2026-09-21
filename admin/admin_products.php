<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}
require_once '../db_connect.php';
require_once '../classes/Product.php';
require_once '../classes/ProductVariant.php';
require_once '../classes/ProductManager.php';
include 'admin_header.php';
$db = new Database();
$productManager = new ProductManager($db);
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_product'])) {
    $productManager->addProduct(
        $_POST['name'],
        $_POST['price'],
        $_POST['description'],
        $_POST['image_url'],
        $_POST['category']
    );
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_variant'])) {
    $productManager->addVariant(
        $_POST['product_id'],
        $_POST['color'],
        $_POST['size'],
        $_POST['quantity']
    );
}
if (isset($_GET['delete'])) {
    $productManager->deleteProduct($_GET['delete']);
    header("Location: admin_products.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_product'])) {
    $productManager->updateProduct(
        $_POST['id'],
        $_POST['name'],
        $_POST['price'],
        $_POST['description'],
        $_POST['image_url'],
        $_POST['category']
    );
}
$products = $productManager->getAllProducts();
?>
<h1>Manage Products</h1>
<h2>Add New Product</h2>
<form method="post" class="admin-form">
    <input type="hidden" name="add_product" value="1">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" step="0.01" name="price" placeholder="Price (€)" required>
    <input type="text" name="image_url" placeholder="Image URL" required>
    <input type="text" name="category" placeholder="Category" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <button type="submit">Add Product</button>
</form>

<h2>All Products</h2>
<?php foreach ($products as $product): ?>
    <div class="admin-product-box">
        <h3><?= htmlspecialchars($product->name) ?> (€<?= $product->price ?>)</h3>
        <p><strong>Category:</strong> <?= htmlspecialchars($product->category) ?></p>
        <p><?= htmlspecialchars($product->description) ?></p>
        <img src="<?= htmlspecialchars($product->image_url) ?>" width="120">
        <p>
            <a href="?delete=<?= $product->id ?>" onclick="return confirm('Delete this product?')" style="color:red;">Delete Product</a>
        </p>
        <details>
            <summary style="cursor:pointer;">Edit Product</summary>
            <form method="post" class="admin-form">
                <input type="hidden" name="edit_product" value="1">
                <input type="hidden" name="id" value="<?= $product->id ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($product->name) ?>" required>
                <input type="number" step="0.01" name="price" value="<?= $product->price ?>" required>
                <input type="text" name="image_url" value="<?= htmlspecialchars($product->image_url) ?>" required>
                <input type="text" name="category" value="<?= htmlspecialchars($product->category) ?>" required>
                <textarea name="description" required><?= htmlspecialchars($product->description) ?></textarea>
                <button type="submit">Update Product</button>
            </form>
        </details>
        <h4>Add Variant</h4>
        <form method="post" class="variant-form">
            <input type="hidden" name="add_variant" value="1">
            <input type="hidden" name="product_id" value="<?= $product->id ?>">
            <input type="text" name="color" placeholder="Color" required>
            <input type="text" name="size" placeholder="Size" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <button type="submit">Add Variant</button>
        </form>

        <!-- View Variants -->
        <?php
        $variants = $productManager->getVariantsByProduct($product->id);
        ?>
        <?php if (!empty($variants)): ?>
            <h5>Variants:</h5>
            <ul>
                <?php foreach ($variants as $variant): ?>
                    <li><?= $variant->color ?> | <?= $variant->size ?> | Stock: <?= $variant->quantity ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php include 'admin_footer.php'; ?>
