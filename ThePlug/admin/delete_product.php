<?php
include_once '../require_admin.php';
include_once '../db_connect.php';
session_start();
$db = new Database();
$id = $_GET['id'] ?? null;
if ($id) {
    $db->query("DELETE FROM products WHERE id = ?", "i", [$id]);
}

header("Location: admin_products.php");
exit;
