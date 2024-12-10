<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Fetch the logged-in user's information
$user_id = $_SESSION['user_id'];
$query = mysqli_prepare($con, "SELECT username, email, number, created_at, profile_pic FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["profile_pic"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if uploads directory exists
    if (!file_exists($targetDir)) {
        echo "<script>alert('Upload directory does not exist. Please create a folder named \"uploads\".');</script>";
        exit();
    }

    // Allow only certain file formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (in_array($fileType, $allowedTypes)) {
        // Check for upload errors
        if ($_FILES["profile_pic"]["error"] === UPLOAD_ERR_OK) {
            // Upload file to server
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
                // Update profile_pic path in the database
                $updateQuery = mysqli_prepare($con, "UPDATE users SET profile_pic = ? WHERE id = ?");
                mysqli_stmt_bind_param($updateQuery, "si", $targetFilePath, $user_id);
                if (mysqli_stmt_execute($updateQuery)) {
                    echo "<script>alert('Profile picture updated successfully!'); window.location.href = 'profile.php';</script>";
                } else {
                    echo "<script>alert('Database update failed.');</script>";
                }
            } else {
                echo "<script>alert('File upload failed. Check permissions for the \"uploads\" folder.');</script>";
            }
        } else {
            echo "<script>alert('File upload error: " . $_FILES["profile_pic"]["error"] . "');</script>";
        }
    } else {
        echo "<script>alert('Only JPG, JPEG, PNG, & GIF files are allowed.');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>HYPER FUSION</title>
<!-- Additional CSS Files -->
<link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
 body {
  background-color: #1e1e1e !important;
}

.profile-picture {
    width: 270px; /* Fixed width */
    height: 270px; /* Fixed height */
    border-radius: 50%; /* Makes it circular */
    object-fit: cover; /* Ensures the image scales proportionally without distortion */
    border: 2px solid #fff; /* Optional: Adds a border for aesthetics */
}

  </style>
  </head>

<body>

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <img src="assets/images/newlogo.png" alt="">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Search Start ***** -->
                        <div class="search-input">
                            <form id="search" action="#">
                                <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                                <i class="fa fa-search"></i>
                            </form>
                        </div>
                        <!-- ***** Search End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="browse.php">Browse</a></li>
                            <li><a href="streams.php">Streams</a></li>
                            <li><a href="profile.php" class="active">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                        </ul>   
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

  
                    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-profile">
                            <div class="row">
                                <div class="col-lg-4">
                                <img src="<?= $user['profile_pic'] ?: 'assets/images/profile.jpg' ?>" alt="Profile Picture" class="profile-picture">
                                </div>
                                <div class="col-lg-4 align-self-center">
                                    <div class="main-info header-text">
                                        <h4><?= htmlspecialchars($user['username']) ?></h4>
                                        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                                        <p>Phone: <?= htmlspecialchars($user['number']) ?></p>
                                        <p>Joined: <?= htmlspecialchars(date("F j, Y", strtotime($user['created_at']))) ?></p>
                                        <form method="POST" enctype="multipart/form-data">
                                            <input type="file" name="profile_pic" required>
                                            <button type="submit" class="btn btn-primary mt-2">Upload New Profile Picture</button>
                                        </form>
                                        <form method="POST" action="logout.php" style="margin-top: 10px;">
                                        <button type="submit" class="btn btn-danger">Log Out</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- ***** Banner End ***** -->

     
                    <!-- ***** Gaming Library Start ***** -->
                    <div class="gaming-library profile-library">
                        <?php include 'cart_view.php'; ?>
                    </div>
                    <!-- ***** Gaming Library End ***** -->


         </div>
      </div>
    </div>
  </div>
  
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2024<a href="aboutus.php">HYPERFUSION </a> All rights reserved. 
          
        </div>
      </div>
    </div>
  </footer>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>


  </body>

</html>
