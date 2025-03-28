<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LivingWell - Trainer Search</title>
    <style>
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

        .message {
            background-color:white;
            color: #0288d1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

    </style>
</head>
<body>
    <h1>Search Trainer Details</h1>

    <?php
    // Message box logic
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['trainer_name'])) {
        $trainer_name = $_POST['trainer_name'];
        $stmt = $conn->prepare("SELECT * FROM tbl_trainers WHERE trainer_name LIKE ?");
        $searchTerm = "%" . $trainer_name . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $showAll = false;
    } else {
        $stmt = $conn->prepare("SELECT * FROM tbl_trainers");
        $stmt->execute();
        $result = $stmt->get_result();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_trainer'])) {
        $trainer_id = $_POST['remove_trainer_id'];
        $sql_remove = "DELETE FROM tbl_trainers WHERE trainer_id = ?";
        $stmt_remove = $conn->prepare($sql_remove);
        $stmt_remove->bind_param("i", $trainer_id);
        if ($stmt_remove->execute()) {
            $message = "Trainer removed successfully!";
        } else {
            $message = "Error removing trainer: " . $conn->error;
        }
    }

    // Display message if exists
    if (!empty($message)) {
        echo "<div class='message'>$message</div>";
    }

    ?>

    <!-- Search Bar Form -->
    <form method="post" class="form-section">
        <label for="trainer_name">Enter Trainer Name:</label>
        <input type="text" id="trainer_name" name="trainer_name">
        <button type="submit">Search</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Specialization</th><th>Charges</th><th>Contact</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['trainer_id']}</td>
                    <td>{$row['trainer_name']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['specialization']}</td>
                    <td>{$row['charges']}</td>
                    <td>{$row['contact']}</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='remove_trainer_id' value='{$row['trainer_id']}'>
                            <button type='submit' name='remove_trainer'>Remove Trainer</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No trainer found.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="nevigation_page.php" class="logout-btn">Back</a>
</body>
</html>
