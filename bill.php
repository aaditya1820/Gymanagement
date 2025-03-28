<?php
// Include FPDF library
require('fpdf.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "gym_management");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch dropdown data with charges
// Fetch dropdown data without charges
function getDropdownOptions($table, $idColumn, $nameColumn) {
    global $conn;
    $query = "SELECT $idColumn, $nameColumn FROM $table";
    $result = $conn->query($query);

    if (!$result) {
        die("Error in query: " . $query . " - " . $conn->error);
    }

    $options = [];
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
    return $options;
}

// Get dropdown options
$users = getDropdownOptions('tbl_user', 'id', 'name');
$trainers = getDropdownOptions('tbl_trainers', 'trainer_id', 'trainer_name');
$packages = getDropdownOptions('tbl_packages', 'package_id', 'package_name');
$plans = getDropdownOptions('tbl_plans', 'plan_id', 'plan_name');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'generate_bill') {
        $userId = $_POST['username'];
        $trainerId = $_POST['trainer'];
        $packageId = $_POST['package'];
        $planId = $_POST['plan'];
        $gymCharges = $_POST['gym_charges'];
        $gstRate = 18;

        // Fetch charges without foreign keys
        $trainerCharges = $conn->query("SELECT charges FROM tbl_trainers WHERE trainer_id = $trainerId")->fetch_assoc()['charges'];
        $packageCharges = $conn->query("SELECT charges FROM tbl_packages WHERE package_id = $packageId")->fetch_assoc()['charges'];

        // Calculate total
        $subtotal = $trainerCharges + $packageCharges  + $gymCharges;
        $gstAmount = ($subtotal * $gstRate) / 100;
        $totalAmount = $subtotal + $gstAmount;

        // Save billing details in database
        $conn->query("INSERT INTO tbl_billing (user_id, trainer_id, package_id, plan_id, trainer_charges, package_charges, gym_charges, gst_rate, total_amount, payment_status) 
                      VALUES ($userId, $trainerId, $packageId, $planId, $trainerCharges, $packageCharges, $gymCharges, $gstRate, $totalAmount, 'Pending')");
        $billId = $conn->insert_id;

        echo json_encode(['status' => 'success', 'totalAmount' => $totalAmount, 'billId' => $billId]);
        exit;
    } elseif ($action === 'save_payment') {
        $billId = $_POST['bill_id'];
        $razorpayPaymentId = $_POST['razorpay_payment_id'];

        // Update billing status
        $conn->query("UPDATE tbl_billing SET payment_status = 'Paid', payment_date = NOW() WHERE bill_id = $billId");

        // Generate PDF Invoice
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Gym Billing Invoice', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Bill ID: ' . $billId, 0, 1);
        $pdf->Cell(0, 10, 'Payment ID: ' . $razorpayPaymentId, 0, 1);
        $pdf->Output('D', "Invoice_$billId.pdf");
        exit;
    }
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
    <title>livingWell Billing System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        /* Add your CSS styles here */
        body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to bottom, #a8d8ea, #e8f1f8) fixed;
    background-image: url('https://img.freepik.com/premium-vector/purple-gradient-background-wallpaper-vector-image-backdrop-presentation_1110513-2346.jpg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    padding: 0;
    color: #ffffff; 
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.container {
    background-color: rgba(255, 255, 255, 0.8); 
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    box-sizing: border-box;
    position: relative;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 80vh;
}

h1 {
    color: #ffffff; 
    text-align: center;
    font-weight: bold;
    font-size: 26px;
    margin-bottom: 20px;
    text-transform: uppercase;
    background-color: rgba(0, 0, 0, 0.5); 
    padding: 10px;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.5); 
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #ffffff; 
    font-size: 14px;
}

input[type="text"], 
input[type="email"], 
input[type="number"], 
textarea,
select {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 15px;
    border: 1px solid rgba(255, 255, 255, 0.6); /* Semi-transparent border */
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: rgba(255, 255, 255, 0.8);
    color: #000000; /* Text inside inputs remains readable */
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus, 
input[type="email"]:focus, 
input[type="number"]:focus, 
textarea:focus, 
select:focus {
    border-color: rgba(255, 255, 255, 1); /* Fully opaque border on focus */
    outline: none;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
}

textarea {
    resize: none;
    height: 120px;
}

button,
input[type="submit"] {
    background-color: rgba(255, 255, 255, 0.9);
    color: #000000; /* Dark text for contrast */
    padding: 12px 16px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    text-transform: uppercase;
    font-weight: bold;
    margin-bottom: 12px;
    transition: background-color 0.3s ease, transform 0.2s, box-shadow 0.2s;
}

button:hover,
input[type="submit"]:hover {
    background-color: rgba(255, 255, 255, 1);
    transform: scale(1.03);
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.4);
}


button.back-btn {
    background-color:rgba(255, 255, 255, 0.9);
    color: #000000;
    margin-top: auto;
    align-self: center;
    padding: 12px 20px;
    max-width: 150px;
}

button.back-btn:hover {
    background-color: rgba(255, 255, 255, 1);
}

button:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
}


@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    .container {
        padding: 20px;
        min-height: auto;
    }

    h1 {
        font-size: 22px;
    }

    button.back-btn {
        padding: 10px 16px;
        max-width: 120px;
    }
}

    </style>
</head>
<body>
<form id="billingForm">
    <h1>LivingWell GYM - Billing</h1>

    <label for="username">Customer:</label>
    <select name="username" id="username" required>
        <option value="">Select</option>
        <?php foreach ($users as $user) : ?>
            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="trainer">Trainer:</label>
    <select name="trainer" id="trainer" required>
        <option value="">Select</option>
        <?php foreach ($trainers as $trainer) : ?>
            <option value="<?= $trainer['trainer_id'] ?>">
                <?= $trainer['trainer_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="package">Package:</label>
    <select name="package" id="package" required>
        <option value="">Select</option>
        <?php foreach ($packages as $package) : ?>
            <option value="<?= $package['package_id'] ?>">
                <?= $package['package_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="plan">Plan:</label>
    <select name="plan" id="plan" required>
        <option value="">Select</option>
        <?php foreach ($plans as $plan) : ?>
            <option value="<?= $plan['plan_id'] ?>">
                <?= $plan['plan_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="gym_charges">Gym Charges:</label>
    <input type="number" id="gym_charges" name="gym_charges" placeholder="Enter Gym Charges" min="1" required>

    <button type="button" onclick="generateBill()">Proceed For Payment</button>
    <button type="button" class="back-btn" onclick="window.location.href='nevigation_page.php'">Back</button>

</form>

    <script>
        function generateBill() {
            const formData = $("#billingForm").serialize() + "&action=generate_bill";

            $.post("", formData, function (response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    makePayment(data.totalAmount, data.billId);
                }
            });
        }

        function makePayment(amount, billId) {
    const options = {
        "key": "rzp_test_zePsRXlNaKaOsk", 
        "amount": amount * 100,
        "currency": "INR",
        "name": "LivingWell Gym",
        "description": "Billing",
        "handler": function (response) {
            savePayment(response.razorpay_payment_id, billId);
        },
        "theme": { "color": "#3399cc" },
        "modal": {
            "ondismiss": function () {
                alert("Payment cancelled!! Please try again.");
            }
        }
    };
    const rzp = new Razorpay(options);
    rzp.open();
}

        function savePayment(paymentId, billId) {
            const formData = {
                action: "save_payment",
                razorpay_payment_id: paymentId,
                bill_id: billId
            };

            $.post("", formData, function () {
                alert("Payment Successful! Invoice downloaded.");
            });
        }
    </script>
</body>
</html>
