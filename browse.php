<?php
include 'db.php'; // Include database connection
session_start();

// Fetch games based on filters
// Fetch games based on filters
function fetchGames($con, $filters) {
    $query = "SELECT games.*, gamedetails.age_rating FROM games JOIN gamedetails ON games.id = gamedetails.id";
    $conditions = [];

    // Apply filter conditions if set
    if (!empty($filters['genre']) && $filters['genre'] !== 'all') {
        $genre = mysqli_real_escape_string($con, $filters['genre']);
        $conditions[] = "genre = '$genre'";
    }
    if (!empty($filters['age'])) {
        $age = mysqli_real_escape_string($con, $filters['age']);
        $conditions[] = "age_rating = '$age'";
    }
    
    // Apply price and rating ordering
    $orderBy = [];
    if (!empty($filters['price'])) {
        $priceOrder = $filters['price'] === 'high-low' ? 'DESC' : 'ASC';
        $orderBy[] = "price $priceOrder";
    }
    if (!empty($filters['rating'])) {
        $ratingOrder = $filters['rating'] === 'high-low' ? 'DESC' : 'ASC';
        $orderBy[] = "rating $ratingOrder";
    }

    // Add WHERE clause if there are conditions
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Add ORDER BY if there are sorting preferences
    if (!empty($orderBy)) {
        $query .= " ORDER BY " . implode(", ", $orderBy);
    }

    // Execute query
    $result = mysqli_query($con, $query);
    $games = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $games[] = $row;
        }
    }
    return $games;
}

// Get filters from request
$filters = [
    'price' => $_GET['price'] ?? '',
    'rating' => $_GET['rating'] ?? '',
     'genre' => $_GET['category'] ?? '',
    'age' => $_GET['age'] ?? ''
];

// Fetch games based on filters
$games = fetchGames($con, $filters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HYPER FUSION - Browse Games</title>

    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
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
                        <img src="assets/images/newlogo.png" alt="Hyper Fusion Logo">
                    </a>
                    <div class="search-input">
                        <form id="search" action="#">
                            <input type="text" placeholder="Type Something" id="searchText" name="searchKeyword" autocomplete="off" />
                            <i class="fa fa-search"></i>
                        </form>
                        <div id="suggestions"></div>
                    </div>
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="browse.php" class="active">Browse</a></li>
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

<!-- Filter Section -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                
                    <div class="row">
                        <div class="col-lg-7">
                        <div class="heading-section">
                                <h4><em>BROWSE YOUR   </em>   FAVOURITE GAMES</h4>
                            </div>
    <form method="get" action="browse.php" class="row g-3">
        <div class="col-md-3">
            <label for="price" class="form-label">Price</label>
            <p>Price</p>
            <select class="form-control" name="price" id="price">
                <option value="">Select</option>
                <option value="low-high" <?= $filters['price'] === 'low-high' ? 'selected' : '' ?>>Low to High</option>
                <option value="high-low" <?= $filters['price'] === 'high-low' ? 'selected' : '' ?>>High to Low</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="rating" class="form-label">Rating</label>
            <p>Rating</p>
            <select class="form-control" name="rating" id="rating">
                <option value="">Select</option>
                <option value="high-low" <?= $filters['rating'] === 'high-low' ? 'selected' : '' ?>>High to Low</option>
                <option value="low-high" <?= $filters['rating'] === 'low-high' ? 'selected' : '' ?>>Low to High</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="category" class="form-label">Category</label>
            <p>Genre</p>
            <select class="form-control" name="category" id="category">
                <option value="all">All</option>
                <option value="sport" <?= $filters['genre'] === 'sport' ? 'selected' : '' ?>>Sport</option>
                <option value="action" <?= $filters['genre'] === 'action' ? 'selected' : '' ?>>Action</option>
                <option value="shooter" <?= $filters['genre'] === 'shooter' ? 'selected' : '' ?>>Shooter</option>
                <option value="platformer" <?= $filters['genre'] === 'platformer' ? 'selected' : '' ?>>platformer</option>
                <option value="RPG" <?= $filters['genre'] === 'RPG' ? 'selected' : '' ?>>RPG</option>
                <option value="adventure" <?= $filters['genre'] === 'adventure' ? 'selected' : '' ?>>Adventure</option>
                <option value="Horror" <?= $filters['genre'] === 'Horror' ? 'selected' : '' ?>>Horror</option>
                <option value="Racing" <?= $filters['genre'] === 'Racing' ? 'selected' : '' ?>>Racing</option>
                <option value="Fighting" <?= $filters['genre'] === 'Fighting' ? 'selected' : '' ?>>Fighting</option>
                <option value="Puzzle" <?= $filters['genre'] === 'Puzzle' ? 'selected' : '' ?>>Puzzle</option>
                <!-- Add more categories as needed -->
            </select>
        </div>
        <div class="col-md-3">
            <label for="age" class="form-label">Age Rating</label>
            <p>Age</p>
            <select class="form-control" name="age" id="age">
                <option value="">All Ages</option>
                <option value="E" <?= $filters['age'] === 'E' ? 'selected' : '' ?>>Everyone (E)</option>
                <option value="18+" <?= $filters['age'] === '18+' ? 'selected' : '' ?>>Mature 18+</option>
                <option value="16+" <?= $filters['age'] === '16+' ? 'selected' : '' ?>>16+</option>
                <option value="12+" <?= $filters['age'] === '12+' ? 'selected' : '' ?>>12+</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>
</div>
</div>
                       
                </div>


<!-- Games Display Area -->
<div class="most-popular">
                    <div class="row">
                        <div class="col-lg-12">
                           

    <div class="row">
        <?php if ($games): ?>
            <?php foreach ($games as $game): ?>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="item">
                        <a href="details.php?id=<?= $game['id']; ?>">
                            <img src="<?= $game['image']; ?>" alt="<?= $game['name']; ?>" class="img-fluid">
                        </a>
                        <h4><?= $game['name']; ?><br><span><?= $game['platform']; ?></span></h4>
                        <ul>
                            <li><i class="fa fa-star"></i> <?= $game['rating']; ?></li>
                            <li><i class="fa fa-dollar-sign"></i> <?= $game['price']; ?></li>
                        </ul>
                        <div class="buttons">
                            <button class="btn btn-success mt-2" onclick="addToCart(<?= $game['id']; ?>)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No games found matching your criteria.</p>
        <?php endif; ?>
    </div>
</div>
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
                <p>Copyright © 2024 <a href="aboutus.php">HYPER FUSION</a> All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
    function addToCart(id) {
        $.post("cart.php", { id: id, action: 'add', quantity: 1 }, function() {
            alert("Added to cart!");
        });
    }
</script>

</body>
</html>
