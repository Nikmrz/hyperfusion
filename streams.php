<?php
include 'db.php'; // Database connection
session_start();

// Your Google API Key (get it from https://console.developers.google.com/)
$apiKey = 'AIzaSyCXHKcqImMYwud5tY9kAu6gjcvaj3HXkfI'; // Replace with your actual API Key

// Function to fetch live streams based on query
function getLiveStreams($query) {
    global $apiKey;

    // If query is empty, default to "PS5 gaming live streams"
    $searchQuery = !empty($query) ? $query . ' PS5 gaming live streams' : 'PS5 gaming live streams';

    // API URL focused on live streams for the PS5
    $apiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q=' . urlencode($searchQuery) . '&eventType=live&key=' . $apiKey;
    $response = file_get_contents($apiUrl);

    // Return the decoded JSON response
    return json_decode($response, true);
}

$data = []; 
if (isset($_POST['searchQuery'])) {
    $query = $_POST['searchQuery'];
    $data = getLiveStreams($query); // Get live stream results based on search query
} else {
    $data = getLiveStreams(''); // Default to gaming live streams if no search
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Gaming Streams - HYPER FUSION</title>

    <!-- Bootstrap CSS for styling -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
<style>

        .streams-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .stream {
            background-color: #fff;
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
            color: #000;
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

        #suggestions {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 20%;
            z-index: 1000;
            max-height: 180px;
            overflow-y: auto;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        // AJAX for live search
        $('#searchText').on('keyup', function() {
            let query = $(this).val();

            if (query.length > 0) {
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { searchQuery: query },
                    success: function(data) {
                        let streams = $(data).find('.stream');
                        $('#suggestions').html(streams).show();
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
    });
    </script>
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
                        <form id="search" action="#">
                            <input type="text" placeholder="Search live gaming streams..." id="searchText" name="searchKeyword" autocomplete="off" />
                            <i class="fa fa-search"></i>
                        </form>
                        <div id="suggestions"></div>
                    </div>
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="browse.php">Browse</a></li>
                        <li><a href="streams.php" class="active">Streams</a></li>
                        <li><a href="profile.php">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="container">
<div class="row">
      <div class="col-lg-12">
        <div class="page-content">
    <h1>Live Gaming Streams</h1>

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

