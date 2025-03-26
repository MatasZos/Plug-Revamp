<?php
session_start();
include 'db_connect.php';
include 'header.php';

$db = new Database();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->query("SELECT * FROM users WHERE email = ?", "s", [$email]);
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = $user['is_admin'] == 1;

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<link rel="stylesheet" href="css/signin.css">

<div class="signin-container">
    <h2>Sign In</h2>
    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <div class="link">
        <p>Don't have an account? <a href="sign_up.php">Register here</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
