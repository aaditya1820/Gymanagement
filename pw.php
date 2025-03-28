<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <title>Forgot Password</title>
    <style>
        body {
            background-image: url('https://wallpaperaccess.com/full/4722389.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }
        input[type="email"], button {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: none;
            width: 100%;
        }
        button {
            background-color: #ffcc00;
            color: black;
            cursor: pointer;
        }
        button:hover {
            background-color: #ffcc00;
        }
        table {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST">
        <table>
            <tr>
                <td><label for="email">Email: </label></td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" name="btnsubmit">Send OTP</button></td>
            </tr>
        </table>
    </form>
    
    <?php
    session_start();
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'gym_management';
    $con = mysqli_connect($host, $username, $password, $database);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['btnsubmit'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $query = "SELECT * FROM tbl_register WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
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
        } else {
            echo "This email is not registered. Please enter a registered email address.";
        }
    }
    mysqli_close($con);
    ?>
</body>
</html>
