<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gym_management';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete'])) {
    $email = $_POST['email'];
    $email = $conn->real_escape_string($email);
    $sql = "DELETE FROM tbl_register WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Registration</title>
</head>
<body>
    <h2>Delete Registration</h2>
    <form action="delete_registration.php" method="POST">
        <label for="email">Enter Email to Delete Registration:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit" name="delete">Delete</button>
    </form>
</body>
</html>
