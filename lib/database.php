<?php
class Database {
    private $host     = "localhost";
    private $username = "root";
    private $password = "Root@123Pass";
    private $database = "users_db";
    private $conn;

    function __construct() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    function getConnection() {
        return $this->conn;
    }

    function closeConnection() {
        return $this->conn->close();
    }
}
