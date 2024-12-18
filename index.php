<?php
include 'db.php'; // Include database connection
session_start();

// Fetch all games from the database
$query = "SELECT * FROM games";
$result = mysqli_query($con, $query);

$games = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $games[] = $row;
    }
}

// Shuffle games array to randomize their display
shuffle($games);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HYPER FUSION - Popular Games</title>

    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">

    <!-- jQuery and AJAX script for live search and cart -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

    <!-- Custom CSS for suggestions -->
    <style>
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
            background-color: #ffffff;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
        #suggestions {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 35%;
            z-index: 1000;
            max-height: 150px;
            overflow-y: auto;
        }
    </style>

    <script>
    // AJAX for live search
    $(document).ready(function() {
        $('#searchText').on('keyup', function() {
            let query = $(this).val();
            
            if (query.length > 0) {
                $.ajax({
                    url: 'search_suggestions.php',
                    method: 'POST',
                    data: { search: query },
                    success: function(data) {
                        $('#suggestions').html(data).show();
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.search-input').length) {
                $('#suggestions').hide();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            let gameId = $(this).data('id');
            window.location.href = 'details.php?id=' + gameId;
        });
    });
    // Add to Cart
    function addToCart(id) {
        $.post("cart.php", { id: id, action: 'add', quantity: 1 }, function() {
            alert("Added to cart!");
        });
    }

</script>

</head>

<body>
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
                            <input type="text" placeholder="Type Something" id="searchText" name="searchKeyword" autocomplete="off" />
                            <i class="fa fa-search"></i>
                        </form>
                        <div id="suggestions"></div>
                    </div>
                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="#">Browse</a></li>
                        <li><a href="streams.php">Streams</a></li>
                        
                        <li><a href="profile.php">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                <div class="main-banner">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="header-text">
                                <h5>Welcome To HYPER FUSION</h5>
                                <h4><em>Browse</em> Our Popular Games Here</h4>
                                <div class="main-button">
                                    <a href="#">GET STARTED</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="most-popular">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="heading-section">
                                <h4><em>Most Popular</em> Right Now</h4>
                            </div>
                            <div class="row">
                                <?php foreach ($games as $game) { ?>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="item">
                                            <a href="details.php?id=<?php echo $game['id']; ?>">
                                                <img src="<?php echo $game['image']; ?>" alt="" id="<?php echo $game['id']; ?>" 
                                                     data-name="<?php echo $game['name']; ?>" data-price="<?php echo $game['price']; ?>">
                                            </a>
                                            <h4><?php echo $game['name']; ?><br><span><?php echo $game['platform']; ?></span></h4>
                                            <ul>
                                                <li><i class="fa fa-star"></i> <?php echo $game['rating']; ?></li>
                                                <li><i class="fa fa-dollar-sign"></i> <?php echo $game['price']; ?></li>
                                            </ul>
                                            <div class="buttons">
                                                <button class="btn btn-success" style="margin-top:20px;width:100%;"
                                                        onclick="addToCart(<?php echo $game['id']; ?>)">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © 2024 <a href="#">HYPER FUSION</a> - MIS Project</p>
            </div>
        </div>
    </div>
</footer>

<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
