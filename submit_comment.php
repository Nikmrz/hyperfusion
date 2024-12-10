<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hyperfusion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to comment.");
}

$user_id = $_SESSION['user_id'];
$game_id = intval($_POST['game_id']);
$comment = trim($_POST['comment']);

// Validate input
if (empty($comment)) {
    die("Comment cannot be empty.");
}

$sql = "INSERT INTO game_comments (game_id, user_id, comment) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $game_id, $user_id, $comment);

if ($stmt->execute()) {
    header("Location:details.php?id=" . $game_id);
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
