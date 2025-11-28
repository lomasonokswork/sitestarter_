<?php
$dbPath = __DIR__ . '/user_auth.db';

try {
    $conn = new PDO('sqlite:' . $dbPath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

require_once __DIR__ . '/initialise_db.php';
?>