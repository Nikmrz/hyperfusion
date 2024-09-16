<?php
session_start();
error_reporting(0);
require_once 'vendor/autoload.php'; // Ensure your Composer autoload path is correct

// Database connection
$con = mysqli_connect("localhost", "root", "", "hyperfusion");
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}

// Google OAuth2 credentials
$clientID = '459453628228-rh7ile4lglmcan49p4rm3aibrt9ltcaj.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/hyperfusion/login.php';

// reCAPTCHA secret key
$recaptcha_secret = 'YOUR_RECAPTCHA_SECRET_KEY';

// Google OAuth2 Client Setup
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Handle Google OAuth login
if (isset($_GET['action']) && $_GET['action'] == 'google') {
    header('Location: ' . $client->createAuthUrl());
    exit();
}

// Handle Google OAuth callback
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Fetch user info from Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Optionally create or log in the user in your DB
    $_SESSION['user'] = $email;
    header('Location: index.php');
    exit();
}

// Handle normal login and reCAPTCHA verification
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];
    $recaptcha_secret = '6LcaI2kpAAAAAKW_HDMxIeenop4kGVE0e_msA2gv';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    
    
    // Verify Google reCAPTCHA
    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $verify_response = file_get_contents($verify_url);
    $verify_data = json_decode($verify_response);

    if ($verify_data->success) {
        // reCAPTCHA success, proceed with normal login
        $query = mysqli_query($con, "SELECT ID, email, password FROM users WHERE email='$email'");
        $result = mysqli_fetch_assoc($query);

        if ($result && password_verify($enteredPassword, $result['password'])) {
            // Valid credentials, start session
            $_SESSION['uid'] = $result['ID'];
            $_SESSION['email'] = $result['email'];
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        echo "<script>alert('reCAPTCHA verification failed');</script>";
    }
}
?>
