<?php
session_start();
include 'db_connect.php';
include 'header.php';

$db = new Database();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $db->query("SELECT * FROM users WHERE email = ?", "s", [$email])->get_result();
    if ($check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $db->query("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 0)", "sss", [$name, $email, $password]);

        $user_id = $db->query("SELECT LAST_INSERT_ID()")->get_result()->fetch_row()[0];
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = 0;

        header("Location: signup_success.php");
        exit;
    }
}
?>

<link rel="stylesheet" href="css/signup.css">

<div class="signup-container">
    <h2>Sign Up</h2>
    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <div class="link">
        <p>Already have an account? <a href="sign_in.php">Sign in</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
