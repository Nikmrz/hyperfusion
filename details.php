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

// Fetch comments for the game
$comment_sql = "SELECT c.comment, c.created_at, u.username 
                FROM game_comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.game_id = ?
                ORDER BY c.created_at DESC";
$comment_stmt = $conn->prepare($comment_sql);

if ($comment_stmt) {
    $comment_stmt->bind_param("i", $game_id);
    $comment_stmt->execute();
    $comments_result = $comment_stmt->get_result();
} else {
    // Error handling if the query fails
    $comments_result = null;
    echo "<p style='color: red;'>Error fetching comments. Please try again later.</p>";
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
        
        .comment-section {
            margin-top: 40px;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 15px;
            color: white;
        }
        .comment {
            border-bottom: 1px solid #444;
            padding: 10px 0;
        }
        .comment:last-child {
            border-bottom: none;
        }
        .comment .user-name {
            font-weight: bold;
        }
        .comment .timestamp {
            font-size: 0.9em;
            color: grey;
        }
    
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        
        function addToCart(id) {
    // Get the quantity from the page
    let quantity = parseInt(document.getElementById('quantity').innerText);

    console.log('Add to cart function triggered for game ID: ' + id); // Log to check if it's triggered

    // Send AJAX request to add to cart
    $.post("cart.php", { 
        id: id, 
        action: 'add', 
        quantity: quantity // Send dynamic quantity
    }, function(response) {
        console.log('Response from server:', response); // Log the response from server
        
        try {
            let data = JSON.parse(response); // Parse the JSON response

            if (data.status === 'success') {
                alert("Game added to cart!");
                // Optionally, you can update the cart display here (e.g., update a cart icon)
            } else {
                alert("Error: " + data.message); // Show error message if not success
            }
        } catch (e) {
            console.error('Error parsing response:', e);
            alert("There was an error with the cart action. Please try again.");
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Request failed: " + textStatus, errorThrown);
        alert("There was a problem communicating with the server. Please try again.");
    });
}


    </script>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="browse.php">Browse</a></li>
                        <li><a href="streams.php">Streams</a></li>
                        <li><a href="profile.php">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
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
                                            <p style="color: white;"><?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
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
                                            <button class="btn btn-success" style="margin-top:20px;width:100%;"
                                            onclick="addToCart(<?php echo $game['id']; ?>)">
                                            <i class="fa fa-shopping-cart"
                                            style="padding-right: 20px;"></i>Add to Cart</button>
                                            </div>
                                            <div class="col-lg-12">
                                            <div class="main-border-button">
                                             <button class="btn btn-danger" style="margin-top:20px;width:100%;"
                                            onclick="buyNow(<?php echo $game['id']; ?>, 1)"> 
                                                <i class="fa fa-credit-card" style="padding-right: 20px;"></i>BUY NOW!</button>
                                        </div>

                                        <script>
                                       function buyNow(gameId) {
                                            // Get the current quantity value from the page
                                            let quantity = parseInt(document.getElementById('quantity').innerText);

                                            // Validate the quantity (optional)
                                            if (isNaN(quantity) || quantity <= 0) {
                                                alert("Please select a valid quantity.");
                                                return;
                                            }

                                            // Redirect to checkout.php with the game ID and quantity
                                            window.location.href = 'checkout.php?action=buy_now&id=' + gameId + '&quantity=' + quantity;
                                        }
                                        </script>

                                        </div>
                                    </div>

                                    <!--Comment section display for users -->
<!-- Comments Section -->
    <div class="row">
            <div class="col-lg-12 comment-section">
                <h3>Comments</h3>
                <?php if ($comments_result->num_rows > 0): ?>
                    <?php while ($comment = $comments_result->fetch_assoc()): ?>
                        <div class="comment">
                            <p class="user-name"><?php echo htmlspecialchars($comment['username']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                            <p class="timestamp"><?php echo htmlspecialchars($comment['created_at']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Comment Form -->
        <div class="row">
            <div class="col-lg-12">
                <h3 style="color: white;">Leave a Comment</h3>
                <form action="submit_comment.php" method="POST">
                    <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
                    <div class="form-group">
                        <label for="comment" style="color: white;">Your Comment</label>
                        <textarea id="comment" name="comment" class="form-control" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
<!--Comment section display end for users -->

                                    <!-- New Section for Services -->
                                    <div class="container mt-5">
                                        <div class="row text-center">
                                            <!-- Free Delivery Box -->
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                                <div class="service-box p-4" style="background-color: #1e1e1e; border-radius: 15px;">
                                                    <i class="fa fa-truck fa-3x mb-3" style="color: white;"></i>
                                                    <h5 style="color: white;">Free Delivery</h5>
                                                    <p style="color: grey;">Enjoy free delivery on all orders with minimum purchase of 50k or above!</p>
                                                </div>
                                            </div>

                                            <!-- Easy Support Box -->
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                                <div class="service-box p-4" style="background-color: #1e1e1e; border-radius: 15px;">
                                                    <i class="fa fa-headset fa-3x mb-3" style="color: white;"></i>
                                                    <h5 style="color: white;">Easy Support</h5>
                                                    <p style="color: grey;">Our support team is here to assist you 24/7 for any inquiries!</p>
                                                </div>
                                            </div>

                                            <!-- Return and Exchange Policy Box -->
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                                                <div class="service-box p-4" style="background-color: #1e1e1e; border-radius: 15px;">
                                                    <i class="fa fa-exchange-alt fa-3x mb-3" style="color: white;"></i>
                                                    <h5 style="color: white;">Return and Exchange Policy</h5>
                                                    <p style="color: grey;">Hassle-free returns and exchanges within 7 days of purchase!</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <!-- Review Section -->
                                    <div class="container mt-5">
                                        <h3 style="color: white; text-align: center;">Leave a Review</h3>
                                        <form action="submit_review.php" method="POST" class="mt-4">
                                            <div class="form-group">
                                                <label for="name" style="color: white;">Name</label>
                                                <input type="text" id="name" name="name" class="form-control" required style="background-color: #343a40;margin-bottom:25px; color: white;">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" style="color: white;">Email</label>
                                                <input type="email" id="email" name="email" class="form-control" required style="background-color: #343a40;margin-bottom:25px; color: white;">
                                            </div>
                                            <div class="form-group">
                                                <label for="review" style="color: white;">Your Review</label>
                                                <textarea id="review" name="review" class="form-control" rows="4" required style="background-color: #343a40; color: white;"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="background-color: #007bff;margin-top:25px; border: none;">Submit</button>
                                        </form>
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

</html>

<?php
$stmt->close();
$conn->close();
?>
