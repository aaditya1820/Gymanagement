<?php 
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'gym_management');
if (mysqli_connect_errno()) {
    echo "failed";
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livingWell</title>
</head>
<body>
    <form action="" method="POST">
        <label for="">Enter Registered email</label>
        <input type="email" name="email" id="" required><br>
        <input type="submit" name="submit" value="submit">
        <?php 
        if(isset($_POST["email"]))
        {
           
           
            $query="select email from register where email='".$_POST["email"]."'";
            $result=mysqli_query($conn,$query);

            if($result->num_rows>0)
            {
                $_SESSION["email"]=$_POST["email"];
                $_SESSION["url"]="forget.php";
                echo "<script>window.location='otp.php'</script>";
            }
            else
            {
                echo "<script>alert('email is not registered in the system')</script>";
            }
            
        }
    ?>
    </form>
    
</body>
</html>