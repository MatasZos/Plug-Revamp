<?php
session_start();
include 'header.php';
include 'db_connect.php';

$db = new Database();
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    echo "<p style='text-align:center;'>Product not found.</p>";
    include 'footer.php';
    exit;
}

// Get product
$stmt = $db->query("SELECT * FROM products WHERE id = ?", "i", [$product_id]);
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "<p style='text-align:center;'>Product not found.</p>";
    include 'footer.php';
    exit;
}

// Get variants
$variants = $db->query(
    "SELECT color, size, quantity FROM product_variants WHERE product_id = ?",
    "i",
    [$product_id]
)->get_result();

// Handle review submission
if (isset($_POST['submit_review']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    $db->query(
        "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)",
        "iiis",
        [$product_id, $userId, $rating, $comment]
    );

    header("Location: product_detail.php?id=" . $product_id);
    exit;
}
?>

<link rel="stylesheet" href="css/product_detail.css">

<div class="product-detail">
    <div class="product-image">
        <img src="<?= $product['image_url'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="product-info">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p class="price">€<?= number_format($product['price'], 2) ?></p>
        <p class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <form action="cart.php" method="post" class="variant-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

            <label>Color</label>
            <select name="color" required>
                <option value="">Select Color</option>
                <?php
                $colors = [];
                foreach ($variants as $variant) {
                    if (!in_array($variant['color'], $colors)) {
                        $colors[] = $variant['color'];
                        echo "<option value=\"{$variant['color']}\">{$variant['color']}</option>";
                    }
                }
                ?>
            </select>

            <label>Size</label>
            <select name="size" required>
                <option value="">Select Size</option>
                <?php
                $sizes = [];
                foreach ($variants as $variant) {
                    if (!in_array($variant['size'], $sizes)) {
                        $sizes[] = $variant['size'];
                        echo "<option value=\"{$variant['size']}\">{$variant['size']}</option>";
                    }
                }
                ?>
            </select>

            <button type="submit">Add to Cart</button>
        </form>
    </div>

    <div class="product-reviews">
        <h2>Reviews</h2>

        <?php
        $reviewStmt = $db->query(
            "SELECT r.*, u.email 
             FROM reviews r
             JOIN users u ON r.user_id = u.id
             WHERE r.product_id = ?
             ORDER BY r.created_at DESC",
            "i",
            [$product_id]
        );
        $reviews = $reviewStmt->get_result();

        if ($reviews->num_rows === 0): ?>
            <p>No reviews yet. Be the first to review this product!</p>
        <?php else: ?>
            <?php while ($review = $reviews->fetch_assoc()): ?>
                <div class="review">
                    <strong><?= htmlspecialchars($review['email']) ?></strong>
                    <span class="stars">
                        <?= str_repeat("⭐", intval($review['rating'])) ?>
                    </span>
                    <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                    <small><?= date("F j, Y", strtotime($review['created_at'])) ?></small>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="submit-review">
                <h3>Leave a Review</h3>
                <form action="" method="post">
                    <label>Rating:</label>
                    <select name="rating" required>
                        <option value="">Select stars</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                        <?php endfor; ?>
                    </select>

                    <label>Comment:</label>
                    <textarea name="comment" rows="4" placeholder="Write your thoughts..."></textarea>

                    <button type="submit" name="submit_review">Submit Review</button>
                </form>
            </div>
        <?php else: ?>
            <p><a href="sign_in.php">Sign in</a> to leave a review.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
