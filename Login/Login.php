<?php
session_start();

require_once 'vendor/autoload.php'; // Make sure this path is correct for Google API

// Database connection
$con = mysqli_connect("localhost", "root", "", "hyperfusion");
if (mysqli_connect_errno()) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Google OAuth2 credentials
$clientID = '459453628228-rh7ile4lglmcan49p4rm3aibrt9ltcaj.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/hyperfusion/login.php';

// reCAPTCHA secret key
$recaptcha_secret = '6LcaI2kpAAAAAKW_HDMxIeenop4kGVE0e_msA2gv';

// Google OAuth2 Client Setup
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Handle Google OAuth login
if (isset($_GET['action']) && $_GET['action'] === 'google') {
    header('Location: ' . $client->createAuthUrl());
    exit();
}

// Handle Google OAuth callback
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        echo "<script>alert('Authentication failed. Please try again.');</script>";
        exit();
    }

    $client->setAccessToken($token['access_token']);
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    $query = mysqli_prepare($con, "SELECT id, email FROM users WHERE email = ?");
    mysqli_stmt_bind_param($query, "s", $email);
    mysqli_stmt_execute($query);
    mysqli_stmt_store_result($query);

    if (mysqli_stmt_num_rows($query) > 0) {
        mysqli_stmt_bind_result($query, $user_id, $email);
        mysqli_stmt_fetch($query);
    } else {
        $insert_query = mysqli_prepare($con, "INSERT INTO users (username, email) VALUES (?, ?)");
        mysqli_stmt_bind_param($insert_query, "ss", $name, $email);
        mysqli_stmt_execute($insert_query);
        $user_id = mysqli_insert_id($con);
        mysqli_stmt_close($insert_query);
    }
    mysqli_stmt_close($query);

    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;

    header('Location: ../profile.php');
    exit();
}

// Handle normal login and reCAPTCHA verification
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    $response = curl_init();
    curl_setopt($response, CURLOPT_URL, $verify_url);
    curl_setopt($response, CURLOPT_POST, 1);
    curl_setopt($response, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response,
    ]));
    curl_setopt($response, CURLOPT_RETURNTRANSFER, true);
    $verify_response = curl_exec($response);
    curl_close($response);
    $verify_data = json_decode($verify_response);

    if ($verify_data->success) {
        $query = mysqli_prepare($con, "SELECT id, username, email, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($query, "s", $email);
        mysqli_stmt_execute($query);
        mysqli_stmt_bind_result($query, $user_id, $username, $db_email, $hashed_password);
        mysqli_stmt_fetch($query);

        if ($user_id && password_verify($enteredPassword, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $db_email;

            header('Location: ../profile.php');
            exit();
        } else {
            echo "<script>alert('Invalid email or password');</script>";
            echo "<script>window.location.href='login.html';</script>";
                exit(); 
        }
        mysqli_stmt_close($query);
    } else {
        echo "<script>alert('reCAPTCHA verification failed');</script>";
        echo "<script>window.location.href='login.html';</script>";
                exit(); 
    }
}
?>
