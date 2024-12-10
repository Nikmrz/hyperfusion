<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Save cart data before destroying the session
$cart = $_SESSION['cart'] ?? [];

// Destroy session
session_destroy();

// Restart session to restore cart
session_start();
$_SESSION['cart'] = $cart;

// Redirect to login
header("Location: Login/login.html");
exit();
?>