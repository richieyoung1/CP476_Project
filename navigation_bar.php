
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// Check if a session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>

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
            padding-top: 50px; /* Prevent content from being hidden behind navbar */
        }
        .navbar {
            width: 98%;
            height: 50px;
            background-color: #24292e; /* GitHub dark gray */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background-color: #0366d6; /* GitHub blue */
        }
        .user-info {
            color: white;
            font-weight: bold;
        }
        .logout-btn {
            background: #d73a49;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .logout-btn a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .logout-btn:hover {
            background: #b22234;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="nav-links">
        <a href="dashboard.php">🏠 Home</a>
        <a href="add_student.php">➕ Add Student</a>
        <a href="manage_students.php">📋 Manage Students</a>
        <a href="search_student.php">🔍 Search Students</a>
    </div>
    <div class="user-info">
    👤 <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest" ?> |
    <span class="logout-btn"><a href="logout.php">🚪 Log Out</a></span>
</div>
</div>

</body>
</html>
