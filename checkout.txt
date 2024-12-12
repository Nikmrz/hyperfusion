<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Initialize variables
$cart_items = [];
$total_price = 0;
$delivery_charge = 0;

// Handle "Buy Now" action
if (isset($_GET['action']) && $_GET['action'] === 'buy_now' && isset($_GET['id']) && isset($_GET['quantity'])) {
    $game_id = intval($_GET['id']);
    $quantity = intval($_GET['quantity']);

    // Fetch game details from the database
    $query = "SELECT * FROM gamedetails WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $game_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $game = mysqli_fetch_assoc($result);

    if ($game) {
        // Add the game to a temporary cart array
        $cart_items[$game_id] = [
            'name' => $game['name'],
            'price' => $game['price'],
            'quantity' => $quantity
        ];
        $total_price = $game['price'] * $quantity;
    } else {
        echo "<script>alert('Game not found.'); window.location.href = 'index.php';</script>";
        exit();
    }
} else {
    // Retrieve cart items (normal checkout flow)
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    foreach ($cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
}

// Get user information
$user_id = $_SESSION['user_id'];
$query = mysqli_prepare($con, "SELECT username, email, number, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $delivery_location = $_POST['location']; // Radio button value
        $delivery_charge = $delivery_location === 'inside' ? 100 : 300;
        $grand_total = $total_price + $delivery_charge;
        $delivery_place = $_POST['delivery_address']; // Text input value
    
        // Insert order into the orders table
        $order_query = "INSERT INTO orders (user_id, total_amount, delivery_charge, location, place) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $order_query);
    
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($con)); // Debugging in case of prepare failure
        }
    
        mysqli_stmt_bind_param($stmt, "idsss", $user_id, $grand_total, $delivery_charge, $delivery_location, $delivery_place);
    
        if (!mysqli_stmt_execute($stmt)) {
            die("Execute failed: " . mysqli_error($con)); // Debugging in case of execute failure
        }
    
        $order_id = mysqli_stmt_insert_id($stmt);
    
        // Insert order items into order_items table
        foreach ($cart_items as $id => $item) {
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_item = mysqli_prepare($con, $item_query);
            mysqli_stmt_bind_param($stmt_item, "iiid", $order_id, $id, $item['quantity'], $item['price']);
            mysqli_stmt_execute($stmt_item);
        }
    
        // Store order ID and prepare for payment
        $_SESSION['order_id'] = $order_id;
        $_SESSION['grand_total'] = $grand_total;
    
        // Redirect to payment page
        
    echo "<script>window.location.href = 'fee.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="checkout.css" rel="stylesheet">
    

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
    <form method="POST" action="checkout.php">
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
                <tr>
                    <td colspan="3"><label for="delivery-location">Delivery Address:</label></td>
                    <td><input type="text" id="delivery-location" name="delivery_address" placeholder="Enter delivery address" class="form-control" required></td>
                </tr>
                <tr>
                    <td colspan="4"><h4>Delivery Options</h4></td>
                </tr>
                <tr>
                    <td colspan="4">
                    <label class="delivery-option">
    <input type="radio" name="location" value="inside"> Inside Valley (Delivery Charge: $100)
</label><br>
<label class="delivery-option">
    <input type="radio" name="location" value="outside"> Outside Valley (Delivery Charge: $300)
</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Delivery Charge</strong></td>
                    <td><strong>$<span id="delivery-charge">0.00</span></strong></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Grand Total</strong></td>
                    <td><strong>$<span id="grand-total"><?= number_format($total_price, 2) ?></span></strong></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success mt-3">Place Order</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Update delivery charge and grand total based on delivery option selection
    function updateDeliveryOptions() {
        let subtotal = <?= $total_price ?>;
        let deliveryCharge = 0;
        let grandTotal = subtotal;

        if (subtotal < 50000) {
            // Enable delivery options
            $('input[name="location"]').prop('disabled', false);
            $('label.delivery-option').removeClass('disabled').attr('title', '');
            // Apply delivery charge based on selection
            deliveryCharge = $('input[name="location"]:checked').val() === 'inside' ? 100 : 300;
            grandTotal += deliveryCharge;
        } else {
            // Disable delivery options and show a disabled message
            $('input[name="location"]').prop('checked', false).prop('disabled', true);
            $('label.delivery-option')
                .addClass('disabled')
                .attr('title', 'Delivery is free for orders above $50,000');
            deliveryCharge = 0; // No delivery charge
            grandTotal = subtotal; // Only subtotal
        }

        // Update the delivery charge and grand total in the UI
        $('#delivery-charge').text(deliveryCharge.toFixed(2));
        $('#grand-total').text(grandTotal.toFixed(2));
    }

    // Trigger update on page load and when delivery option changes
    $(document).ready(function () {
        updateDeliveryOptions();
        $('input[name="location"]').change(updateDeliveryOptions);
    });
</script>



</body>
</html>
