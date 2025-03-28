<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add'])) {
    $package_name = $_POST['package_name'];
    $charges = $_POST['charges'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO tbl_packages (package_name, charges, duration) VALUES ('$package_name', '$charges', '$duration')";
    if ($conn->query($sql) === TRUE) {
        echo "New package added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['update'])) {
    $package_id = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $charges = $_POST['charges'];
    $duration = $_POST['duration'];

    $sql = "UPDATE tbl_packages SET package_name='$package_name', charges='$charges', duration='$duration' WHERE package_id='$package_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Package updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['delete'])) {
    $package_id = $_POST['package_id'];

    $sql = "DELETE FROM tbl_packages WHERE package_id='$package_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Package deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$search_results = [];
$search_found = false; 
if (isset($_POST['search'])) {
    $search_name = $_POST['search_name'];
    $search_query = "SELECT * FROM tbl_packages WHERE package_name LIKE '%$search_name%'";
    $search_results = $conn->query($search_query);
    $search_found = $search_results->num_rows > 0; 
}

if (!$search_found) {
    $packages = $conn->query("SELECT * FROM tbl_packages");
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
    <title>livingWell-Package Management</title>
    <style>
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to bottom right, #e0f7fa, #e8f5e9); /* Light blue to light green */
    margin: 0;
    padding: 20px;
    color: #333;
    line-height: 1.6;
}

h1, h2, h3 {
    color: #0288d1; /* Blue */
    text-align: center;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
}

form {
    background: white;
    padding: 25px;
    margin: 20px auto;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

form:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

input[type="text"],
input[type="number"],
select,
button {
    display: block;
    width: calc(100% - 24px);
    padding: 12px;
    margin: 12px auto;
    border-radius: 8px;
    border: 1px solid #b0bec5; /* Light gray */
    font-size: 16px;
    outline: none;
    box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #0288d1; /* Blue */
    box-shadow: 0px 0px 8px rgba(2, 136, 209, 0.3);
}

button {
    background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
    transform: translateY(-3px);
}

button:active {
    transform: translateY(0);
}

table {
    width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    background: white;
}

table th, table td {
    padding: 15px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 14px;
}

table th {
    background: linear-gradient(135deg, #0288d1, #0277bd); /* Blue header */
    color: white;
    text-transform: uppercase;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background: #e0f2f1; /* Light blue */
    transition: background 0.3s ease;
}

.logout-btn {
    display: inline-block;
    background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
    transition: all 0.3s ease;
    margin: 20px auto;
    width: 120px;
}

.logout-btn:hover {
    background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
    transform: translateY(-3px);
}

form.search-form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    max-width: 600px;
    padding: 10px;
    margin: 20px auto;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.search-form input[type="text"] {
    flex: 1;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #b0bec5;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.search-form input[type="text"]:focus {
    border-color: #0288d1;
    box-shadow: 0 0 8px rgba(2, 136, 209, 0.2);
}

.search-form button {
    background: linear-gradient(135deg, #0288d1, #0277bd);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-form button:hover {
    background: linear-gradient(135deg, #0277bd, #01579b);
    transform: translateY(-3px);
}

.message {
    background: #e0f7fa; /* Light blue background */
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
    color: #0288d1;
    margin: 20px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

@media (max-width: 600px) {
    form,
    table {
        width: 95%;
    }

    .search-form {
        flex-direction: column;
        gap: 15px;
    }

    .search-form button {
        width: 100%;
    }

    .logout-btn {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <h2>Package Management</h2>

    <form action="" method="post">
        <input type="text" name="package_name" placeholder="Package Name" required>
        <input type="number" step="0.01" name="charges" placeholder="Charges" min=1 required>
        <input type="number" name="duration" placeholder="Duration (in days)" min=1 required>
        <button type="submit" name="add">Add Package</button>
    </form>

    <form action="" method="post">
        <input type="text" name="search_name" placeholder="Search Package by Name">
        <button type="submit" name="search">View</button>
    </form>

    <?php if (isset($_POST['search'])): ?>
        <h3>Search Results:</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Package Name</th>
                <th>Charges</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $search_results->fetch_assoc()): ?>
            <tr>
                <form action="" method="post">
                    <td><?php echo $row['package_id']; ?></td>
                    <td><input type="text" name="package_name" value="<?php echo $row['package_name']; ?>"></td>
                    <td><input type="number" step="0.01" min=1 name="charges" value="<?php echo $row['charges']; ?>"></td>
                    <td><input type="number" name="duration" min=1 value="<?php echo $row['duration']; ?>"></td>
                    <td>
                        <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
                        <button type="submit" name="update" class="action-btn update-btn">Update</button>
                        <button type="submit" name="delete" class="action-btn delete-btn">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <?php if (!$search_found): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Package Name</th>
                <th>Charges</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $packages->fetch_assoc()): ?>
            <tr>
                <form action="" method="post">
                    <td><?php echo $row['package_id']; ?></td>
                    <td><input type="text" name="package_name" value="<?php echo $row['package_name']; ?>"></td>
                    <td><input type="number" step="0.01" min=1 name="charges" value="<?php echo $row['charges']; ?>"></td>
                    <td><input type="number" name="duration" min=1 value="<?php echo $row['duration']; ?>"></td>
                    <td>
                        <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
                        <button type="submit" name="update" class="action-btn update-btn">Update</button>
                        <button type="submit" name="delete" class="action-btn delete-btn">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <a href="nevigation_page.php" class="logout-btn">Back</a>
    <p></p>
    

</body>
</html>

<?php $conn->close(); ?>
