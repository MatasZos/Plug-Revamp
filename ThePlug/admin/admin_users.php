<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}
include '../db_connect.php';
include 'admin_header.php';
$db = new Database();
$users = $db->query("SELECT id, email, is_admin FROM users ORDER BY id DESC")->get_result();
?>

<h1>Registered Users</h1>
<table class="admin-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Admin</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include 'admin_footer.php'; ?>
