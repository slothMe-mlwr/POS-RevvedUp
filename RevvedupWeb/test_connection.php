<?php
require_once __DIR__ . '/controller/config.php';
require_once __DIR__ . '/controller/class.php';

$db = new db_connect();
$db->connect();

if ($db->conn) {
    echo "✅ Database connected successfully to: " . DB_NAME;
} else {
    echo "❌ Connection failed!";
}
?>
