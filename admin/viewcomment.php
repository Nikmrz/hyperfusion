<?php
include 'db.php';

$query = "SELECT * FROM game_comments";
$result = mysqli_query($conn, $query);

echo "<h2>Game Comments</h2>";
echo "<table border='1'>";
echo "<tr><th>Comment ID</th><th>Game ID</th><th>User ID</th><th>Comment</th><th>Date</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['game_id']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['comment']}</td>
            <td>{$row['created_at']}</td>
          </tr>";
}
echo "</table>";
?>
<html>
    <head>
           <!-- Bootstrap core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<!-- Additional CSS Files -->
<link rel="stylesheet" href="../assets/css/fontawesome.css">
<link rel="stylesheet" href="../assets/css/templatemo-cyborg-gaming.css">
<link rel="stylesheet" href="../assets/css/owl.css">
<link rel="stylesheet" href="../assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<style>
    table{
        color:white; !important
    }
    td{
        padding:50px;
    }
    th{
        padding:30px;
    }
    </style>
</head>
    </html>