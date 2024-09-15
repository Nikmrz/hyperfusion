<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hyperfusion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch price
$sql = "SELECT price FROM gamedetails WHERE id = 1"; // Replace with your actual condition
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['price' => $row['price']]);
} else {
    echo json_encode(['price' => 0]);
}

$conn->close();
?>
