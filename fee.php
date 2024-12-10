<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = mysqli_prepare($con, "SELECT username, email, number, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

// Retrieve cart items
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Retrieve delivery location and calculate charges
$delivery_charge = isset($_POST['location']) && $_POST['location'] === 'inside' ? 100 : 300;
$grand_total = $total_price + $delivery_charge;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart Checkout</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="checkout.css" rel="stylesheet">
   
</head>
<body>

<div class="container">
    <h2 class="text-center text-white">Checkout</h2>
    
    <!-- User Information -->
    <div class="summary">
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

    <!-- Payment Options -->
    <div class="payment-options">
        <h4>Payment Method</h4>
        <form method="POST" action="fee.php">
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="delivery_charge" value="<?= $delivery_charge ?>">
            <label>Select Payment Method:</label><br>
            <input type="radio" name="payment_method" value="khalti" required> Khalti Wallet<br>
            <input type="radio" name="payment_method" value="cod"> Cash on Delivery<br>
            
            <button type="button" id="payment-button" class="btn btn-success mt-3">Pay with Khalti</button>
        </form>
    </div>
</div>

<!-- Include Khalti Checkout Script -->
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<script>
    var config = {
        "publicKey": "test_public_key_cacd684b8cd342c2b7613287c5670fe6",
        "productIdentity": "1234567890",
        "productName": "Cart Purchase",
        "productUrl": "https://yourwebsite.com/fee",
        "paymentPreference": ["KHALTI"],
        "eventHandler": {
            onSuccess(payload) {
                var paymentAmount = <?= $grand_total ?>;
                var mode = 'khalti';
                var transactionDate = new Date().toISOString().slice(0, 10); // Get current date in YYYY-MM-DD format

                // Prepare form data to be sent to the server
                var formData = new FormData();
                formData.append('fee_amount', paymentAmount);
                formData.append('mode_of_payment', mode);
                formData.append('transaction_date', transactionDate);
                formData.append('transaction_id', payload.idx); // Transaction ID from Khalti

                // AJAX request to save payment data
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'insert_admitted_users.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert("Payment Success. Your purchase has been confirmed.");
                        window.location.href = "paymentSuccess.php";
                    } else {
                        alert("An error occurred. Please contact support.");
                        window.location.href = "fee.php";
                    }
                };
                xhr.onerror = function() {
                    alert("An error occurred. Please contact support.");
                    window.location.href = "fee.php";
                };
                xhr.send(formData);
            },
            onError (error) {
                alert("Payment failed. Please try again.");
                window.location.href = "fee.php";
            },
            onClose () {
                console.log('Widget is closing');
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById('payment-button');
    btn.onclick = function () {
        checkout.show({amount: <?= $grand_total * 100 ?>});
    }
</script>

</body>
</html>
