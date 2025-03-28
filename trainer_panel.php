<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gym_management';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$trainer = null;
$message = null;

// Start session to store success/error messages
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs
    $name = $_POST['trainer_name'];
    $age = $_POST['trainer_age'];
    $specialization = $_POST['specialization'];
    $charges = $_POST['charges'];
    $contact = $_POST['contact'];

    // Check if contact already exists
    $check_contact_sql = "SELECT * FROM tbl_trainers WHERE contact = '$contact'";
    $result = mysqli_query($conn, $check_contact_sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "Error: Trainer with this contact already exists!";
    } else {
        // Insert into database if contact doesn't exist
        $sql = "INSERT INTO tbl_trainers (trainer_name, age, specialization, charges, contact) 
                VALUES ('$name', '$age', '$specialization', '$charges', '$contact')";

        if (mysqli_query($conn, $sql)) {
            // Retrieve the inserted trainer's ID
            $trainer_id = mysqli_insert_id($conn);
            $result = mysqli_query($conn, "SELECT * FROM tbl_trainers WHERE trainer_id = $trainer_id");

            // Fetch the trainer data
            if ($result && mysqli_num_rows($result) > 0) {
                $trainer = mysqli_fetch_assoc($result);
                $_SESSION['message'] = "Trainer Added Successfully!";
            } else {
                $_SESSION['message'] = "Error: Unable to fetch trainer details.";
            }
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    }

    // Redirect to avoid form re-submission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit; // Make sure to call exit after header redirect
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <title>Trainer Panel - livingWell</title>
    <style>
/* Base Styles */
/* Base Styles */
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to bottom right, #e0f7fa, #e8f5e9); /* Light blue to light green gradient */
    margin: 0;
    padding: 20px;
    color: #333;
    line-height: 1.6;
}

/* Headings */
h1, h2, h3 {
    color: #0288d1; /* Blue */
    text-align: center;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    margin: 0 0 10px;
}

/* Form Section */
.form-section {
    background: white;
    padding: 20px;
    margin: 20px 0;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Labels */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #0288d1; /* Blue */
}

/* Inputs, Textarea, and Select Styles */
/* Base Styles for Inputs, Textarea, and Select */
input[type="text"], input[type="number"], input[type="tel"], textarea, select {
    width: 100%; /* Full width */
    padding: 12px; /* Comfortable padding */
    margin-bottom: 15px; /* Space between fields */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Legible font size */
    background-color: #f9f9f9; /* Light background */
    box-sizing: border-box; /* Include padding and border in width/height */
    transition: all 0.3s ease; /* Smooth transitions */
}

/* Hover and Focus Effects for Inputs */
input[type="text"]:hover, input[type="number"]:hover, input[type="tel"]:hover, textarea:hover, select:hover {
    background-color: #e0f2f1; /* Light blue hover effect */
    border-color: #0288d1; /* Highlight border */
}

input[type="text"]:focus, input[type="number"]:focus, input[type="tel"]:focus, textarea:focus, select:focus {
    outline: none; /* Remove default focus outline */
    border-color: #0288d1; /* Blue border on focus */
    background-color: #e0f7fa; /* Slightly brighter background */
}

/* Specific Styling for Number Inputs */
input[type="number"] {
    -moz-appearance: textfield; /* Remove default spinner controls in Firefox */
    appearance: textfield; /* Remove default spinner controls in other browsers */
}

/* Prevent Spinners in WebKit Browsers */
input[type="number"]::-webkit-inner-spin-button, 
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none; /* Remove default spinner controls */
    margin: 0;
}

/* Specific Styling for Telephone Inputs */
input[type="tel"] {
    font-family: 'Roboto', sans-serif; /* Ensure font consistency */
    color: #333; /* Text color */
}

/* Button Styles */
button {
    background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
    color: white;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    padding: 12px;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
    width: 100%; /* Full-width button */
    box-sizing: border-box;
}

button:hover {
    background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
    transform: translateY(-2px);
}

button:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 600px) {
    input[type="text"], input[type="number"], input[type="tel"], textarea, select, button {
        font-size: 14px; /* Slightly smaller font size */
        padding: 10px; /* Adjust padding for smaller viewports */
    }

    textarea {
        min-height: 100px; /* Slightly smaller default height */
    }
}


/* Hover and Focus Effects for Input, Textarea, and Select */
input[type="text"]:hover, textarea:hover, select:hover {
    background-color: #e0f2f1; /* Light blue hover effect */
    border-color: #0288d1; /* Highlight border */
}

input[type="text"]:focus, textarea:focus, select:focus {
    outline: none; /* Remove default focus outline */
    border-color: #0288d1; /* Blue border on focus */
    background-color: #e0f7fa; /* Slightly brighter background */
}

/* Textarea Specific Styles */
textarea {
    resize: vertical; /* Allow vertical resizing only */
    min-height: 120px; /* Set a default height */
    font-family: 'Roboto', sans-serif; /* Ensure font consistency */
}

/* Button Styles */
button {
    background: linear-gradient(45deg, #0288d1, #0277bd); /* Blue gradient */
    color: white;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    padding: 12px;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
    width: 100%; /* Full-width button */
    box-sizing: border-box;
}

button:hover {
    background: linear-gradient(45deg, #0277bd, #01579b); /* Darker blue gradient */
    transform: translateY(-2px);
}

button:active {
    transform: translateY(0);
}

/* Table Styles */
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
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #e0f2f1; /* Light blue */
}

/* Notifications */
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

/* Logout Button */
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

/* Responsive Design */
@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    .form-section {
        padding: 15px;
    }

    button, input[type="text"], textarea, select {
        font-size: 14px; /* Slightly smaller font size */
        padding: 10px; /* Adjust padding for smaller viewports */
    }

    textarea {
        min-height: 100px; /* Slightly smaller default height */
    }

    table th, table td {
        font-size: 12px;
        padding: 10px;
    }
}


    </style>
</head>
<body>
    <div class="container">
        <h2>Trainer Panel - livingWell</h2>

        <!-- Display Success/Error Message -->
        <?php 
        if (isset($_SESSION['message'])):
            echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']); // Clear message after displaying
        endif;
        ?>

        <!-- Form Section -->
        <form action="" method="POST">
            <label for="trainer_name">Trainer Name</label>
            <input type="text" id="trainer_name" name="trainer_name" required>

            <label for="trainer_age">Trainer Age</label>
            <input type="number" id="trainer_age" min="1" name="trainer_age" required>

            <label for="specialization">Specialization</label>
            <input type="text" id="specialization" name="specialization" required>

            <label for="charges">Charges</label>
            <input type="number" id="charges" min="1" name="charges" required step="0.01">

            <label for="contact">Contact</label>
            <input type="tel" id="contact" name="contact" required>

            <button type="submit">Add Trainer Data</button>
            <p></p>
            <button type="button" onclick="window.location.href='nevigation_page.php'">Back</button>
        </form>

        <?php if ($trainer): ?>
            <div class="profile-card">
                <h1>Trainer's Profile</h1>
                <div class="details">
                    <p><strong>Trainer Name:</strong> <?php echo htmlspecialchars($trainer['trainer_name']); ?></p>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($trainer['specialization']); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($trainer['age']); ?></p>
                    <p><strong>Charges:</strong> ₹<?php echo htmlspecialchars($trainer['charges']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($trainer['contact']); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
