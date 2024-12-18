<?php
// Start a session to check if the user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include 'db.php';

// Check if the user is logged in (session is set)
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = mysqli_prepare($con, "SELECT username, email, number, created_at, profile_pic FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id); // Use the user ID in the query
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result); // Store user data in an associative array

// Check if the form has been submitted with a profile picture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {

    // Set the directory to store uploaded files
    $targetDir = "uploads/";  // Directory where the image will be uploaded
    $fileName = basename($_FILES["profile_pic"]["name"]); // Get the file name
    $targetFilePath = $targetDir . $fileName; // Complete path to save the file
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); // Get the file extension

    // Check for upload errors
    if ($_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
        // Handle file upload errors (e.g., file too large, partial upload, etc.)
        echo "<script>alert('Error uploading file. Please try again.');</script>";
        exit();
    }

    // Sanitize file name to avoid special characters
    $fileName = preg_replace("/[^a-zA-Z0-9\-_\.]/", "_", $fileName);

    // Check if the file is a valid image type (JPG, PNG, GIF, etc.)
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (in_array($fileType, $allowedTypes)) {

        // Check if the file size is less than 5MB
        if ($_FILES['profile_pic']['size'] <= 5 * 1024 * 1024) {

            // Check if the "uploads" directory exists, if not, create it
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); // Create uploads directory with write permissions
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
                // File uploaded successfully

                // Update the database with the new profile picture path
                $updateQuery = mysqli_prepare($con, "UPDATE users SET profile_pic = ? WHERE id = ?");
                mysqli_stmt_bind_param($updateQuery, "si", $targetFilePath, $user_id);
                if (mysqli_stmt_execute($updateQuery)) {
                    // If update is successful, show success message and redirect to profile page
                    echo "<script>alert('Profile picture updated successfully!'); window.location.href = 'profile.php';</script>";
                } else {
                    echo "<script>alert('Error updating profile picture in the database.');</script>";
                }

            } else {
                echo "<script>alert('Failed to upload file. Check the directory permissions.');</script>";
            }

        } else {
            echo "<script>alert('File is too large. Maximum size is 5MB.');</script>";
        }

    } else {
        echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
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
                            <li><a href="#">Browse</a></li>
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

                    <!-- ***** Banner Start ***** -->
                    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-profile">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="<?= $user['profile_pic'] ?: 'assets/images/profile.jpg' ?>" alt="" style="border-radius: 23px;">
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
          <p>Copyright © 2036 <a href="#">Cyborg Gaming</a> Company. All rights reserved. 
          
          <br>Design: <a href="https://templatemo.com" target="_blank" title="free CSS templates">TemplateMo</a></p>
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
