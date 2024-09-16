<?php
include 'db.php';

// Fetch user details from the `user` table
$sql = "SELECT username, email, number, birthday FROM users WHERE user_id = 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $username = $user['fullname'];
    $email = $user['email'];
    $phone = $user['number'];
    $birthday = $user['birthday'];

    // Fetch the number of orders
    $order_count_sql = "SELECT COUNT(*) AS order_count FROM gamedetails WHERE user_id = ?";
    $order_stmt = $conn->prepare($order_count_sql);
    $order_stmt->bind_param("i", $user_id);
    $order_stmt->execute();
    $order_result = $order_stmt->get_result();
    $order_count = $order_result->fetch_assoc()['order_count'];
}

// Fetch user's orders from `gamedetails` table
$order_sql = "SELECT game_name, game_type, date_added, price FROM gamedetails WHERE user_id = ?";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
?>

<body>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.php" class="logo">
                        <img src="assets/images/newlogo.png" alt="">
                    </a>
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Browse</a></li>
                        <li><a href="#">Streams</a></li>
                        <li><a href="profile.php" class="active">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
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
          <div class="row">
            <div class="col-lg-12">
              <div class="main-profile">
                <div class="row">
                  <div class="col-lg-4">
                    <img src="assets/images/profile.jpg" alt="" style="border-radius: 23px;">
                  </div>
                  <div class="col-lg-4 align-self-center">
                    <div class="main-info header-text">
                      <h4><?php echo $username; ?></h4>
                      <p>@<?php echo strtolower($username); ?></p>
                      <div class="main-border-button">
                        <a href="#">Edit your Profile</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 align-self-center">
                    <ul>
                      <li>Email: <span><?php echo $email; ?></span></li>
                      <li>Phone Number: <span><?php echo $phone; ?></span></li>
                      <li>Birthday: <span><?php echo $birthday; ?></span></li>
                      <li>Orders: <span><?php echo $order_count; ?></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ***** Gaming Library Start ***** -->
          <div class="gaming-library profile-library">
            <div class="col-lg-12">
              <div class="heading-section">
                <h4>My Orders</h4>
              </div>
              
              <?php while ($order = $order_result->fetch_assoc()) { ?>
              <div class="item">
                <ul>
                  <li><img src="assets/images/game-01.jpg" alt="" class="templatemo-item"></li>
                  <li><h4><?php echo $order['game_name']; ?></h4><span><?php echo $order['game_type']; ?></span></li>
                  <li><h4>Date Added</h4><span><?php echo $order['date_added']; ?></span></li>
                  <li><h4>Price</h4><span><?php echo $order['price']; ?></span></li>
                  <li><div class="main-border-button border-no-active"><a href="#">On its Way</a></div></li>
                </ul>
              </div>
              <?php } ?>
            </div>
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
          <p>Copyright © 2024 <a href="#">HYPER FUSION </a>Gaming Web Hub
          
          <br>5th sem MIS project</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html>
