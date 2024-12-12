<?php
include 'db.php'; // Include the database connection

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_game'])) {
    $id = $_POST['id'];

    // Delete the game record from the database
    $query = "DELETE FROM gamedetails WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<p style='color: green; text-align: center;'>Game deleted successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_game'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $age_rating = $_POST['age_rating'];
    $size = $_POST['size'];
    $genre = $_POST['genre'];
    $youtube_link = $_POST['youtube_link'];

    // File upload handling
    $upload_dir = 'uploads/';
    $image_left = $_FILES['image_left']['name'] ? $_FILES['image_left']['name'] : $_POST['current_image_left'];
    $image_one = $_FILES['image_one']['name'] ? $_FILES['image_one']['name'] : $_POST['current_image_one'];
    $image_two = $_FILES['image_two']['name'] ? $_FILES['image_two']['name'] : $_POST['current_image_two'];
    $image_three = $_FILES['image_three']['name'] ? $_FILES['image_three']['name'] : $_POST['current_image_three'];

    if ($_FILES['image_left']['name']) move_uploaded_file($_FILES['image_left']['tmp_name'], $upload_dir . $image_left);
    if ($_FILES['image_one']['name']) move_uploaded_file($_FILES['image_one']['tmp_name'], $upload_dir . $image_one);
    if ($_FILES['image_two']['name']) move_uploaded_file($_FILES['image_two']['tmp_name'], $upload_dir . $image_two);
    if ($_FILES['image_three']['name']) move_uploaded_file($_FILES['image_three']['tmp_name'], $upload_dir . $image_three);

    $query = "UPDATE gamedetails SET 
              name='$name', 
              description='$description', 
              rating='$rating', 
              price='$price', 
              age_rating='$age_rating', 
              size='$size', 
              genre='$genre', 
              youtube_link='$youtube_link', 
              image_left='$image_left', 
              image_one='$image_one', 
              image_two='$image_two', 
              image_three='$image_three' 
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<p style='color: green; text-align: center;'>Game updated successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Fetch all games
$query = "SELECT * FROM gamedetails";
$result = mysqli_query($conn, $query);

echo "<h2 style='text-align: center;'>Game Details</h2>";

echo "<table border='1' style='width: 100%; border-collapse: collapse; text-align: left;'>";
echo "<tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Rating</th>
        <th>Price</th>
        <th>Age Rating</th>
        <th>Size</th>
        <th>Genre</th>
        <th>YouTube Link</th>
        <th>Image (Left)</th>
        <th>Image (One)</th>
        <th>Image (Two)</th>
        <th>Image (Three)</th>
        <th>Actions</th>
      </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['rating']}</td>
            <td>{$row['price']}</td>
            <td>{$row['age_rating']}</td>
            <td>{$row['size']}</td>
            <td>{$row['genre']}</td>
            <td><a href='{$row['youtube_link']}' target='_blank'>Watch Video</a></td>
            <td><img src='..assets/images/{$row['image_left']}' alt='Image Left' style='width: 100px;'></td>
            <td><img src='..assets/images/{$row['image_one']}' alt='Image One' style='width: 100px;'></td>
            <td><img src='..assets/images/{$row['image_two']}' alt='Image Two' style='width: 100px;'></td>
            <td><img src='..assets/images/{$row['image_three']}' alt='Image Three' style='width: 100px;'></td>
            <td>
                <button onclick=\"document.getElementById('editForm{$row['id']}').style.display='block';\">Edit</button>
                <form action='viewgames.php' method='post' style='display: inline;'>
                    <input type='hidden' name='delete_game' value='1'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit' style='color: red;'>Delete</button>
                </form>
            </td>
          </tr>";

    // Edit Form
    echo "<tr id='editForm{$row['id']}' style='display: none;'>
            <td colspan='14'>
                <form action='viewgames.php' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='edit_game' value='1'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='hidden' name='current_image_left' value='{$row['image_left']}'>
                    <input type='hidden' name='current_image_one' value='{$row['image_one']}'>
                    <input type='hidden' name='current_image_two' value='{$row['image_two']}'>
                    <input type='hidden' name='current_image_three' value='{$row['image_three']}'>
                    
                    <label for='name'>Game Name:</label>
                    <input type='text' name='name' value='{$row['name']}' required>

                    <label for='description'>Description:</label>
                    <textarea name='description' rows='4' required>{$row['description']}</textarea>

                    <label for='rating'>Rating:</label>
                    <input type='number' name='rating' value='{$row['rating']}' step='0.1' min='0' max='10' required>

                    <label for='price'>Price:</label>
                    <input type='number' name='price' value='{$row['price']}' step='0.01' min='0' required>

                    <label for='age_rating'>Age Rating:</label>
                    <input type='text' name='age_rating' value='{$row['age_rating']}' required>

                    <label for='size'>Size:</label>
                    <input type='text' name='size' value='{$row['size']}' required>

                    <label for='genre'>Genre:</label>
                    <input type='text' name='genre' value='{$row['genre']}' required>

                    <label for='youtube_link'>YouTube Link:</label>
                    <input type='url' name='youtube_link' value='{$row['youtube_link']}' required>

                    <label for='image_left'>Image (Left):</label>
                    <input type='file' name='image_left' accept='image/*'>

                    <label for='image_one'>Image (One):</label>
                    <input type='file' name='image_one' accept='image/*'>

                    <label for='image_two'>Image (Two):</label>
                    <input type='file' name='image_two' accept='image/*'>

                    <label for='image_three'>Image (Three):</label>
                    <input type='file' name='image_three' accept='image/*'>

                    <button type='submit'>Update</button>
                    <button type='button' onclick=\"document.getElementById('editForm{$row['id']}').style.display='none';\">Cancel</button>
                </form>
            </td>
          </tr>";
}
echo "</table>";
?>
