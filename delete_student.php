<?php
session_start();
include 'db_connect.php';
include 'navigation_bar.php';

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// get the student ID from the URL
$student_id = $_GET['delete_id'] ?? null;


if ($student_id) {
    // delete from course_table first (to avoid foreign key constraint issues)
    $stmt1 = $conn->prepare("DELETE FROM course_table WHERE student_id = ?");
    $stmt1->bind_param("s", $student_id);
    $stmt1->execute();

    // delete from name_table
    $stmt2 = $conn->prepare("DELETE FROM name_table WHERE student_id = ?");
    $stmt2->bind_param("s", $student_id);
    $stmt2->execute();

    if ($stmt1->affected_rows > 0 || $stmt2->affected_rows > 0) {
        echo "Student deleted! <a href='manage_students.php'>Go back</a>";
    } else {
        echo "Deletion failed. Student may not exist.";
    }

    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>
