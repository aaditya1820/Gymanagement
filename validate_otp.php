<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <title>Validate OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://wallpaperaccess.com/full/4722389.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            color: #ffcc00;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }
        form {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }
        label {
            color: #ffcc00;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: white;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #ffcc00;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #ffaa00;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div>
    <?php
    session_start();

    $con = mysqli_connect("localhost", "root", "", "gym_management");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['validateOtp'])) {
        $otp = $_POST['otp'];

        if ($_SESSION['otp'] == $otp) {
            $_SESSION['otp_validated'] = true;
            echo "<p class='message' style='color: #00ff00;'>OTP validation confirmed. Please reset your password below.</p>";
        } else {
            echo "<p class='message' style='color: red;'>Invalid OTP. Please try again.</p>";
            $_SESSION['otp_validated'] = false;
        }
    }

    if (isset($_SESSION['otp_validated']) && $_SESSION['otp_validated'] === true) {
    ?>
        <form method="POST">
            <label for="password">New Password:</label>
            <input type="password" name="password" required>

            <label for="conpassword">Confirm New Password:</label>
            <input type="password" name="conpassword" required>

            <button type="submit" name="resetPassword">Reset Password</button>
        </form>
    <?php
    } else {
    ?>
        <form method="POST">
            <h2>Validate OTP</h2>
            <label for="otp">OTP:</label>
            <input type="text" name="otp" required maxlength="6" value="<?php echo isset($_POST['otp']) ? htmlspecialchars($_POST['otp']) : ''; ?>">
            <button type="submit" name="validateOtp">Validate OTP</button>
        </form>
    <?php
    }

    if (isset($_POST['resetPassword']) && isset($_SESSION['otp_validated']) && $_SESSION['otp_validated'] === true) {
        $password = $_POST['password'];
        $conpassword = $_POST['conpassword'];

        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            if ($password === $conpassword) {
                $hashedPassword = md5($password);

                $email = $_SESSION['email'];
                $sql = "UPDATE tbl_register SET password='$hashedPassword' WHERE email='$email';";

                if (mysqli_query($con, $sql)) {
                    echo "<p class='message' style='color: #00ff00;'>Password has been reset successfully.</p>";
                    unset($_SESSION['otp_validated']);
                } else {
                    echo "<p class='message' style='color: red;'>Error updating password: " . mysqli_error($con) . "</p>";
                }
            } else {
                echo "<p class='message' style='color: red;'>Passwords do not match. Please try again.</p>";
            }
        } else {
            echo "<p class='message' style='color: red;'>Password must be at least 8 characters long and include at least one letter and one number.</p>";
        }
    }

    mysqli_close($con);
    ?>
    </div>
</body>
</html>
