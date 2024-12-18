<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'Login/login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_prepare($con, "SELECT username, email, number, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($query));
mysqli_stmt_close($query);

$cart_items = $_SESSION['cart'] ?? [];
$total_price = array_reduce($cart_items, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'];
    $delivery_charge = $location === 'inside' ? 100 : 300;
    $grand_total = $total_price + $delivery_charge;
    $payment_token = $_POST['payment_token'];

    // Payment verification with Khalti
    $url = "https://khalti.com/api/v2/payment/verify/";
    $data = ['token' => $payment_token, 'amount' => $grand_total * 100]; // Amount in paise
    $headers = ["Authorization: da28dfa4add04582ac5deaa8d3cb4821"]; // Replace with your Khalti secret key

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    if (isset($responseData['idx'])) {  // If payment is successful
        $order_query = "INSERT INTO orders (user_id, total_amount, delivery_charge, location) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $order_query);
        mysqli_stmt_bind_param($stmt, "idss", $user_id, $grand_total, $delivery_charge, $location);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($con);
        mysqli_stmt_close($stmt);

        foreach ($cart_items as $id => $item) {
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_item = mysqli_prepare($con, $item_query);
            mysqli_stmt_bind_param($stmt_item, "iiid", $order_id, $id, $item['quantity'], $item['price']);
            mysqli_stmt_execute($stmt_item);
            mysqli_stmt_close($stmt_item);
        }

        unset($_SESSION['cart']);
        $_SESSION['order_id'] = $order_id;
        header("Location: order_confirmation.php");
        exit();
    } else {
        echo "<script>alert('Payment verification failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2e2e2e;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #444;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>
<body>

<div class="container">
    <h2>Checkout</h2>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['number']) ?></p>
    <p><strong>Cart Total:</strong> NPR <?= number_format($total_price, 2) ?></p>

    <form method="POST">
        <h3>Delivery Options</h3>
        <input type="radio" name="location" value="inside" required> Inside Valley (Delivery: NPR 100)<br>
        <input type="radio" name="location" value="outside"> Outside Valley (Delivery: NPR 300)<br><br>

        <button type="button" class="btn btn-primary" id="pay-btn">Pay with Khalti</button>
        <input type="hidden" name="payment_token" id="payment-token">
        <button type="submit" class="btn btn-success">Place Order</button>
    </form>
</div>

<script>
    const config = {
        publicKey: "979fb111ec03497486249ee3296cb5a1", // Replace with your Khalti public key
        productIdentity: "1234567890",
        productName: "E-commerce Checkout",
        eventHandler: {
            onSuccess(payload) {
                document.getElementById("payment-token").value = payload.token;
                alert("Payment successful! Complete the order now.");
            },
            onError(error) {
                alert("Payment error: " + error.message);
            },
            onClose() {
                console.log("Payment widget closed");
            }
        }
    };

    const checkout = new KhaltiCheckout(config);
    document.getElementById("pay-btn").onclick = () => checkout.show({ amount: <?= $total_price ?> * 100 }); // Multiply by 100 as Khalti expects the amount in paise
</script>

</body>
</html>
