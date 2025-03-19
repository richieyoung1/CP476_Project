<?php include 'navigation_bar.php'; ?>
<?php
session_start();
include 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch student data with their grades
$sql = "
    SELECT n.student_id, n.student_name, c.course_code, 
           c.test1, c.test2, c.test3, c.final_exam
    FROM name_table n
    JOIN course_table c ON n.student_id = c.student_id
    ORDER BY n.student_id ASC
";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Final Grade Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Final Grade Report</h2>
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Course Code</th>
            <th>Final Grade</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
            // Calculate final grade
            $final_grade = ($row['test1'] * 0.20) + 
                           ($row['test2'] * 0.20) + 
                           ($row['test3'] * 0.20) + 
                           ($row['final_exam'] * 0.40);
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                <td><?php echo number_format($final_grade, 1); ?></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="manage_students.php"> Back to Student Management</a>
</body>
</html>
