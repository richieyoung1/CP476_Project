<?php include 'navigation_bar.php'; ?>

<?php
session_start();
include 'db_connect.php';

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $course = $_POST['course'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $test3 = $_POST['test3'];
    $final_exam = $_POST['final_exam'];

    // insert into name_table
    $stmt1 = $conn->prepare("INSERT INTO name_table (student_id, student_name) VALUES (?, ?)");
    $stmt1->bind_param("ss", $student_id, $name);
    
    // insert into course_table
    $stmt2 = $conn->prepare("INSERT INTO course_table (student_id, course_code, test1, test2, test3, final_exam) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssdddd", $student_id, $course, $test1, $test2, $test3, $final_exam);

    //check outcome
    if ($stmt1->execute() && $stmt2->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Failed to add student.";
    }
    $stmt1->close();
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .button-container button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn {
            background-color: blue;
            color: white;
        }
        .submit-btn:hover {
            background-color: darkblue;
        }
        .reset-btn {
            background-color: gray;
            color: white;
        }
        .reset-btn:hover {
            background-color: darkgray;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Add Student</h2>

<div class="container">
    <?= $message ?>

    <form action="add_student.php" method="POST">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="course" placeholder="Course Code" required>
        <input type="number" name="test1" placeholder="Test 1 Score" min="0" max="100">
        <input type="number" name="test2" placeholder="Test 2 Score" min="0" max="100">
        <input type="number" name="test3" placeholder="Test 3 Score" min="0" max="100">
        <input type="number" name="final_exam" placeholder="Final Exam Score" min="0" max="100">

        <div class="button-container">
            <button type="submit" class="submit-btn">Add Student</button>
            <button type="reset" class="reset-btn">Reset</button>
        </div>
    </form>
</div>

</body>
</html>
