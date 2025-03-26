<?php
require_once 'Product.php';
require_once 'ProductVariant.php';

class ProductManager {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image_url'],
                $row['category']
            );
        }
        return $products;
    }

    public function getProductById($id) {
        $stmt = $this->db->query("SELECT * FROM products WHERE id = ?", "i", [$id]);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return new Product(
            $row['id'],
            $row['name'],
            $row['price'],
            $row['description'],
            $row['image_url'],
            $row['category']
        );
    }

    public function addProduct($name, $price, $description, $image_url, $category) {
        $this->db->query(
            "INSERT INTO products (name, price, description, image_url, category) VALUES (?, ?, ?, ?, ?)",
            "sdsss",
            [$name, $price, $description, $image_url, $category]
        );
    }

    public function updateProduct($id, $name, $price, $description, $image_url, $category) {
        $this->db->query(
            "UPDATE products SET name = ?, price = ?, description = ?, image_url = ?, category = ? WHERE id = ?",
            "sdsssi",
            [$name, $price, $description, $image_url, $category, $id]
        );
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM product_variants WHERE product_id = ?", "i", [$id]);
        $this->db->query("DELETE FROM products WHERE id = ?", "i", [$id]);
    }

    public function addVariant($product_id, $color, $size, $quantity) {
        $this->db->query(
            "INSERT INTO product_variants (product_id, color, size, quantity) VALUES (?, ?, ?, ?)",
            "isss",
            [$product_id, $color, $size, $quantity]
        );
    }

    public function getVariantsByProduct($productId) {
        $stmt = $this->db->query(
            "SELECT * FROM product_variants WHERE product_id = ?",
            "i",
            [$productId]
        );
        $result = $stmt->get_result();

        $variants = [];
        $product = $this->getProductById($productId);

        while ($row = $result->fetch_assoc()) {
            $variants[] = new ProductVariant(
                $product,
                $row['color'],
                $row['size'],
                $row['quantity']
            );
        }

        return $variants;
    }
}