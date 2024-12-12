<?php
include 'db.php';

$query = "SELECT * FROM `orders`";
$result = mysqli_query($conn, $query);

echo "<h2>Orders</h2>";
echo "<table border='1'>";
echo "<tr><th>Order ID</th><th>user id</th><th>Total Amount</th><th>Status</th><th>Order Date</th><th>place</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['total_amount']}</td>
            <td>{$row['payment_status']}</td>
            <td>{$row['order_date']}</td>
            <td>{$row['place']}</td>
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
