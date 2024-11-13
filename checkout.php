<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$query = mysqli_prepare($con, "SELECT username, email, number, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

// Retrieve cart items
$cart_items = $_SESSION['cart'];
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Initialize delivery charge
$delivery_charge = 0;

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_location = $_POST['location'];
    $delivery_charge = $delivery_location == 'inside' ? 100 : 300;
    $grand_total = $total_price + $delivery_charge;

    // Insert order into the orders table
    $order_query = "INSERT INTO orders (user_id, total_amount, delivery_charge, location) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $order_query);
    mysqli_stmt_bind_param($stmt, "idss", $user_id, $grand_total, $delivery_charge, $delivery_location);
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_stmt_insert_id($stmt);

    // Insert order items
    foreach ($cart_items as $id => $item) {
        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_item = mysqli_prepare($con, $item_query);
        mysqli_stmt_bind_param($stmt_item, "iiid", $order_id, $id, $item['quantity'], $item['price']);
        mysqli_stmt_execute($stmt_item);
    }

    // Clear the cart and redirect to confirmation
    unset($_SESSION['cart']);
$_SESSION['order_id'] = $order_id;
header("Location: order_confirmation.php");
exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e1e; color: #fff; }
        .container { margin-top: 20px; }
        .billing-summary, .cart-items, .delivery-options { background-color: #2e2e2e; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center text-white">Checkout</h2>
    
    <!-- User Information -->
    <div class="billing-summary">
        <h4>Billing Summary</h4>
        <p>Username: <?= htmlspecialchars($user['username']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Phone: <?= htmlspecialchars($user['number']) ?></p>
        <p>Joined: <?= htmlspecialchars(date("F j, Y", strtotime($user['created_at']))) ?></p>
    </div>

    <!-- Cart Items -->
    <div class="cart-items">
        <h4>Cart Items</h4>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Subtotal</strong></td>
                    <td><strong>$<?= number_format($total_price, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Delivery Options -->
    <div class="delivery-options">
        <h4>Delivery Options</h4>
        <form method="POST" action="checkout.php">
            <label>Select Delivery Location:</label><br>
            <input type="radio" name="location" value="inside" required> Inside Valley (Delivery Charge: $100)<br>
            <input type="radio" name="location" value="outside"> Outside Valley (Delivery Charge: $300)<br>
            <br>

            <!-- Summary and Place Order Button -->
            <div class="order-summary">
                <h4>Order Summary</h4>
                <p>Subtotal: $<?= number_format($total_price, 2) ?></p>
                <p>Delivery Charge: $<span id="delivery-charge">0.00</span></p>
                <p><strong>Grand Total: $<span id="grand-total"><?= number_format($total_price, 2) ?></span></strong></p>
            </div>

            <button type="submit" class="btn btn-success mt-3">Place Order</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Update delivery charge and grand total on delivery option selection
    $('input[name="location"]').change(function() {
        let deliveryCharge = $(this).val() === 'inside' ? 100 : 300;
        let subtotal = <?= $total_price ?>;
        let grandTotal = subtotal + deliveryCharge;

        $('#delivery-charge').text(deliveryCharge.toFixed(2));
        $('#grand-total').text(grandTotal.toFixed(2));
    });
</script>

</body>
</html>
