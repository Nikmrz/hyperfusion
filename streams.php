<?php
include 'db.php'; // Database connection
session_start();

// Your Google API Key (get it from https://console.developers.google.com/)
$apiKey = 'AIzaSyCXHKcqImMYwud5tY9kAu6gjcvaj3HXkfI'; // Replace with your actual API Key

// Function to fetch live streams based on query
function getLiveStreams($query) {
    global $apiKey;

    // Default search query for PlayStation games live streams
    $defaultQuery = 'PlayStation gaming live streams';

    // If query is empty, use the default search
    $searchQuery = !empty($query) ? $query . ' PlayStation live streams' : $defaultQuery;

    // Update API URL to focus on live streams based on the search query
    $apiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q=' . urlencode($searchQuery) . '&eventType=live&key=' . $apiKey;
    $response = file_get_contents($apiUrl);
    return json_decode($response, true);
}

$data = [];
$searchQuery = ''; // Initialize search query
if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];
    $data = getLiveStreams($searchQuery); // Get live stream results based on search query
} else {
    $data = getLiveStreams(''); // Default to PlayStation live streams if no search
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayStation Live Gaming Streams - HYPER FUSION</title>

    <!-- Bootstrap CSS for styling -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">

    <style>
        /* Your existing styles */
        .streams-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .stream {
            background-color: #27292a;
            border-radius: 5px;
            width: 250px;
            margin: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stream img {
            width: 100%;
            border-radius: 5px;
        }

        .stream h2 {
            font-size: 16px;
            margin-top: 10px;
            color: #fff;
        }

        .stream p {
            font-size: 14px;
            color: #777;
        }

        .stream a {
            text-decoration: none;
        }

        .stream a:hover {
            color: #007BFF;
        }
    </style>
</head>
<body>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.php" class="logo">
                        <img src="assets/images/newlogo.png" alt="Logo">
                    </a>
                    <div class="search-input">
                        <form method="POST" id="search">
                            <input type="text" placeholder="Search PlayStation live streams..." id="searchText" name="searchQuery" value="<?= htmlspecialchars($searchQuery) ?>" />
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Browse</a></li>
                        <li><a href="streams.php" class="active">Streams</a></li>
                        <li><a href="profile.php">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <h1><?= !empty($searchQuery) ? htmlspecialchars($searchQuery) . ' Live Gaming Streams' : 'PlayStation Live Gaming Streams' ?></h1>

    <div class="streams-container" id="streamsContainer">
        <?php
        if (isset($data['items']) && !empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $videoId = $item['id']['videoId'];
                $title = $item['snippet']['title'];
                $channelTitle = $item['snippet']['channelTitle'];
                $thumbnailUrl = $item['snippet']['thumbnails']['medium']['url'];

                echo "<div class='stream'>";
                echo "<a href='https://www.youtube.com/watch?v=$videoId' target='_blank'>";
                echo "<img src='$thumbnailUrl' alt='$title' />";
                echo "</a>";
                echo "<h2>" . htmlspecialchars($title) . "</h2>";
                echo "<p>Channel: " . htmlspecialchars($channelTitle) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No live gaming streams found.</p>";
        }
        ?>
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

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
