<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: customer_login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    // Retrieve the timeSlotID, clientID, and clientName from the form
    $timeSlotID = $_POST['timeSlotID'];
    $clientID = $_POST['clientID'];
    $clientName = $_POST['clientName'];
    // Retrieve the mechanicID from the form
    $mechanicID = $_POST['mechanicID'];

    // Insert a new appointment into the appointments table
    $insert_sql = "INSERT INTO appointments (ClientID, TimeSlotID, MechanicID) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $clientID, $timeSlotID, $mechanicID);
    $insert_stmt->execute();

    // Check if insertion was successful
    if ($insert_stmt->affected_rows > 0) {
        echo "Appointment booked successfully!";
    } else {
        echo "Failed to book appointment.";
    }

    $insert_stmt->close();
    $conn->close();
}
?>
