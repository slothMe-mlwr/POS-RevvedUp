<?php
// Prevent redefinition
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'hnyjnmrl0207.MYSQL');
if (!defined('DB_NAME')) define('DB_NAME', 'tryrevvedup');

class db_connect {
    public $conn;

    public function connect() {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die("⚠️ " . $e->getMessage());
        }
    }
}
?>
