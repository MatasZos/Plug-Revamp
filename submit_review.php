<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $rating     = (int)$_POST['rating'];
    $comment    = trim($_POST['comment']);
    $email      = $_SESSION['email'];

    if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
        $db = new Database();
        $stmt = $db->query(
            "INSERT INTO reviews (product_id, user_email, rating, comment) VALUES (?, ?, ?, ?)",
            "isis",
            [$product_id, $email, $rating, $comment]
        );
    }
    header("Location: product_detail.php?id=" . $product_id);
    exit;
}
?>
