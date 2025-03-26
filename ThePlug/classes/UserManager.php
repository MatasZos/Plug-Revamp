<?php
require_once 'User.php';
require_once 'Database.php';

class UserManager {
private $db;

public function __construct(Database $db) {
$this->db = $db;
}

public function getAllUsers() {
$stmt = $this->db->query("SELECT * FROM users");
$users = [];
while ($row = $stmt->get_result()->fetch_assoc()) {
$users[] = new User($row['id'], $row['email'], $row['is_admin']);
}
return $users;
}

public function getUserByEmail($email) {
$stmt = $this->db->query("SELECT * FROM users WHERE email = ?", "s", [$email]);
$row = $stmt->get_result()->fetch_assoc();
return new User($row['id'], $row['email'], $row['is_admin']);
}
}
