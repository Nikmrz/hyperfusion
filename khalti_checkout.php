<?php
session_start();
include 'db.php';

// Verify session data
if (!isset($_SESSION['order_id'], $_SESSION['grand_total'])) {
    echo "<script>alert('Invalid session.'); window.location.href = 'checkout.php';</script>";
    exit();
}

$order_id = htmlspecialchars($_SESSION['order_id'], ENT_QUOTES, 'UTF-8');
$amount = intval($_SESSION['grand_total']);


  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "return_url": "http://localhost/hyperfusion/order-summary.php",
  "website_url": "https://example.com/",
  "amount": "100000",
  "purchase_order_id": "Order01",
      "purchase_order_name": "test",
  "customer_info": {
      "name": "Test Bahadur",
      "email": "test@khalti.com",
      "phone": "9800000001",
      "otp": "987654"
  }
  }
  ',
  CURLOPT_HTTPHEADER => array(
      'Authorization: Key 8dc76783e29644928eeeee3e3b57cdc5',
      'Content-Type: application/json',
  ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;
  $responseData = json_decode($response, true);
  header("Location: " . $responseData['payment_url']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Khalti Checkout</title>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #242424;
        }

        .container {
            text-align: center;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            height: 300px;
            width: 400px;
        }

        button {
            padding: 10px 20px;
            font-size: 23px;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            height: 80px;
            width: 300px;
        }

        button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="assets/images/khalti.png" height="100px" width="200px">
    <h2>Proceed to Khalti?</h2>
    <button id="payment-button">Pay with Khalti</button>
</div>

</body>
</html>
