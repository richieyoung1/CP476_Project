<?php include 'navigation_bar.php'; ?>

<?php
session_start();

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";
echo "<a href='logout.php'>Logout</a>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    
    <a href="manage_students.php">
        <button> Manage Students</button>
    </a>

    <a href="logout.php">
        <button> Logout</button>
    </a>
    <a href="search_student.php">
    <button> Search Students</button>
</a>

</body>
</html>
