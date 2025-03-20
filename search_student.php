<?php include 'navigation_bar.php'; ?>
<?php
include 'db_connect.php'; // db connection

// select available courses for the dropdown
$courseQuery = "SELECT DISTINCT course_code FROM course_table";
$courseResult = $conn->query($courseQuery);

// get search parameters
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students</title>
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
        .search-bar {
            margin-bottom: 20px;
            text-align: center;
        }
        input, select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 8px 15px;
            background-color: #0366d6;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #024ea2;
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
    </style>
</head>
<body>

<h2 style="text-align:center;">Search Students</h2>

<div class="container">
    <!-- Search Form -->
    <form method="GET" action="search_student.php" class="search-bar">
        <input type="text" name="query" placeholder="Search by Student ID or Name..." value="<?= htmlspecialchars($searchQuery) ?>">
        <select name="course">
            <option value="">All Courses</option>
            <?php while ($row = $courseResult->fetch_assoc()): ?>
                <option value="<?= $row['course_code'] ?>" <?= ($selectedCourse == $row['course_code']) ? 'selected' : '' ?>>
                    <?= $row['course_code'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit"> Search</button>
    </form>

    <!-- Results Table -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Test 1</th>
            <th>Test 2</th>
            <th>Test 3</th>
            <th>Final Exam</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['course_code'] ?? 'N/A') ?></td>
            <td><?= $row['test1'] !== null ? htmlspecialchars($row['test1']) : 'N/A' ?></td>
            <td><?= $row['test2'] !== null ? htmlspecialchars($row['test2']) : 'N/A' ?></td>
            <td><?= $row['test3'] !== null ? htmlspecialchars($row['test3']) : 'N/A' ?></td>
            <td><?= $row['final_exam'] !== null ? htmlspecialchars($row['final_exam']) : 'N/A' ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
