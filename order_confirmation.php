<?php
session_start();

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

// Check if order ID is available (e.g., passed via URL or session after checkout)
if (!isset($_SESSION['order_id'])) {
    echo "<script>alert('No order found.'); window.location.href = 'index.php';</script>";
    exit();
}

$order_id = $_SESSION['order_id'];
unset($_SESSION['order_id']); // Clear order ID from session after use

// Fetch order details
$orderQuery = mysqli_prepare($con, "
    SELECT o.total_amount, o.delivery_charge, o.location, o.order_date, u.username, u.email, u.number
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
");
mysqli_stmt_bind_param($orderQuery, "i", $order_id);
mysqli_stmt_execute($orderQuery);
$orderResult = mysqli_stmt_get_result($orderQuery);
$order = mysqli_fetch_assoc($orderResult);

// Fetch order items
$itemsQuery = mysqli_prepare($con, "
    SELECT oi.quantity, oi.price, g.name
    FROM order_items oi
    JOIN gamedetails g ON oi.product_id = g.id
    WHERE oi.order_id = ?
");
mysqli_stmt_bind_param($itemsQuery, "i", $order_id);
mysqli_stmt_execute($itemsQuery);
$itemsResult = mysqli_stmt_get_result($itemsQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e1e;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background-color: #2e2e2e;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
        }
        .card-header, .card-footer {
            background-color: #444;
            font-weight: bold;
            text-align: center;
        }
        .table {
            color: #fff;
        }
        .table th, .table td {
            text-align: center;
            padding: 10px;
            border: none;
        }
        .total-row {
            font-size: 1.2em;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Order Confirmation</h2>
            <p>Order #<?php echo $order_id; ?> | Date: <?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Customer Information</h5>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['number']); ?></p>

            <h5 class="mt-4 mb-3">Order Summary</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Game Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandTotal = 0;
                    while ($item = mysqli_fetch_assoc($itemsResult)) {
                        $itemTotal = $item['price'] * $item['quantity'];
                        $grandTotal += $itemTotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo number_format($itemTotal, 2); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="total-row">
                        <td colspan="3">Subtotal</td>
                        <td><?php echo number_format($grandTotal, 2); ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">Delivery Charge</td>
                        <td><?php echo number_format($order['delivery_charge'], 2); ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">Grand Total</td>
                        <td><?php echo number_format($grandTotal + $order['delivery_charge'], 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-4 mb-3">Delivery Information</h5>
            <p>Location: <?php echo ($order['location'] == 'inside') ? "Inside Valley" : "Outside Valley"; ?></p>
        </div>
        <div class="card-footer">
            <p>Thank you for your purchase! Your order is being processed and will be shipped soon.</p>
        </div>
    </div>
    <div class="footer text-muted">
        <p>&copy; 2036 Cyborg Gaming Company. All rights reserved.</p>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
