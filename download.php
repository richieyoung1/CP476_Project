<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="students_file.txt"');


// column titles with fixed widths
printf("%-13s %-20s %-13s %s\n", "Student ID", "Student Name", "Course Code", "Final Grade");
echo str_repeat("-", 60) . "\n";


$sql = "SELECT n.student_id, n.student_name, c.course_code, 
               c.test1, c.test2, c.test3, c.final_exam
        FROM name_table n
        JOIN course_table c ON n.student_id = c.student_id
        ORDER BY n.student_id";

$result = $conn->query($sql);

// output data with alignment
while ($row = $result->fetch_assoc()) {
    $test1 = (float) $row['test1'];
    $test2 = (float) $row['test2'];
    $test3 = (float) $row['test3'];
    $final_exam = (float) $row['final_exam'];

    $final_grade = ($test1 * 0.2) + ($test2 * 0.2) + ($test3 * 0.2) + ($final_exam * 0.4);

    printf(
        "%-13s %-20s %-13s %.1f\n",
        $row['student_id'],
        $row['student_name'],
        $row['course_code'],
        $final_grade
    );
}

$conn->close();
?>
