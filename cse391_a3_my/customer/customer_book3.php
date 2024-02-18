<?php
session_start();
require_once('../connection/connect.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: customer_login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    // Retrieve and sanitize the input data
    $timeSlotID = filter_input(INPUT_POST, 'timeSlotID', FILTER_SANITIZE_NUMBER_INT);
    $clientID = filter_input(INPUT_POST, 'clientID', FILTER_SANITIZE_NUMBER_INT);
    $mechanicID = filter_input(INPUT_POST, 'MechanicID', FILTER_SANITIZE_NUMBER_INT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO appointments (ClientID, TimeSlotID, MechanicID) VALUES (?, ?, ?)");
    
    // Bind the parameters and execute the statement
    $stmt->bind_param("iii", $clientID, $timeSlotID, $mechanicID);
    
    if ($stmt->execute()) {

        echo "Appointment booked successfully!";
        // Redirect or perform additional actions as needed
        $stmt->close();
        $conn->close();
        header("Location: profile.php");
        exit();
    } else {
        echo "Failed to book appointment. Error: " . $stmt->error;
        // Log error or notify an administrator as needed
    }

    $stmt->close();
    $conn->close();
}