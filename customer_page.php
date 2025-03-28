<?php
$message = '';
$showAll = true;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle cancel membership
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {
    $delete_id = $_POST['delete_id'];
    $deleteStmt = $conn->prepare("DELETE FROM tbl_user WHERE id = ?");
    $deleteStmt->bind_param("i", $delete_id);
    if ($deleteStmt->execute()) {
        $message = "Membership cancelled successfully.";
    } else {
        $message = "Failed to cancel membership.";
    }
    $deleteStmt->close();
}

// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE name LIKE ?");
    $searchTerm = "%" . $name . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $showAll = false;
} else {
    $stmt = $conn->prepare("SELECT * FROM tbl_user");
    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livingWell - Search</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #e0f7fa, #e8f5e9); /* Light blue to light green gradient */
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1, h2, h3 {
            color: #0288d1; /* Blue */
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
            color: #0288d1; /* Blue */
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
            background-color: #e0f2f1; /* Light blue */
            border-color: #0288d1; /* Blue */
        }

        button {
            background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
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
            background-color: #0288d1; /* Blue */
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e0f2f1; /* Light blue */
        }

        .message {
            text-align: center;
            color: #0288d1; /* Blue */
            font-weight: bold;
            background: #e0f7fa; /* Light blue background */
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: inline-block;
            background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
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
    <h1>Search Customer Details</h1>
    
    <!-- Display message if any -->
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="name">Enter Customer Name:</label>
        <input type="text" id="name" name="name">
        <button type="submit">Search</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Height</th><th>Weight</th><th>Blood Group</th><th>Address</th><th>Contact Number</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['height']}</td>
                    <td>{$row['weight']}</td>
                    <td>{$row['bloodgroup']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                            <button type='submit' class='cancel-button' name='cancel'>Cancel Membership</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No customer found.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <button onclick="window.location.href='nevigation_page.php'">Back</button>
</body>
</html>
