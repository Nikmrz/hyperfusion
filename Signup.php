<?php 
    include 'db.php';

    $recaptcha_secret = '6LcaI2kpAAAAAKW_HDMxIeenop4kGVE0e_msA2gv';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $verify_response = file_get_contents($verify_url);
    $verify_data = json_decode($verify_response);

    function validateFullname($fullname) {
        // Check if the full name has at least 2 words and the first name is valid
        return preg_match('/^[A-Z][a-zA-Z]{2,}/', strtok($fullname, ' ')) && str_word_count($fullname) >= 2;
    }
    
    
    function validateNumber($number) {
        return preg_match('/^9\d{9}$/', $number);
    }
    
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@gmail\.com$/', $email);
    }

    if ($verify_data->success) {
        if(isset($_POST['submit']))
        {
            $fullname=$_POST['fullname'];
            $number=$_POST['number'];
            $email=$_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if (!validateFullname($fullname)) {
                echo "<script>alert('Fullname should be greater than 3 words, start with a capital letter, and cannot contain numbers');</script>";
                echo "<script>window.location.href ='Signup.html'</script>";
                exit();
            }
    
            if (!validateNumber($number)) {
                echo "<script>alert('Number should start with 9 and be 10 digits long');</script>";
                echo "<script>window.location.href ='Signup.html'</script>";
                exit();
            }
    
            if (!validateEmail($email)) {
                echo "<script>alert('Email should be a valid Gmail address');</script>";
                echo "<script>window.location.href ='Signup.html'</script>";
                exit();
            }    

            $stmt = mysqli_prepare($con, "SELECT email FROM users WHERE email=? OR number=?");
            mysqli_stmt_bind_param($stmt, "ss", $email, $number);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_num_rows($stmt);
            if ($result !== false && $result > 0) {
                // Existing email or number found
                echo "<script>alert('This email or Contact Number already associated with another account');</script>";
                echo "<script>window.location.href ='Signup.html'</script>";
            }        
            else
            {
            $query=mysqli_query($con, "INSERT INTO users (fullname,number,email,password) VALUE('$fullname','$number','$email','$password')");
                if ($query) {
                echo "<script>alert('You have successfully registered');</script>";
                echo "<script>window.location.href ='Login.html'</script>";
                }else{
                echo "<script>alert('Something Went Wrong. Please try again');</script>";
                echo "<script>window.location.href ='Signup.html'</script>";
                }
            }
        }
    }else {
        // CAPTCHA verification failed, handle accordingly
        echo  "<script>alert('Captcha verification failed');</script>";
        echo "<script>window.location.href ='Login.html'</script>";
    }
 ?>
