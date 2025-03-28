<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gym_management";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to count total trainers and customers
$sql_trainers = "SELECT COUNT(*) as total_trainers FROM tbl_trainers";
$sql_customers = "SELECT COUNT(*) as total_customers FROM tbl_user";

// Execute queries
$result_trainers = $conn->query($sql_trainers);
$result_customers = $conn->query($sql_customers);

// Fetch results
$total_trainers = $result_trainers->fetch_assoc()['total_trainers'];
$total_customers = $result_customers->fetch_assoc()['total_customers'];

// Close connection
$conn->close();
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
    <title>Gym Management System - Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #001F3F; /* Navy blue for a rich, dark background */
            display: flex;
            color: #ecf0f1; /* Light text for readability against the dark background */
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            min-height: 100vh;
            background-color: rgba(0, 0, 51, 0.8); /* Slightly lighter navy shade with transparency */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .section {
            margin: 20px 0 60px;
            padding: 30px;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.1); /* Subtle contrast for sections */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .section h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #ecf0f1; /* Light text for readability */
            text-align: center;
            font-weight: bold;
        }

        .section p {
            font-size: 16px;
            color: #bdc3c7; /* Light gray for paragraph text */
            text-align: center;
            margin-bottom: 20px;
        }

        #chart-container {
            width: 30vw;
            height: auto;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.1); /* Matches section background */
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #87CEEB, #000080); /* Sidebar gradient remains the same */
            color: white;
            padding: 20px;
            height: 100vh;
            box-shadow: 3px 0 8px rgba(0, 0, 0, 0.2);
            position: fixed;
        }



        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            letter-spacing: 1px;
            color: #ffffff;
            font-weight: bold;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin: 20px 0;
        }

        .sidebar nav ul li a {
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s, transform 0.3s;
        }

        .sidebar nav ul li a:hover {
            background-color: #34495E;
            transform: scale(1.05); /* Adds a slight zoom effect */
            color: #ECF0F1; /* Light Gray */
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            min-height: 100vh;
            background-color: #6960ec; /* Semi-transparent white background */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .section {
            margin: 20px 0 60px; /* Adjusted margin-top to move it up */
            padding: 30px;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2c3e50;
            text-align: center;
            font-weight: bold;
        }

        .section p {
            font-size: 16px;
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for the container of the chart */
        #chart-container {
            width: 30vw; /* Set width to 30% of the viewport width */
            height: auto;
            margin: 0 auto; /* Center the chart */
            background-color: #fff; /* White background for contrast */
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Make sure the chart canvas fills the container */
        #pieChart {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h3>Living Well - Admin Panel</h3>
        <nav>
            <ul>
                <li><a href="">Dashboard</a></li>
                <li><a href="customer_page.php">Customer Details</a></li>
                <li><a href="trainer_panel.php">Trainer Panel</a></li>
                <li><a href="trainer_page.php">Trainer Details</a></li>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="packages.php">Add Package</a></li>
                <li><a href="plan.php">Add Plan</a></li>
                <li><a href="bill.php">Billing</a></li>
                <li><a href="bill_history.php">Billing history</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        <div class="section">
            <h1>Welcome to the Admin Panel</h1>
            <h3><p>"Strong systems build stronger bodies – Welcome to the livingWell GYM..&#x1F4AA;"</p></h3>
        </div>

        <div class="section">
            <h1>Gym Statistics: Trainers vs Customers</h1>
            <div id="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Trainers', 'Customers'],
                datasets: [{
                    data: [<?php echo $total_trainers; ?>, <?php echo $total_customers; ?>],
                    backgroundColor: ['#002366', '#1e90ff'],
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
