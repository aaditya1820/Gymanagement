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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Style for the container of the chart */
        #chart-container {
            width: 25vw; /* Set width to 25% of the viewport width */
            height: auto;
            margin: 0 auto; /* Center the chart */
        }

        /* Make sure the chart canvas fills the container */
        #pieChart {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <h1>Gym Statistics: Trainers vs Customers</h1>
    
    <div id="chart-container">
        <canvas id="pieChart"></canvas>
    </div>
    
    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Trainers', 'Customers'],
                datasets: [{
                    data: [<?php echo $total_trainers; ?>, <?php echo $total_customers; ?>],
                    backgroundColor: ['#36A2EB', '#FF6384'],
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
