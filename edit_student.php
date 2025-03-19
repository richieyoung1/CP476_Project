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
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $student['student_name']; ?>" required><br>

        <label>Course:</label>
        <input type="text" name="course" value="<?php echo $student['course_code']; ?>" required><br>

        <label>Test 1:</label>
        <input type="number" step="1.0" name="test1" value="<?php echo $student['test1']; ?>" required><br>

        <label>Test 2:</label>
        <input type="number" step="1.0" name="test2" value="<?php echo $student['test2']; ?>" required><br>

        <label>Test 3:</label>
        <input type="number" step="1.0" name="test3" value="<?php echo $student['test3']; ?>" required><br>

        <label>Final Exam:</label>
        <input type="number" step="1.0" name="final_exam" value="<?php echo $student['final_exam']; ?>" required><br>

        <button type="submit">Update Student</button>
    </form>
</body>
</html>
