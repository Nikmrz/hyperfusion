<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $gameId = $_POST['id'];

    if ($action == 'add') {
        $quantity = $_POST['quantity'] ?? 1;

        $query = "SELECT * FROM gamedetails WHERE id = '$gameId'";
        $result = mysqli_query($con, $query);
        $game = mysqli_fetch_assoc($result);

        if ($game) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$gameId])) {
                $_SESSION['cart'][$gameId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$gameId] = [
                    'name' => $game['name'],
                    'price' => $game['price'],
                    'quantity' => $quantity
                ];
            }
        }
    } elseif ($action == 'remove') {
        unset($_SESSION['cart'][$gameId]);
    } elseif ($action == 'update') {
        $quantity = $_POST['quantity'];
        if (isset($_SESSION['cart'][$gameId])) {
            $_SESSION['cart'][$gameId]['quantity'] = $quantity;
        }
    }
}
?>
