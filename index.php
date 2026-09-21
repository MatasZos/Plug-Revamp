<?php
session_start();
include 'header.php';
?>

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/style.css">
<main>
    <section class="product-gallery">
        <div class="products">
            <?php
            $products = [
                ["id" => 8, "name" => "Air Jordan 4 Fear", "price" => 289, "image" => "images/jordan4fear.png"],
                ["id" => 9, "name" => "Dior Snow Derby", "price" => 1300, "image" => "images/hamilton.png"],
                ["id" => 10, "name" => "Spider-Man Jordan 1", "price" => 120, "image" => "images/j1spider.png"],
                ["id" => 11, "name" => "Denim Tears Wreath", "price" => 300, "image" => "images/wreath.png"]
            ];
            foreach ($products as $product): ?>
                <a href="product_detail.php?id=<?= $product['id'] ?>" class="product-item">
                    <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="price">€<?= number_format($product['price'], 2) ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="view-more-button">
            <a href="products.php">View Other Products</a>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>
