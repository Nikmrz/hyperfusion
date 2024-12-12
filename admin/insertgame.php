<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $age_rating = $_POST['age_rating'];
    $size = $_POST['size'];
    $genre = $_POST['genre'];
    $youtube_link = $_POST['youtube_link'];

    // File upload handling
    $image_left = $_FILES['image_left']['name'];
    $image_one = $_FILES['image_one']['name'];
    $image_two = $_FILES['image_two']['name'];
    $image_three = $_FILES['image_three']['name'];

    $upload_dir = 'uploads/';
    move_uploaded_file($_FILES['image_left']['tmp_name'], $upload_dir . $image_left);
    move_uploaded_file($_FILES['image_one']['tmp_name'], $upload_dir . $image_one);
    move_uploaded_file($_FILES['image_two']['tmp_name'], $upload_dir . $image_two);
    move_uploaded_file($_FILES['image_three']['tmp_name'], $upload_dir . $image_three);

    $query = "INSERT INTO gamedetails (name, description, rating, price, age_rating, size, genre, youtube_link, image_left, image_one, image_two, image_three)
              VALUES ('$name', '$description', '$rating', '$price', '$age_rating', '$size', '$genre', '$youtube_link', '$image_left', '$image_one', '$image_two', '$image_three')";

    if (mysqli_query($conn, $query)) {
        echo "Game inserted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Game Details</title>
    <style>
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
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

<h2 style="text-align: center;">Insert Game Details</h2>

<form action="insertgame.php" method="post" enctype="multipart/form-data">
    <label for="name">Game Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>

    <label for="rating">Rating (out of 10):</label>
    <input type="number" id="rating" name="rating" step="0.1" min="0" max="10" required>

    <label for="price">Price ($):</label>
    <input type="number" id="price" name="price" step="0.01" min="0" required>

    <label for="age_rating">Age Rating:</label>
    <input type="text" id="age_rating" name="age_rating" required>

    <label for="size">Size (in MB/GB):</label>
    <input type="text" id="size" name="size" required>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required>

    <label for="youtube_link">YouTube Link:</label>
    <input type="url" id="youtube_link" name="youtube_link" required>

    <label for="image_left">Image (Left):</label>
    <input type="file" id="image_left" name="image_left" accept="image/*" required>

    <label for="image_one">Image (One):</label>
    <input type="file" id="image_one" name="image_one" accept="image/*" required>

    <label for="image_two">Image (Two):</label>
    <input type="file" id="image_two" name="image_two" accept="image/*" required>

    <label for="image_three">Image (Three):</label>
    <input type="file" id="image_three" name="image_three" accept="image/*" required>

    <button type="submit">Insert Game</button>
</form>

</body>
</html>
