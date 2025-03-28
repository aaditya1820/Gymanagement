<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livingWell - Billing History</title>
    <style>
        /* Your existing CSS styles, no changes required */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #e0f7fa, #e8f5e9);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1, h2, h3 {
            color: #0288d1; 
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .form-section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #0288d1;
        }

        input[type="text"], select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        input[type="text"]:hover, select:hover, button:hover {
            background-color: #e0f2f1;
            border-color: #0288d1;
        }

        button {
            background: linear-gradient(45deg, #0288d1, #0277bd); 
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(45deg, #0277bd, #01579b);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        table th {
            background-color: #0288d1;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e0f2f1;
        }

        .message {
            text-align: center;
            color: #0288d1;
            font-weight: bold;
            background: #e0f7fa;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: inline-block;
            background: linear-gradient(45deg, #0288d1, #0277bd); 
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(45deg, #0277bd, #01579b);
            transform: translateY(-2px);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .form-section {
                padding: 15px;
            }

            button, input[type="text"] {
                font-size: 14px;
                padding: 10px;
            }

            table th, table td {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Billing History for Customer</h1>

    <!-- Form to enter Bill ID -->
    <form method="post">
        <label for="bill_id">Enter Bill ID (Optional to Filter):</label>
        <input type="text" id="bill_id" name="bill_id">
        <button type="submit">Search</button>
    </form>

    <?php
// Database connection settings
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "gym_management"; // Change this to your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted and a Bill ID is entered
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bill_id']) && !empty($_POST['bill_id'])) {
    $bill_id = $_POST['bill_id'];

    // Prepare SQL query to fetch details for the specific bill
   // Prepare SQL query to fetch details for the specific bill
$sql = "SELECT bill_id, user_id, trainer_id, package_id, plan_id, trainer_charges, 
package_charges, plan_charges, gym_charges, gst_rate, total_amount, 
payment_status, payment_date 
FROM tbl_billing 
WHERE bill_id = '$bill_id'";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
// Fetch and display the specific bill details
$row = mysqli_fetch_assoc($result);

// Check if plan_charges is empty, and replace with 'empty' if so
$plan_charges = empty($row['plan_charges']) ? 'NULL' : $row['plan_charges'];

echo "<h3>Billing Information for Bill ID: " . $row['bill_id'] . "</h3>";
echo "<table>";
echo "<tr><th>Field</th><th>Details</th></tr>";
echo "<tr><td>Billing ID</td><td>" . $row['bill_id'] . "</td></tr>";
echo "<tr><td>User ID</td><td>" . $row['user_id'] . "</td></tr>";
echo "<tr><td>Trainer ID</td><td>" . $row['trainer_id'] . "</td></tr>";
echo "<tr><td>Package ID</td><td>" . $row['package_id'] . "</td></tr>";
echo "<tr><td>Plan ID</td><td>" . $row['plan_id'] . "</td></tr>";
echo "<tr><td>Trainer Charges</td><td>" . $row['trainer_charges'] . "</td></tr>";
echo "<tr><td>Package Charges</td><td>" . $row['package_charges'] . "</td></tr>";
echo "<tr><td>Plan Charges</td><td>" . $plan_charges . "</td></tr>"; // Use modified plan_charges
echo "<tr><td>Gym Charges</td><td>" . $row['gym_charges'] . "</td></tr>";
echo "<tr><td>GST Rate</td><td>" . $row['gst_rate'] . "%</td></tr>";
echo "<tr><td>Total Amount</td><td>" . $row['total_amount'] . "</td></tr>";
echo "<tr><td>Payment Status</td><td>" . $row['payment_status'] . "</td></tr>";
echo "<tr><td>Payment Date</td><td>" . $row['payment_date'] . "</td></tr>";
echo "</table>";
} else {
echo "<div class='message'>No billing record found for Bill ID: $bill_id</div>";
}

} else {
    // If no Bill ID is entered, show all billing history
    $sql = "SELECT bill_id, user_id, trainer_id, package_id, plan_id, trainer_charges, 
                   package_charges, plan_charges, gym_charges, gst_rate, total_amount, 
                   payment_status, payment_date 
            FROM tbl_billing";

    // Execute the query to fetch all records
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h3>All Billing History:</h3>";
        echo "<table>";
        echo "<tr>
                <th>Bill ID</th>
                <th>User ID</th>
                <th>Trainer ID</th>
                <th>Package ID</th>
                <th>Plan ID</th>
                <th>Trainer Charges</th>
                <th>Package Charges</th>
                <th>Plan Charges</th>
                <th>Gym Charges</th>
                <th>GST Rate</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
              </tr>";

        // Display all records
        // Display all records
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['bill_id'] . "</td>";
    echo "<td>" . $row['user_id'] . "</td>";
    echo "<td>" . $row['trainer_id'] . "</td>";
    echo "<td>" . $row['package_id'] . "</td>";
    echo "<td>" . $row['plan_id'] . "</td>";
    echo "<td>" . $row['trainer_charges'] . "</td>";
    echo "<td>" . $row['package_charges'] . "</td>";
    echo "<td>" . (empty($row['plan_charges']) ? 'NULL' : $row['plan_charges']) . "</td>"; // Updated line
    echo "<td>" . $row['gym_charges'] . "</td>";
    echo "<td>" . $row['gst_rate'] . "%</td>";
    echo "<td>" . $row['total_amount'] . "</td>";
    echo "<td>" . $row['payment_status'] . "</td>";
    echo "<td>" . $row['payment_date'] . "</td>";
    echo "</tr>";
}

        echo "</table>";
    } else {
        echo "<div class='message'>No billing records found.</div>";
    }
}

// Close the database connection
mysqli_close($conn);
?>


    <button onclick="window.location.href='nevigation_page.php'">Back</button>
</body>
</html>
