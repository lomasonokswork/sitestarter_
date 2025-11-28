<?php
session_start();
$userId = $_SESSION['user_id'];

$dbPath = __DIR__ . '/user_auth.db';
try {
    $conn = new PDO('sqlite:' . $dbPath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $userId, PDO::PARAM_INT);

if ($stmt->execute()) {
    session_destroy();
    echo "Account deleted successfully.";
    header("Location: login.php");
} else {
    echo "Error deleting account.";
}

$stmt = null;
$conn = null;
?>