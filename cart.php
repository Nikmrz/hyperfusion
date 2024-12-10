<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get action and gameId from POST data
    $action = $_POST['action'];
    $gameId = $_POST['id'];
    
    // Sanitize and validate input (important for security)
    $gameId = intval($gameId); // Convert the ID to an integer
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default to 1 if quantity is not set
    
    // Validate quantity to ensure it's greater than 0
    if ($quantity <= 0) {
        $quantity = 1; // Reset to 1 if invalid quantity is passed
    }
    
    // Default response
    $response = ['status' => 'error', 'message' => 'Invalid request'];

    // Check if the game ID is valid
    if ($gameId > 0) {
        // Process the 'add' action
        if ($action == 'add') {
            // Query the database to fetch game details
            $query = "SELECT * FROM gamedetails WHERE id = '$gameId'";
            $result = mysqli_query($con, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $game = mysqli_fetch_assoc($result);

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // If the game is already in the cart, update the quantity, else add it to the cart
                if (isset($_SESSION['cart'][$gameId])) {
                    $_SESSION['cart'][$gameId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$gameId] = [
                        'name' => $game['name'],
                        'price' => $game['price'],
                        'quantity' => $quantity
                    ];
                }

                // Prepare success response
                $response = ['status' => 'success', 'message' => 'Game added to cart'];
            } else {
                $response = ['status' => 'error', 'message' => 'Game not found'];
            }
        }
        // Handle other actions like 'remove' or 'update'
        elseif ($action == 'remove') {
            unset($_SESSION['cart'][$gameId]);
            $response = ['status' => 'success', 'message' => 'Game removed from cart'];
        } elseif ($action == 'update') {
            if (isset($_SESSION['cart'][$gameId])) {
                $_SESSION['cart'][$gameId]['quantity'] = $quantity;
                $response = ['status' => 'success', 'message' => 'Cart updated'];
            } else {
                $response = ['status' => 'error', 'message' => 'Game not in cart'];
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid game ID'];
    }
    
    // Return the response as JSON
    echo json_encode($response);
} else {
    // If the request is not a POST request, return an error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
