<?php 
        session_start();

        if (isset($_POST['btnsubmit'])) {
            $email = $_POST['email'];
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            $subject = "Your OTP Code";
            $message = "Your OTP code is $otp";
            $headers = "From: 22bmiit188@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                header('Location: validate_otp.php');
            } else {
                echo "Failed to send OTP. Please try again.";
            }
        }
    ?>