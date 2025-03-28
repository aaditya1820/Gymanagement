<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_management";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['submit'])) {
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $name = $_POST['reg_name'];
    $age = $_POST['reg_age'];

    $check_email_query = "SELECT * FROM tbl_register WHERE email = '$email'";
    $check_email_result = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $message = "Error: This email is already registered. Please use a different email.";
    } else {
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $password)) {
            $encrypted_password = md5($password);

            $sql = "INSERT INTO tbl_register (email, password, name, age) VALUES ('$email', '$encrypted_password', '$name', '$age')";

            if (mysqli_query($con, $sql)) {
                $_SESSION['username'] = $name;
                $_SESSION['message'] = "Registration successful!";
                header('Location: login1.php');
                exit();
            } else {
                $message = "Error: " . mysqli_error($con);
            }
        } else {
            $message = "Error: Password must be at least 8 characters long and include at least one letter and one number.";
        }
    }
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LivingWell - Register</title>
  <link rel="stylesheet" href="style.css">
  <script>
  function showMessage() {
      var message = <?php echo json_encode($message); ?>;
      if (message) {
          alert(message);
      }
  }
  window.onload = showMessage;
  </script>
</head>
<body>
  <form name="frmreg" method="POST">
    <div class="wrapper">
      <h2>Register</h2>
      <div class="input-field">
        <input type="email" name="reg_email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="reg_password" required>
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="text" name="reg_name" pattern="[A-Za-z ]{1,32}" required>
        <label>Enter your name</label>
      </div>
      <div class="input-field">
        <input type="number" min="15" name="reg_age" required>
        <label>Enter your Age</label>
      </div>
      <button type="submit" name="submit">Register</button>
    </div>
  </form>
</body>
</html>
