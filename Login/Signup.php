<?php 
  $con = mysqli_connect("localhost", "root", "", "hyperfusion");
  if (mysqli_connect_errno()) {
      die("Database Connection Failed: " . mysqli_connect_error());
  }
  
    $recaptcha_secret = '6LcaI2kpAAAAAKW_HDMxIeenop4kGVE0e_msA2gv';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $verify_response = file_get_contents($verify_url);
    $verify_data = json_decode($verify_response);

    function validateFullname($fullname) {
        return preg_match('/^[A-Z][a-zA-Z ]{2,}/', $fullname) && str_word_count($fullname) >= 2;
    }
    
    function validateNumber($number) {
        return preg_match('/^9\d{9}$/', $number);
    }
    
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@gmail\.com$/', $email);
    }
    
    if ($verify_data->success) {
        if (isset($_POST['submit'])) {
            $fullname = $_POST['fullname'];
            $number = $_POST['number'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
            if (!validateFullname($fullname)) {
                echo "<script>alert('Full name should start with a capital letter and contain at least 2 words');</script>";
                echo "<script>window.location.href ='register.html'</script>";
                exit();
            }
    
            if (!validateNumber($number)) {
                echo "<script>alert('Phone number should start with 9 and be 10 digits long');</script>";
                echo "<script>window.location.href ='register.html'</script>";
                exit();
            }
    
            if (!validateEmail($email)) {
                echo "<script>alert('Email should be a valid Gmail address');</script>";
                echo "<script>window.location.href ='register.html'</script>";
                exit();
            }
    
            // Check for existing email or number
            $stmt = mysqli_prepare($con, "SELECT email FROM users WHERE email=? OR number=?");
            mysqli_stmt_bind_param($stmt, "ss", $email, $number);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_num_rows($stmt);
            if ($result > 0) {
                echo "<script>alert('This email or phone number is already associated with another account');</script>";
                echo "<script>window.location.href ='register.html'</script>";
            } else {
                $query = mysqli_query($con, "INSERT INTO users (username, number, email, password) VALUES ('$fullname', '$number', '$email', '$password')");
                if ($query) {
                    echo "<script>alert('You have successfully registered');</script>";
                    echo "<script>window.location.href ='login.html'</script>";
                } else {
                    echo "<script>alert('Something went wrong. Please try again');</script>";
                    echo "<script>window.location.href ='register.html'</script>";
                }
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "<script>alert('CAPTCHA verification failed');</script>";
        echo "<script>window.location.href ='register.html'</script>";
    }
    ?>