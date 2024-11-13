<?php
include 'db.php'; // Include your database connection

if (isset($_POST['search'])) {
    $search = htmlspecialchars($_POST['search']);
    $searchTerm = "%" . $search . "%";
    
    // Query to search the 'games' table for names matching the search term
    $query = "SELECT id, name FROM games WHERE name LIKE ? LIMIT 3";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Adding a data-id attribute to store the game id in each suggestion
            echo "<div class='suggestion-item' data-id='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</div>";
        }
    } else {
        echo "<div class='suggestion-item'>No results found</div>";
    }
}
?>
