<?php
session_start();
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT username, email, number, created_at FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Fetch order details (based on session order ID)
$order_id = $_SESSION['order_id'];
$query_order = "SELECT * FROM orders WHERE id = ?";
$stmt_order = mysqli_prepare($con, $query_order);
mysqli_stmt_bind_param($stmt_order, "i", $order_id);
mysqli_stmt_execute($stmt_order);
$order_result = mysqli_stmt_get_result($stmt_order);
$order = mysqli_fetch_assoc($order_result);

// Fetch order items
$query_items = "SELECT oi.product_id, oi.quantity, oi.price, g.name 
                FROM order_items oi 
                JOIN gamedetails g ON oi.product_id = g.id 
                WHERE oi.order_id = ?";
$stmt_items = mysqli_prepare($con, $query_items);
mysqli_stmt_bind_param($stmt_items, "i", $order_id);
mysqli_stmt_execute($stmt_items);
$order_items = mysqli_stmt_get_result($stmt_items);

// Calculate total cost
$total_price = 0;
foreach ($order_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

$delivery_charge = $order['delivery_charge'];
$grand_total = $total_price + $delivery_charge;


// Send email
$mail = new PHPMailer(true);

try {
    // Mail configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sanirmrz2060@gmail.com'; // Use your email
    $mail->Password = 'iuefxrsyphofhytr'; // Use an app password if 2FA is enabled
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set the sender and recipient
    $mail->setFrom('sanirmrz2060@gmail.com', 'HYPER FUSION');
    $mail->addAddress($user['email'], $user['username']); // Send email to the reviewer's email

    // Content
    $mail->isHTML(true);
    $mail->AddEmbeddedImage('assets/images/newlogo.png', 'logo_cid'); 
    $mail->Subject = 'Thank you for purchasing ! ';
    $mail->Body = "
        <h3>Order Summary</h3>
        <p><strong>Order ID:</strong> {$order['id']}</p>
        <p><strong>Order Date:</strong> ".date("F j, Y, g:i a", strtotime($order['order_date']))."</p>
        <p><strong>Delivery Location:</strong> {$order['location']}</p>
        <p><strong>Delivery Address:</strong> {$order['place']}</p>
        <p><strong>Subtotal:</strong> $".number_format($total_price, 2)."</p>
        <p><strong>Delivery Charge:</strong> $".number_format($delivery_charge, 2)."</p>
        <p><strong>Grand Total:</strong> $".number_format($grand_total, 2)."</p>
        <p>We are committed to improving your experience with us and appreciate your continued trust.</p>
            
            <p>Best regards,<br><strong>Admin</strong><br>HYPER FUSION</p>
            <p><img src='cid:logo_cid' alt='Logo' /></p>
    ";

    $mail->send();
    echo "<script>console.log('Order summary email sent successfully.');</script>";
} catch (Exception $e) {
    echo "<script>console.log('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="checkout.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Order Summary</h2>

        <!-- User Information -->
        <div class="billing-summary">
            <h4>Billing Summary</h4>
            <p>Username: <?= htmlspecialchars($user['username']) ?></p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Phone: <?= htmlspecialchars($user['number']) ?></p>
            <p>Joined: <?= htmlspecialchars(date("F j, Y", strtotime($user['created_at']))) ?></p>
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <h4>Order Details</h4>
            <p>Order ID: <?= htmlspecialchars($order['id']) ?></p>
            <p>Order Date: <?= htmlspecialchars(date("F j, Y, g:i a", strtotime($order['order_date']))) ?></p>
            <p>Delivery Location: <?= htmlspecialchars($order['location']) ?></p>
            <p>Delivery Address: <?= htmlspecialchars($order['place']) ?></p>
        </div>

        <!-- Cart Items -->
        <div class="cart-items">
            <h4>Cart Items</h4>
            <table class="table table-dark">
               
                <tbody>
    <tr>
        <td colspan="3"><strong>Subtotal</strong></td>
        <td><strong>$<?= number_format($total_price, 2) ?></strong></td>
    </tr>
    <tr>
        <td colspan="3"><strong>Delivery Charge</strong></td>
        <td><strong>$<?= number_format($delivery_charge, 2) ?></strong></td>
    </tr>
    <tr>
        <td colspan="3"><strong>Grand Total</strong></td>
        <td><strong>$<?= number_format($grand_total, 2) ?></strong></td>
    </tr>
</tbody>

            </table>
        </div>

        <div class="text-center">
        <a href="index.php" class="btn btn-danger" style="height:50px;width:100%;text-align:center;padding-top:10px;">Go back Home</a>
            <a href="khalti_checkout.php" class="btn btn-success" style="margin-top:20px;">Proceed to Payment</a>
            
        </div>
        <div>
            <br>
            <br>
                    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
