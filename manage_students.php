<?php include 'navigation_bar.php'; ?>
<?php
session_start();
include 'db_connect.php';

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// fetch all students and join with courses
$result = $conn->query("
    SELECT n.student_id, n.student_name, c.course_code, 
           c.test1, c.test2, c.test3, c.final_exam
    FROM name_table n
    JOIN course_table c ON n.student_id = c.student_id
");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #0366d6;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: green;
        }
        .edit-btn:hover {
            background-color: darkgreen;
        }
        .delete-btn {
            background-color: red;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Manage Students</h2>

<div class="container">
    <table>
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
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['course_code']) ?></td>
            <td><?= $row['test1'] !== null ? htmlspecialchars($row['test1']) : 'N/A' ?></td>
            <td><?= $row['test2'] !== null ? htmlspecialchars($row['test2']) : 'N/A' ?></td>
            <td><?= $row['test3'] !== null ? htmlspecialchars($row['test3']) : 'N/A' ?></td>
            <td><?= $row['final_exam'] !== null ? htmlspecialchars($row['final_exam']) : 'N/A' ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['student_id'] ?>" class="action-btn edit-btn">✏ Edit</a>
                <a href="manage_students.php?delete_id=<?= $row['student_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">🗑 Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>