<?php
$dbPath = __DIR__ . '/user_auth.db';

try {
    $conn = new PDO('sqlite:' . $dbPath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tableExists = $conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'")->fetch();
    
    if (!$tableExists) {
        $conn->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    
} catch (PDOException $e) {
    die("Error initializing database: " . $e->getMessage());
}
?>