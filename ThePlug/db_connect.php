<?php
class Database {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "theplug_db";
        $port       = 3307;

        $this->conn = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $types = "", $params = []) {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }

    public function close() {
        $this->conn->close();
    }
}
