<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LivingWell - AdminPanel</title>
    <style>
        .details-output {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            display: block;
        }
        .error {
            color: red;
        }
        .form-section {
            margin-top: 30px;
        }
    </style>
</head>
<body>
  <p><h1>WELCOME TO LIVING WELL GYM - ADMIN PANEL</h1></p>

<div class="main">
    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gym_management";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $customer_output = "";
    $trainer_output = "";
    $package_output = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
        $contact = $conn->real_escape_string(trim($_POST['contact']));

        $query = "SELECT * FROM tbl_user WHERE contact_number = '$contact'";
        $result = $conn->query($query);

        if ($result === false) {
            $customer_output = "Error in SQL query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                $customer = $result->fetch_assoc();
                $customer_output = "<div class='details-output'>
                                    <strong>Customer details are:</strong><br>
                                    <strong>Name:</strong> " . htmlspecialchars($customer['name']) . "<br>
                                    <strong>Email:</strong> " . htmlspecialchars($customer['email']) . "<br>
                                    <strong>Age:</strong> " . htmlspecialchars($customer['age']) . "<br>
                                    <strong>Height:</strong> " . htmlspecialchars($customer['height']) . " cm<br>
                                    <strong>Weight:</strong> " . htmlspecialchars($customer['weight']) . " kg<br>
                                    <strong>Blood Group:</strong> " . htmlspecialchars($customer['bloodgroup']) . "<br>
                                    <strong>Address:</strong> " . htmlspecialchars($customer['address']) . "<br>
                                    <strong>Contact:</strong> " . htmlspecialchars($customer['contact_number']) . "
                                  </div>";
            } else {
                $customer_output = '<div class="details-output error">No customer found with this contact number.</div>';
            }
        }
    }

    echo '<div class="form-section">
            <h2>Customer Details</h2>
            <form method="POST" action="">
                <input type="text" name="contact" placeholder="Enter customer contact number" required />
                <button type="submit">Fetch Details</button>
            </form>
            ' . $customer_output . '
          </div>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trainer_contact'])) {
        $trainer_contact = $conn->real_escape_string(trim($_POST['trainer_contact']));

        $query = "SELECT * FROM tbl_trainers WHERE contact = '$trainer_contact'";
        $result = $conn->query($query);

        if ($result === false) {
            $trainer_output = "Error in SQL query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                $trainer = $result->fetch_assoc();
                $trainer_output = "<div class='details-output'>
                                    <strong>Trainer details are:</strong><br>
                                    <strong>Name:</strong> " . htmlspecialchars($trainer['trainer_name']) . "<br>
                                    <strong>Age:</strong> " . htmlspecialchars($trainer['age']) . "<br>
                                    <strong>Specialization:</strong> " . htmlspecialchars($trainer['specialization']) . "<br>
                                    <strong>Charges:</strong> " . htmlspecialchars($trainer['charges']) . "<br>
                                    <strong>Contact:</strong> " . htmlspecialchars($trainer['contact']) . "
                                  </div>";
            } else {
                $trainer_output = '<div class="details-output error">No trainer found with this contact number.</div>';
            }
        }
    }

    echo '<div class="form-section">
            <h2>Trainer Details</h2>
            <button onclick="window.location.href=\'trainer_panel.php\'">Add Trainer</button>
            <p></p>
            <form method="POST" action="">
                <input type="text" name="trainer_contact" placeholder="Enter trainer contact number" required />
                <button type="submit">Fetch Details</button>
            </form>
            ' . $trainer_output . '
          </div>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package_id'])) {
        $package_id = $conn->real_escape_string(trim($_POST['package_id']));

        $query = "SELECT * FROM tbl_packages WHERE package_id = '$package_id'";
        $result = $conn->query($query);

        if ($result === false) {
            $package_output = "Error in SQL query: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                $package = $result->fetch_assoc();
                $package_output = "<div class='details-output'>
                                    <strong>Package details are:</strong><br>
                                    <strong>ID:</strong> " . htmlspecialchars($package['package_id']) . "<br>
                                    <strong>Name:</strong> " . htmlspecialchars($package['package_name']) . "<br>
                                    <strong>Price:</strong> " . htmlspecialchars($package['charges']) . " RS.<br>
                                    <strong>Duration</strong> " . htmlspecialchars($package['duration']) . " Days
                                  </div>";
            } else {
                $package_output = '<div class="details-output error">No package found with this ID.</div>';
            }
        }
    }

    echo '<div class="form-section">
            <h2>Package Details</h2>
            <button onclick="window.location.href=\'packages.php\'">Add Package</button>
            <p></p>
            <form method="POST" action="">
                <input type="text" name="package_id" placeholder="Enter package ID" required />
                <button type="submit">Fetch Details</button>
            </form>
            ' . $package_output . '
          </div>';

    $conn->close();
    ?>
    
    <div class="form-section">
        <button onclick="window.location.href='login1.php'">Logout</button>
    </div>
    <p></p>
    <p></p>
    <div class="form-section">
        <button onclick="window.location.href='bill.php'">GENERATE INVOICE</button>
    </div>

</div>
</body>
</html>
