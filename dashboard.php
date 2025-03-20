<?php include 'navigation_bar.php'; ?>

<?php
session_start();
include 'db_connect.php';

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// get total students
$total_students_query = "SELECT COUNT(*) AS total_students FROM name_table";
$total_students_result = $conn->query($total_students_query);
$total_students = $total_students_result->fetch_assoc()['total_students'];

// get total courses
$total_courses_query = "SELECT COUNT(DISTINCT course_code) AS total_courses FROM course_table";
$total_courses_result = $conn->query($total_courses_query);
$total_courses = $total_courses_result->fetch_assoc()['total_courses'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .dashboard-container {
            display: flex;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
        }
        .card h2 {
            margin: 0;
            color: blue;
        }
    </style>
</head>
<body>

<?php include 'navigation_bar.php'; ?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>

<div class="dashboard-container">
    <div class="card">
        <h2>Total Students</h2>
        <p><?= $total_students ?></p>
    </div>
    <div class="card">
        <h2>Total Courses</h2>
        <p><?= $total_courses ?></p>
    </div>
</div>

</body>
</html>
