<?php
session_start();
include 'db_connect.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all students
$result = $conn->query("
    SELECT n.student_id, n.student_name, c.course_code, 
           c.test1, c.test2, c.test3, c.final_exam
    FROM name_table n
    JOIN course_table c ON n.student_id = c.student_id
");


?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
</head>
<body>
    <h2>Student Management</h2>
    <a href="add_student.php">➕ Add New Student</a>
    <a href="calculate_grades.php">📊 Calculate Final Grades</a>

    <br><br>


    <table border="1">
    <tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Course</th>
    <th>Test 1</th>
    <th>Test 2</th>
    <th>Test 3</th>
    <th>Final Exam</th>
    <th>Actions</th>
</tr>
<?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['student_id']; ?></td>
        <td><?php echo $row['student_name']; ?></td>
        <td><?php echo $row['course_code']; ?></td>
        <td><?php echo $row['test1']; ?></td>
        <td><?php echo $row['test2']; ?></td>
        <td><?php echo $row['test3']; ?></td>
        <td><?php echo $row['final_exam']; ?></td>
        <td>
            <a href="edit_student.php?id=<?php echo $row['student_id']; ?>">✏ Edit</a> | 
            <a href="delete_student.php?id=<?php echo $row['student_id']; ?>" onclick="return confirm('Are you sure?');">🗑 Delete</a>
        </td>
    </tr>
<?php } ?>
    </table>
</body>
</html>
