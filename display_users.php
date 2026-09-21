<?php
include 'db_connect.php'; // Connect to the database

$sql = "SELECT user_id, name, email, role, created_at FROM users";
$result = $conn->query($sql);

echo "<h2>Users in ThePlug Database</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created At</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["user_id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["role"]."</td>
                <td>".$row["created_at"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

$conn->close();
?>
