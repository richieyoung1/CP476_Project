<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "Richie30";      // Enter your MySQL root password
$database = "cp476_project_db";

// create connection
$conn = new mysqli($servername, $username, $password, $database);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
