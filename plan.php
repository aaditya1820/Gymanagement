<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add'])) {
    $plan_name = $conn->real_escape_string($_POST['plan_name']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $sql = "INSERT INTO tbl_plans (plan_name, start_date, end_date) VALUES ('$plan_name', '$start_date', '$end_date')";
    if ($conn->query($sql) === TRUE) {
        echo "New plan added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$plan = null;
if (isset($_GET['edit'])) {
    $plan_id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM tbl_plans WHERE plan_id='$plan_id'");
    if ($result && $result->num_rows > 0) {
        $plan = $result->fetch_assoc();
    } else {
        echo "Plan not found or invalid plan ID.";
    }
}

if (isset($_POST['update'])) {
    $plan_id = intval($_POST['plan_id']);
    $plan_name = $conn->real_escape_string($_POST['plan_name']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    if (!empty($plan_id) && !empty($plan_name)) {
        $sql = "UPDATE tbl_plans SET plan_name='$plan_name', start_date='$start_date', end_date='$end_date' WHERE plan_id='$plan_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Plan updated successfully.";
        } else {
            echo "Error updating plan: " . $conn->error;
        }
    } else {
        echo "Invalid plan ID or data.";
    }
}

if (isset($_GET['delete'])) {
    $plan_id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM tbl_plans WHERE plan_id='$plan_id'") === TRUE) {
        echo "Plan deleted successfully.";
    } else {
        echo "Error deleting plan: " . $conn->error;
    }
}

$plan_name_filter = '';
if (isset($_POST['filter'])) {
    $plan_name_filter = $conn->real_escape_string($_POST['plan_name_filter']);
}

if ($plan_name_filter) {
    $filtered_plans = $conn->query("SELECT * FROM tbl_plans WHERE plan_name LIKE '%$plan_name_filter%'");
} else {
    $filtered_plans = $conn->query("SELECT * FROM tbl_plans ORDER BY start_date ASC");
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
<title>livingWell-Manage Plans</title>
<style>
body {
    font-family: 'Roboto', Arial, sans-serif;
    background: linear-gradient(120deg, #e0f7fa, #e8f5e9);
    margin: 0;
    padding: 20px;
    color: #222;
    line-height: 1.6;
}

h2 {
    text-align: center;
    color: #0288d1;
    margin-bottom: 20px;
    font-size: 2rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

form {
    background: #fff;
    padding: 25px;
    margin: 20px auto;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

form:hover {
    transform: scale(1.02);
    box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.15);
}

input[type="text"],
input[type="number"],
input[type="date"] {
    display: block;
    width: calc(100% - 24px);
    padding: 12px;
    margin: 12px auto;
    border-radius: 8px;
    border: 1px solid #b0bec5;
    font-size: 16px;
    outline: none;
    box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus {
    border-color: #0288d1;
    box-shadow: 0px 0px 8px rgba(2, 136, 209, 0.3);
}

button {
    background: linear-gradient(135deg, #0288d1, #0277bd);
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    width: 100%;
    transition: all 0.3s ease;
}

button:hover {
    background: linear-gradient(135deg, #0277bd, #01579b);
    transform: translateY(-3px);
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
}

table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
    font-size: 1rem;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 14px;
}

th {
    background: linear-gradient(135deg, #0288d1, #0277bd);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background: #e0f7fa;
    transition: background 0.3s ease;
}

.logout-btn {
    background: linear-gradient(45deg, #0288d1, #0277bd);
    color: #fff;
    padding: 12px 20px;
    margin: 20px auto;
    display: block;
    width: 140px;
    text-align: center;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: linear-gradient(45deg, #0277bd, #01579b);
    transform: translateY(-3px);
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
}

.action-btn {
    background: linear-gradient(45deg, #0288d1, #0277bd);
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

.action-btn:hover {
    background: linear-gradient(45deg, #0277bd, #01579b);
    transform: translateY(-3px);
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
}

.edit-btn {
    margin-right: 5px;
}

.delete-btn {
    background: linear-gradient(45deg, #0288d1, #0277bd);
}

.delete-btn:hover {
    background: linear-gradient(45deg, #0277bd, #01579b);
}

@media (max-width: 768px) {
    form {
        max-width: 95%;
        padding: 20px;
    }

    table {
        width: 100%;
        font-size: 0.9rem;
    }

    button,
    .logout-btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
        font-size: 14px;
    }

    button,
    .logout-btn {
        padding: 10px;
    }
}
</style>
</head>
<body>
<h2>Manage Plans</h2>
<form method="post" action="plan.php">
    <input type="hidden" name="plan_id" value="<?php echo isset($plan['plan_id']) ? $plan['plan_id'] : ''; ?>">
    <label>Plan Name:</label>
    <input type="text" name="plan_name" required value="<?php echo isset($plan['plan_name']) ? htmlspecialchars($plan['plan_name']) : ''; ?>">
    <br>
    <label>Start Date:</label>
    <input type="date" name="start_date" required value="<?php echo isset($plan['start_date']) ? date('Y-m-d', strtotime($plan['start_date'])) : ''; ?>">
    <br>
    <label>End Date:</label>
    <input type="date" name="end_date" required value="<?php echo isset($plan['end_date']) ? date('Y-m-d', strtotime($plan['end_date'])) : ''; ?>">
    <br>
    <button type="submit" name="<?php echo isset($plan) ? 'update' : 'add'; ?>">
        <?php echo isset($plan) ? 'Update Plan' : 'Add Plan'; ?>
    </button>
</form>
<table>
    <thead>
        <tr>
            <th>Plan Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $filtered_plans->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['plan_name']); ?></td>
            <td><?php echo date('d-m-Y', strtotime($row['start_date'])); ?></td>
            <td><?php echo date('d-m-Y', strtotime($row['end_date'])); ?></td>
            <td>
                <a href="plan.php?edit=<?php echo htmlspecialchars($row['plan_id']); ?>" class="action-btn edit-btn">Edit</a>
                <a href="plan.php?delete=<?php echo htmlspecialchars($row['plan_id']); ?>" class="action-btn delete-btn">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="nevigation_page.php" class="logout-btn">Back</a>
</body>
</html>
