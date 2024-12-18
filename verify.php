<?php
// Replace with your Khalti Secret Key
$secret_key = "da28dfa4add04582ac5deaa8d3cb4821";

$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'];
$amount = $data['amount'];

$url = "https://khalti.com/api/v2/payment/verify/";

$args = http_build_query(array(
    'token' => $token,
    'amount' => $amount
));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = ["Authorization: Key $secret_key"];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status_code == 200) {
    $response_data = json_decode($response, true);
    if (isset($response_data['idx'])) {
        echo json_encode(["success" => true, "message" => "Payment verified successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid Payment Data!"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Payment verification failed."]);
}
?>
