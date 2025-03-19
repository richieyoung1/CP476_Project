<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px;
            display: flex;
            justify-content: space-around;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="navigation_bar">
        <a href="dashboard.php"> Home</a>
        <a href="add_student.php">Add Student</a>
        <a href="manage_students.php"> Manage Students</a>
        <a href="search_student.php"> Search Student</a>
        <a href="calculate_grades.php"> Calculate Grades</a>
        <a href="logout.php"> Logout</a>
    </div>
</body>
</html>
