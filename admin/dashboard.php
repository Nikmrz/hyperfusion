<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: adminlogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<!-- Additional CSS Files -->
<link rel="stylesheet" href="../assets/css/fontawesome.css">
<link rel="stylesheet" href="../assets/css/templatemo-cyborg-gaming.css">
<link rel="stylesheet" href="../assets/css/owl.css">
<link rel="stylesheet" href="../assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
    <h1>Welcome to the Admin Dashboard</h1>
    <div class="gaming-library profile-library">
    <p><a href="insertgame.php">Insert Game</a></p>
</div>
<div class="gaming-library profile-library">
    <p><a href="vieworder.php">View Orders</a></p>
</div>
<div class="gaming-library profile-library">
    <p><a href="viewcomment.php">View Comments</a></p>
</div>
<div class="gaming-library profile-library">
    <p><a href="viewgames.php">View Games</a></p>
</div>
<div class="gaming-library profile-library">
    <p><a href="viewreview.php">View Reviews</a></p>
</div>
<div class="gaming-library profile-library">
    <p><a href="logout.php">Logout</a></p>
</div>
    
    </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
