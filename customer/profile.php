<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: customer_login.php");
    exit();
}

// Fetch user data
$clientID = $_SESSION['client_id'];
$sql = "SELECT * FROM clients WHERE ClientID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['Name'];
    $phone = $row['Phone'];
    $carColor = $row['CarColor'];
    $licenseNumber = $row['LicenseNumber'];
    $email = $row['Email'];
    // You can fetch profile picture URL from the database or use a placeholder
    $profilePicture = "path/to/profile-picture.jpg"; // Replace with actual path
} else {
    echo "Error fetching user data";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile">
            <div class="profile-picture">
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture">
            </div>
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Phone:</strong> <?php echo $phone; ?></p>
                <p><strong>Car Color:</strong> <?php echo $carColor; ?></p>
                <p><strong>License Number:</strong> <?php echo $licenseNumber; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
        </div>
        <!-- Add a button to view appointments -->
        <button onclick="window.location.href = 'my_appointments.php';">View My Appointments</button>
        <button onclick="window.location.href = 'customer_book.php';">Book Your Mechanic</button>
        
    </div>
    <button onclick="window.location.href = '../index.php';">Back to Homepage</button>
</body>
</html>
