<?php
include 'header.php';
session_start();
?>

<link rel="stylesheet" href="signup.css">

<div class="signup-section">
    <h2>Successfully Signed Up</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</p>
    <a href="index.php" class="btn">Go to Homepage</a>
</div>

<?php include 'footer.php'; ?>
