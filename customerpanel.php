<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'gym_management';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerProfile = null;
$errorMessage = "";
$customerAdded = false;
$showPlans = false;
$showPackages = false;

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $checkSql = "SELECT * FROM tbl_user WHERE contact_number='$contact_number' OR email='$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $errorMessage = "Customer with this contact number or email already exists.";
    } else {
        $sql = "INSERT INTO tbl_user (name, email, age, height, weight, bloodgroup, address, contact_number) 
                VALUES ('$name', '$email', '$age', '$height', '$weight', '$bloodgroup', '$address', '$contact_number')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New customer added successfully!');</script>";
            $customer_id = $conn->insert_id;
            $sql = "SELECT * FROM tbl_user WHERE id='$customer_id'";
            $profileResult = $conn->query($sql);
            if ($profileResult->num_rows > 0) {
                $customerProfile = $profileResult->fetch_assoc();
                $customerAdded = true;
            }
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $sql = "UPDATE tbl_user SET name='$name', email='$email', age='$age', height='$height', weight='$weight', bloodgroup='$bloodgroup', address='$address', contact_number='$contact_number' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer updated successfully!');</script>";
        $sql = "SELECT * FROM tbl_user WHERE id='$id'";
        $profileResult = $conn->query($sql);
        if ($profileResult->num_rows > 0) {
            $customerProfile = $profileResult->fetch_assoc();
        }
    } else {
        $errorMessage = "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT * FROM tbl_user";
$result = $conn->query($sql);

$plansSql = "SELECT * FROM tbl_plans";
$plansResult = $conn->query($plansSql);

$packagesSql = "SELECT * FROM tbl_packages";
$packagesResult = $conn->query($packagesSql);

if (isset($_POST['view_plans'])) {
    $showPlans = true;
}

if (isset($_POST['view_packages'])) {
    $showPackages = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>
    <style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #e8f1f8;
    margin: 0;
    padding: 20px;
    color: #2d3e50;
}

.container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
    margin: 40px auto;
    box-sizing: border-box;
    border: 1px solid #d1e7f5;
    overflow: hidden;
}

h2, h3 {
    color: #2a6592;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 700;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #34495e;
}

input[type="text"], 
input[type="email"], 
input[type="number"], 
textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid #b0d4ea;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #f0f9ff;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus, 
input[type="email"]:focus, 
input[type="number"]:focus, 
textarea:focus {
    border-color: #2a6592;
    outline: none;
    background-color: #ffffff;
    box-shadow: 0 0 8px rgba(42, 101, 146, 0.4);
}

textarea {
    resize: none;
    height: 120px;
}

input[type="submit"],
button {
    background-color: #007bff; 
    color: #ffffff;
    padding: 12px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    text-transform: uppercase;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s;
}

input[type="submit"]:hover,
button:hover {
    background-color: #0056b3;
    transform: scale(1.02);
}

hr {
    margin: 40px 0;
    border: 1px solid #d1e7f5;
}

.profile, .error {
    background-color: #ffffff;
    padding: 15px;
    margin-top: 20px;
    border-radius: 8px;
    border: 1px solid #b0d4ea;
    font-size: 14px;
}

.error {
    color: #c0392b;
    background-color: #fde6e6;
    border: 1px solid #f1b0b0;
}

.plans, .packages {
    background-color: #f0faff;
    padding: 20px;
    margin-top: 20px;
    border-radius: 8px;
    border: 1px solid #b0d4ea;
}

.plans div, .packages div {
    margin-bottom: 15px;
    color: #34495e;
    font-weight: 500;
}

button.logout-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px;
    width: auto;
    text-transform: uppercase;
}

button.logout-btn:hover {
    background-color: #0056b3;
}

@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    .container {
        padding: 20px;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
    }
}
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_SESSION['username'])): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <?php endif; ?>

    <h2>Customer Panel - LivingWell</h2>

    <?php if ($errorMessage): ?>
        <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <h3>Add Customer Details</h3>
    <form action="" method="POST">
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Age:</label>
            <input type="number" name="age"  min=1 required>
        </div>
        <div>
            <label>Height:</label>
            <input type="text" name="height" required>
        </div>
        <div>
            <label>Weight:</label>
            <input type="text" name="weight" required>
        </div>
        <div>
            <label>Blood Group:</label>
            <input type="text" name="bloodgroup" required>
        </div>
        <div>
            <label>Address:</label>
            <textarea name="address" required></textarea>
        </div>
        <div>
            <label>Contact Number:</label>
            <input type="number" name="contact_number" required>
        </div>
        <input type="submit" name="add" value="Add Customer">
    </form>

    <?php if ($customerAdded && $customerProfile): ?>
        <div class="profile">
            <h3>Customer Profile</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($customerProfile['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customerProfile['email']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($customerProfile['age']); ?></p>
            <p><strong>Height:</strong> <?php echo htmlspecialchars($customerProfile['height']); ?></p>
            <p><strong>Weight:</strong> <?php echo htmlspecialchars($customerProfile['weight']); ?></p>
            <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($customerProfile['bloodgroup']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($customerProfile['address']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($customerProfile['contact_number']); ?></p>
        </div>
    <?php endif; ?>

    <hr>

    <form action="" method="POST">
        <button type="submit" name="view_plans">View Fitness Plans</button>
    </form>

    <?php if ($showPlans): ?>
        <div class="plans">
            <h3>Available Fitness Plans</h3>
            <?php while($plan = $plansResult->fetch_assoc()): ?>
                <div>
                    <h4><?php echo htmlspecialchars($plan['plan_name']); ?></h4>
                    <p>Price: $<?php echo htmlspecialchars($plan['price']); ?> per month</p>
                    <p><?php echo htmlspecialchars($plan['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<p></p>
    <form action="" method="POST">
        <button type="submit" name="view_packages">View Gym Packages</button>
    </form>

    <?php if ($showPackages): ?>
        <div class="packages">
            <h3>Available Gym Packages</h3>
            <?php while($package = $packagesResult->fetch_assoc()): ?>
                <div>
                    <h4><?php echo htmlspecialchars($package['package_name']); ?></h4>
                    <p>Price: $<?php echo htmlspecialchars($package['price']); ?> for <?php echo htmlspecialchars($package['duration']); ?> months</p>
                    <p><?php echo htmlspecialchars($package['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <form action="logout.php" method="POST">
        <button class="logout-btn" type="submit" name="logout">Logout</button>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
