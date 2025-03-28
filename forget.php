<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'gym_management');
if (mysqli_connect_errno()) {
    echo "failed";
} else {
    echo "";
}
if (isset($_POST['forget'])) {
    // $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    // $cpass = $_POST['cpass'];
   
    // if ($pass != $cpass) {
    //     $err[] = 'password does not matches';
    // }
     
            $email=$_SESSION['email'];
            $update = "update register set pass='".$_POST['pass']."' where email='$email'";
            mysqli_query($conn, $update);
            header('location:login1.php');
            exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget password</title>

  
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    
    <link rel="stylesheet" href="style1.css">
</head>
<body>

    

        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="forget.gif" alt="sing up image"></figure>
                     
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">forget password</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <!-- <div class="form-group">
                                <label for="your_name"></label>
                                <input type="text" name="your_name" id="your_name" placeholder="otp"/>
                            </div> -->
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="your_pass" placeholder="Password"/>
                            </div>
                            <!-- <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="your_pass" placeholder="Password"/>
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="cpass" id="your_pass" placeholder="reenter Password"/>
                            </div> -->
                            
                             <div class="form-group form-button">
                                <input type="submit" name="forget" id="signin" class="form-submit" value="change password"/>
                            </div> 
                        </form>
                       
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

