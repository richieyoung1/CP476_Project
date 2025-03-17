<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "✅ Student deleted successfully! <a href='manage_students.php'>Go back</a>";
    } else {
        echo "❌ Deletion failed.";
    }
} else {
    echo "Invalid ID.";
}
?>
