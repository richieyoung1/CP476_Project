<?php include 'navigation_bar.php'; ?>
<?php
session_start();
include 'db_connect.php';

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    die("Invalid student ID.");
}

// fetch student data
$stmt = $conn->prepare("
    SELECT n.student_id, n.student_name, c.course_code, 
           c.test1, c.test2, c.test3, c.final_exam
    FROM name_table n
    JOIN course_table c ON n.student_id = c.student_id
    WHERE n.student_id = ?
");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $test3 = $_POST['test3'];
    $final_exam = $_POST['final_exam'];

    // update name_table
    $stmt1 = $conn->prepare("UPDATE name_table SET student_name=? WHERE student_id=?");
    $stmt1->bind_param("ss", $name, $student_id);

    // update course_table
    $stmt2 = $conn->prepare("UPDATE course_table SET course_code=?, test1=?, test2=?, test3=?, final_exam=? WHERE student_id=?");
    $stmt2->bind_param("sdddds", $course, $test1, $test2, $test3, $final_exam, $student_id);

    if ($stmt1->execute() && $stmt2->execute()) {
        echo "Student updated successfully! <a href='manage_students.php'>Go back</a>";
    } else {
        echo "Update failed.";
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
    <title>Edit Student</title>
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
        .button-container button, .button-container a {
            width: 48%;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .update-btn {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }
        .update-btn:hover {
            background-color: darkblue;
        }
        .cancel-btn {
            background-color: gray;
            color: white;
        }
        .cancel-btn:hover {
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

<h2>Edit Student</h2>

<div class="container">
    <?= $message ?? '' ?>

    <form action="edit_student.php?id=<?= htmlspecialchars($student_id) ?>" method="POST">
        <input type="text" name="name" placeholder="Student Name" value="<?= htmlspecialchars($student['student_name']) ?>" required>
        <input type="text" name="course" placeholder="Course Code" value="<?= htmlspecialchars($student['course_code']) ?>" required>
        <input type="number" name="test1" placeholder="Test 1 Score" min="0" max="100" value="<?= htmlspecialchars($student['test1']) ?>">
        <input type="number" name="test2" placeholder="Test 2 Score" min="0" max="100" value="<?= htmlspecialchars($student['test2']) ?>">
        <input type="number" name="test3" placeholder="Test 3 Score" min="0" max="100" value="<?= htmlspecialchars($student['test3']) ?>">
        <input type="number" name="final_exam" placeholder="Final Exam Score" min="0" max="100" value="<?= htmlspecialchars($student['final_exam']) ?>">

        <div class="button-container">
            <button type="submit" class="update-btn">Update Student</button>
            <a href="manage_students.php" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>