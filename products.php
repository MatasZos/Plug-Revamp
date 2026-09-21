<?php
session_start();
include 'header.php';
include 'db_connect.php';

$db = new Database();

// Get user filters
$category = $_GET['category'] ?? '';
$color = $_GET['color'] ?? '';
$size = $_GET['size'] ?? '';
$query = $_GET['query'] ?? '';

$where = [];
$params = [];
$types = "";

// Search filter
if (!empty($query)) {
    $like = "%" . $query . "%";
    $where[] = "(p.name LIKE ? OR p.description LIKE ?)";
    $params[] = $like;
    $params[] = $like;
    $types .= "ss";
}

// Category filter
if (!empty($category)) {
    $where[] = "p.category = ?";
    $params[] = $category;
    $types .= "s";
}

// Color filter
if (!empty($color)) {
    $where[] = "v.color = ?";
    $params[] = $color;
    $types .= "s";
}

// Size filter
if (!empty($size)) {
    $where[] = "v.size = ?";
    $params[] = $size;
    $types .= "s";
}

// Final product SQL
$sql = "SELECT DISTINCT p.* FROM products p 
        LEFT JOIN product_variants v ON p.id = v.product_id";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY p.id DESC";

$stmt = $db->query($sql, $types, $params);
$products = $stmt->get_result();

// Get all distinct filter values
$categories = $db->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL")->get_result();
$colors = $db->query("SELECT DISTINCT color FROM product_variants WHERE color IS NOT NULL")->get_result();
$sizes = $db->query("SELECT DISTINCT size FROM product_variants WHERE size IS NOT NULL")->get_result();
?>

<link rel="stylesheet" href="css/product.css">

<div class="products-page">
    <h2>
        <?php if (!empty($query)): ?>
            Search results for: "<?= htmlspecialchars($query) ?>"
        <?php else: ?>
            Browse Products
        <?php endif; ?>
    </h2>

    <!-- Filter Form -->
    <form method="get" class="filter-form">
        <label>Category</label>
        <select name="category">
            <option value="">All Categories</option>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <option value="<?= $row['category'] ?>" <?= $category === $row['category'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['category']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Color</label>
        <select name="color">
            <option value="">All Colors</option>
            <?php while ($row = $colors->fetch_assoc()): ?>
                <option value="<?= $row['color'] ?>" <?= $color === $row['color'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['color']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Size</label>
        <select name="size">
            <option value="">All Sizes</option>
            <?php while ($row = $sizes->fetch_assoc()): ?>
                <option value="<?= $row['size'] ?>" <?= $size === $row['size'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['size']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="hidden" name="query" value="<?= htmlspecialchars($query) ?>">
        <button type="submit">Apply Filters</button>
    </form>

    <!-- Product Grid -->
    <div class="product-grid">
        <?php if ($products->num_rows === 0): ?>
            <p class="no-results">No products found.</p>
        <?php else: ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <a href="product_detail.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                    </a>
                    <p class="price">€<?= number_format($product['price'], 2) ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
