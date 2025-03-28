<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gym_management';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_attendance'])) {
    $name = $_POST['name'];
    $attendance_status = $_POST['attendance_status'];

    $sql = "INSERT INTO tbl_attendance (name, attendance_status)
            VALUES ('$name', '$attendance_status')";

    if ($conn->query($sql) === TRUE) {
        $message = "Attendance marked successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['view_attendance'])) {
    $name = $_POST['name'];

    $sql = "SELECT 
                SUM(attendance_status = 'Present') AS present_days,
                SUM(attendance_status = 'Absent') AS absent_days
            FROM tbl_attendance
            WHERE name = '$name'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $attendance_summary = $result->fetch_assoc();
        $message = "Total attendance for $name: 
                    Present: {$attendance_summary['present_days']} days, 
                    Absent: {$attendance_summary['absent_days']} days.";
    } else {
        $message = "No attendance records found for $name.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_attendance'])) {
    $attendance_id = intval($_POST['attendance_id']);

    $sql = "DELETE FROM tbl_attendance WHERE a_id = $attendance_id";

    if ($conn->query($sql) === TRUE) {
        $message = "Attendance deleted successfully!";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

$users = $conn->query("SELECT name FROM tbl_user");
if (!$users || $users->num_rows === 0) {
    $users_error = "No users found in the database. Please add users.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livingWell Attendance</title>
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

select, button {
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

select:hover, button:hover {
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
}

    </style>
</head>
<body>
    <h2>Mark Customer Attendance</h2>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <div class="form-section">
        <form action="" method="POST">
            <label for="name">Customer Name:</label>
            <select id="name" name="name" required>
                <option value="">Select User</option>
                <?php
                if (isset($users_error)) {
                    echo "<option value='' disabled>$users_error</option>";
                } else {
                    while ($row = $users->fetch_assoc()) {
                        echo "<option value='{$row['name']}'>{$row['name']}</option>";
                    }
                }
                ?>
            </select>
            
            <label for="attendance_status">Attendance Status:</label>
            <select id="attendance_status" name="attendance_status" required>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select>
            
            <button type="submit" name="submit_attendance">Submit</button>
            <button type="submit" name="view_attendance">View Attendance</button>
        </form>
    </div>

    <h2>Attendance Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM tbl_attendance ORDER BY attendance_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['a_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['attendance_status']}</td>
                    <td>{$row['attendance_date']}</td>
                    <td>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='attendance_id' value='{$row['a_id']}'>
                            <button type='submit' name='delete_attendance' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</button>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
    </table>
    <p></p>
    <a href="nevigation_page.php" class="logout-btn">Back</a>
    <p></p>
</body>
</html>

<?php $conn->close(); ?>
