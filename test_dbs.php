<?php
$servername = "localhost";
$username = "root";
$password = "Richie30";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully to MySQL!";
?>
