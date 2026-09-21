<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<link rel="stylesheet" href="css/style.css">
<script src="js/nav.js" defer></script>

<nav class="navbar">
    <div class="nav-logo">
        <a href="index.php">The Plug</a>
    </div>

    <div class="nav-search">
        <form action="products.php" method="get">
            <input type="text" name="query" placeholder="Search products..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="nav-profile">
            <img src="images/profile.png" alt="Profile" onclick="toggleDropdown()">
            <div class="dropdown-content" id="dropdown">
                <a href="cart.php">Cart</a>
                <a href="order_history.php">My Orders</a>
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="admin/admin_dashboard.php">Admin Dashboard</a>
                <?php endif; ?>
                <a href="sign_out.php">Sign Out</a>
            </div>
        </div>
    <?php else: ?>
        <div class="nav-profile">
            <img src="images/profile.png" alt="Profile" onclick="toggleDropdown()">
            <div class="dropdown-content" id="dropdown">
                <a href="sign_in.php">Sign In</a>
                <a href="sign_up.php">Register</a>
            </div>
        </div>
    <?php endif; ?>
</nav>
