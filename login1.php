<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'gym_management');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$err = array();

if (isset($_POST['logsubmit'])) {
  $email = $_POST['logemail'];
  $pass = $_POST['logpassword'];

  if ($email == "admin@gmail.com" && $pass == "Admin187") {
    $_SESSION["name"] = "Admin";
    header('Location: nevigation_page.php');
    exit();
  }

  if ($email == "Trainer76@gmail.com" && $pass == "Trainer7670") {
    $_SESSION["name"] = "Trainer";
    header('Location: trainer_page.php');
    exit();
  }

  if (preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $pass)) {
    $stmt = $conn->prepare("SELECT * FROM tbl_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashedPassword = md5($pass);

      if ($hashedPassword == $row['password']) {
        $_SESSION["name"] = $row['username'];
        header('Location: customerpanel.php');
        exit();
      } else {
        $err[] = 'Incorrect password. Please try again.';
      }
    } else {
      $err[] = 'Email does not exist.';
    }
    $stmt->close();
  } else {
    $err[] = 'Password must be at least 8 characters long and include at least one letter and one number.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
  <script language="javascript" type="text/javascript">
        window.history.forward();
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>livingWell</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <form method="POST">
      <h2>Login</h2>
      <?php
          if (isset($err)) {
            foreach ($err as $errMsg) {
              echo '<span style="color:white;" class="err-msg">' . $errMsg . '</span>';
            }
          }
      ?>
      <div class="input-field">
        <input type="email" name="logemail" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="logpassword" required>
        <label>Enter your password</label>
      </div>
      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Remember me</p>
        </label>
        <a href="pw.php">Forgot password?</a>
      </div>
      <button type="submit" name="logsubmit">Log In</button>

      <div class="register">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>
