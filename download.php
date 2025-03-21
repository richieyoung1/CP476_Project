<?php
session_start();
include 'db_connect.php';

// Only allow logged in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set headers to force text file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="student_report.txt"');

// Fetch data from joined tables
$sql = "SELECT n.student_id, n.student_name, c.course_code, 
               c.test1, c.test2, c.test3, c.final_exam
        FROM name_table n
        JOIN course_table c ON n.student_id = c.student_id
        ORDER BY n.student_id";

$result = $conn->query($sql);

// Print formatted data (similar to Appendix B)
echo "STUDENT RECORD REPORT\n";
echo "======================\n\n";

while ($row = $result->fetch_assoc()) {
    echo "Student ID: " . $row['student_id'] . "\n";
    echo "Name: " . $row['student_name'] . "\n";
    echo "Course: " . $row['course_code'] . "\n";
    echo "Test 1: " . $row['test1'] . "\n";
    echo "Test 2: " . $row['test2'] . "\n";
    echo "Test 3: " . $row['test3'] . "\n";
    echo "Final Exam: " . $row['final_exam'] . "\n";
    echo "------------------------------\n";
}

$conn->close();
?>
