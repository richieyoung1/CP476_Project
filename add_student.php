<?php include 'navigation_bar.php'; ?>

<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $course = $_POST['course'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $test3 = $_POST['test3'];
    $final_exam = $_POST['final_exam'];

    // Insert into name_table
    $stmt1 = $conn->prepare("INSERT INTO name_table (student_id, student_name) VALUES (?, ?)");
    $stmt1->bind_param("ss", $student_id, $name);
    
    // Insert into course_table
    $stmt2 = $conn->prepare("INSERT INTO course_table (student_id, course_code, test1, test2, test3, final_exam) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssdddd", $student_id, $course, $test1, $test2, $test3, $final_exam);

    if ($stmt1->execute() && $stmt2->execute()) {
        echo "Student added successfully! <a href='manage_students.php'>Go back</a>";
    } else {
        echo "Failed to add student.";
    }
    $stmt1->close();
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        
        <label>Student ID:</label>
        <input type="text" name="student_id" required><br>

        <label>Course:</label>
        <input type="text" name="course" required><br>

        <label>Test 1:</label>
        <input type="number" step="1.0" name="test1" required><br>

        <label>Test 2:</label>
        <input type="number" step="1.0" name="test2" required><br>

        <label>Test 3:</label>
        <input type="number" step="1.0" name="test3" required><br>

        <label>Final Exam:</label>
        <input type="number" step="1.0" name="final_exam" required><br>

        <button type="submit">Add Student</button>
    </form>
</body>
</html>
