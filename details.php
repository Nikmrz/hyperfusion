<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hyperfusion";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the game ID from the query parameter
$game_id = intval($_GET['id']);

// Fetch game details from the database
$sql = "SELECT * FROM gamedetails WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    echo "Game not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<title>HYPER FUSION</title>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<!-- Additional CSS Files -->
<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
<link rel="stylesheet" href="assets/css/owl.css">
<link rel="stylesheet" href="assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<style>
        .video-container, .image-container {
            position: relative;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            border-radius: 23px; /* Rounded corners */
            overflow: hidden;
            background: #000; /* Background color to match video container if needed */
            margin-bottom: 20px;
        }

        .video-container iframe, .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .image-container img {
            object-fit: cover; /* Ensures the image covers the container */
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
                    <a href="index.html" class="logo">
                        <img src="assets/images/newlogo.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Search End ***** -->
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <!-- ***** Search End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Browse</a></li>
                        <li><a href="#">Streams</a></li>
                        <li><a href="profile.html">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
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
                    <!-- ***** Featured Start ***** -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="feature-banner header-text">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="image-container">
                                            <img src="<?php echo htmlspecialchars($game['image_left']); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="video-container">
                                            <iframe src="<?php echo htmlspecialchars($game['youtube_link']); ?>" 
                                                    title="YouTube video player"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ***** Featured End ***** -->

                    <!-- ***** Details Start ***** -->
                    <div class="game-details">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2><?php echo htmlspecialchars($game['name']); ?> Details</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="left-info">
                                                <div class="left">
                                                    <h4><?php echo htmlspecialchars($game['name']); ?></h4>
                                                    <span>PS5</span>
                                                </div>
                                                <ul>
                                                    <li><i class="fa fa-star"></i> <?php echo htmlspecialchars($game['rating']); ?></li>
                                                    <li><i class="fa fa-dollar-sign"></i> <?php echo htmlspecialchars($game['price']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="right-info">
                                                <ul>
                                                    <li><i class="fa fa-star"></i> <?php echo htmlspecialchars($game['rating']); ?></li>
                                                    <li><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($game['age_rating']); ?></li>
                                                    <li><i class="fab fa-playstation"></i> <?php echo htmlspecialchars($game['size']); ?></li>
                                                    <li><i class="fa fa-gamepad"></i> <?php echo htmlspecialchars($game['genre']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Images -->
                                        <div class="col-lg-4">
                                        <div class="image-container">
                                            <img src="<?php echo htmlspecialchars($game['image_one']); ?>" alt="">
                                        </div>
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="image-container">
                                            <img src="<?php echo htmlspecialchars($game['image_two']); ?>" alt="">
                                        </div>
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="image-container">
                                            <img src="<?php echo htmlspecialchars($game['image_three']); ?>" alt="">
                                        </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <p><?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
                                        </div>
                                <div class="container text-center">
                                    <div class="row justify-content-md-center">
                                        <div class="col col-lg-2">
                                            <button class="btn btn-primary rounded-circle custom-button" id="decrease-btn">-</button>
                                        </div>
                                        <div class="col-md-auto">
                                        <span>QUANTITY: <span id="quantity">1</span></span>
                                        </div>
                                        <div class="col col-lg-2">
                                            <button class="btn btn-primary rounded-circle custom-button" id="increase-btn">+</button>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                            <p>Total Price: $<span id="total-price">0.00</span></p>
                                        </div>
                                </div>
                                        <div class="col-lg-12">
                                            <div class="main-border-button">
                                              <a href="#"><i class="fa fa-cart-plus" style="padding-right: 20px;"></i>ADD TO CART</a>
                                            </div>
                                            <div class="col-lg-12">
                                            <div class="main-border-button">
                                               <a href="#"><i class="fa fa-credit-card" style="padding-right: 20px;"></i>BUY NOW!</a>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ***** Details End ***** -->
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            let quantity = 1; // Initial quantity
            let originalPrice = 10; // Replace with the price fetched from the database

            // Update total price function
            function updateTotalPrice() {
                const totalPrice = quantity * originalPrice;
                document.getElementById('total-price').innerText = totalPrice.toFixed(2);
            }

            // Decrease quantity
            document.getElementById('decrease-btn').addEventListener('click', function () {
                if (quantity > 1) {
                    quantity--;
                    document.getElementById('quantity').innerText = quantity;
                    updateTotalPrice();
                }
            });

            // Increase quantity
            document.getElementById('increase-btn').addEventListener('click', function () {
                quantity++;
                document.getElementById('quantity').innerText = quantity;
                updateTotalPrice();
            });

            // Initial price fetch
            // Assume you're using AJAX to fetch the price from the database
            fetch('get_price.php')
                .then(response => response.json())
                .then(data => {
                    originalPrice = data.price;
                    updateTotalPrice();
                })
                .catch(error => console.error('Error fetching price:', error));
        });
    </script>
</html>

<?php
$stmt->close();
$conn->close();
?>
