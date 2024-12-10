<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data for review submission
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $review = mysqli_real_escape_string($con, $_POST['review']);

    // Check if review fields are empty
    if (empty($name) || empty($email) || empty($review)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href='index.php';</script>";
        exit();
    }

    // Insert review into the database
    $query = "INSERT INTO reviews (name, email, review) VALUES ('$name', '$email', '$review')";
    if (mysqli_query($con, $query)) {
        // Send email after successful review submission
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        try {
            // Mail configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sanirmrz2060@gmail.com'; // Use your email
            $mail->Password = 'iuefxrsyphofhytr'; // Use an app password if 2FA is enabled
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set the sender and recipient
            $mail->setFrom('sanirmrz2060@gmail.com', 'HYPER FUSION');
            $mail->addAddress($email, $name); // Send email to the reviewer's email

            // Content
            $mail->isHTML(true);
            $mail->AddEmbeddedImage('assets/images/newlogo.png', 'logo_cid'); 
            $mail->Subject = 'Thank you for your review!';
            $mail->Body = "
            <html>
            <body>
            <p>Dear <strong>$name</strong>,</p>
            
            <p>Thank you for taking the time to share your feedback with us. We truly value your input and appreciate your review.</p>
            
            <p><strong>Here’s a summary of your review:</strong></p>
            <p><strong>$review</strong></p>  
            
            <p>Your concerns have been noted, and we want to assure you that our team is working hard to address them. Our customer support team will be reaching out to you shortly via email to provide further assistance.</p>
            
            <p>In the meantime, should you have any additional questions or need immediate support, please don't hesitate to contact us at:</p>
            <p><strong>+977 9865585184</strong></p>  
            
            <p>or visit our website at:</p>
            <p><strong><a href='http://www.hyperfusion.com.np' target='_blank'>www.hyperfusion.com.np</a></strong></p> 
            
            <p>We are committed to improving your experience with us and appreciate your continued trust.</p>
            
            <p>Best regards,<br><strong>Admin</strong><br>HYPER FUSION</p>
            <p><img src='cid:logo_cid' alt='Logo' /></p>
            </body>
            </html>
            ";
            

            // Send email
            $mail->send();

            // Success message
            echo "<script>alert('Review submitted successfully! We have sent you a confirmation email.'); window.location.href='index.php';</script>";
        } catch (Exception $e) {
            // Error message if email could not be sent
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Error submitting review.'); window.location.href='index.php';</script>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>
