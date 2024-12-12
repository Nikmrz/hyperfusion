<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to fetch order details for the logged-in user
$query = "
    SELECT 
        o.id AS order_id, 
        oi.product_id, 
        oi.quantity, 
        o.total_amount, 
        g.name AS product_name, 
        o.order_date,
        o.payment_method,
        o.payment_status
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN gamedetails g ON oi.product_id = g.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display the orders
if (mysqli_num_rows($result) > 0): ?>
    <div class="order-history">
        <h3>Your Order History</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>method</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['total_amount']) ?></td>
                        <td><?= htmlspecialchars(date("F j, Y, g:i a", strtotime($row['order_date']))) ?></td>
                        <td><?= htmlspecialchars($row['payment_method']) ?></td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>
