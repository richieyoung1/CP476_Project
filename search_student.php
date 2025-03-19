<?php
include 'db_connect.php'; // Ensure database connection is included

// Fetch available courses for the dropdown
$courseQuery = "SELECT DISTINCT course_code FROM course_table";
$courseResult = $conn->query($courseQuery);

// Get search parameters
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
$selectedCourse = isset($_GET['course']) ? trim($_GET['course']) : '';

$sql = "
    SELECT n.student_id, n.student_name, c.course_code, c.test1, c.test2, c.test3, c.final_exam 
    FROM name_table n
    LEFT JOIN course_table c ON n.student_id = c.student_id
    WHERE (n.student_id LIKE ? OR n.student_name LIKE ?)";
    
if (!empty($selectedCourse)) {
    $sql .= " AND c.course_code = ?";
}

$stmt = $conn->prepare($sql);
$likeQuery = "%$searchQuery%";

if (!empty($selectedCourse)) {
    $stmt->bind_param("sss", $likeQuery, $likeQuery, $selectedCourse);
} else {
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Student</title>
</head>
<body>
    <h2>Search for a Student</h2>
    <form method="GET" action="">
        <input type="text" name="query" placeholder="Enter Student ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <select name="course">
            <option value="">All Courses</option>
            <?php while ($courseRow = $courseResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($courseRow['course_code']); ?>" 
                    <?php echo ($selectedCourse == $courseRow['course_code']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($courseRow['course_code']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Search</button>
    </form>

    <?php if ($result !== null): ?>
        <h3>Results:</h3>
        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Test 1</th>
                    <th>Test 2</th>
                    <th>Test 3</th>
                    <th>Final Exam</th>
                    <th>Final Grade</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['test1']); ?></td>
                        <td><?php echo htmlspecialchars($row['test2']); ?></td>
                        <td><?php echo htmlspecialchars($row['test3']); ?></td>
                        <td><?php echo htmlspecialchars($row['final_exam']); ?></td>
                        <td>
                            <?php
                            // Calculate final grade based on formula
                            $finalGrade = ($row['test1'] * 0.20) + ($row['test2'] * 0.20) + ($row['test3'] * 0.20) + ($row['final_exam'] * 0.40);
                            echo round($finalGrade, 2); // Display final grade rounded to 2 decimal places
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No student found.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
