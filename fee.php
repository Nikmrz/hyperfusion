<?php
include 'db.php';

// Decode JSON input from frontend
$data = json_decode(file_get_contents("php://input"), true);

// Validate incoming data
if ($data === null || !isset($data['token'], $data['amount'], $data['product_identity'])) {
    error_log('Invalid data received: ' . print_r($data, true));
    echo json_encode(['status' => false, 'message' => 'Invalid data']);
    exit();
}

// Extract required fields
$token = $data['token'];
$amount = $data['amount'];
$product_identity = $data['product_identity'];

// Initialize cURL for payment verification with Khalti
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://khalti.com/api/v2/payment/verify/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'token' => $token,
        'amount' => $amount,
    ]),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Key da28dfa4add04582ac5deaa8d3cb4821', // Replace with your test/live key
        'Content-Type: application/x-www-form-urlencoded',
    ),
));

$response = curl_exec($curl);
curl_close($curl);

$responseData = json_decode($response, true);

// Handle Khalti API response
if (isset($responseData['idx']) && $responseData['state']['name'] === 'Completed') {
    // Log success response
    error_log('Payment verified successfully: ' . print_r($responseData, true));

    // Update transaction in the database
    $transaction_id = $responseData['idx'];
    $update_query = "UPDATE transactions SET transaction_id = ?, payment_status = 'Completed' WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "ss", $transaction_id, $product_identity);
    mysqli_stmt_execute($stmt);

    echo json_encode(['status' => true, 'message' => 'Payment Verified Successfully']);
} else {
    // Log error response
    error_log('Payment verification failed: ' . print_r($responseData, true));
    echo json_encode(['status' => false, 'message' => 'Payment Verification Failed']);
    exit();
}
?>
