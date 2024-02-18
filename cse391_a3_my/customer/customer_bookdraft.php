<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['mechanic_id'])) {
    $mechanic_id = $_GET['mechanic_id'];
    
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin'])) {
        // If not logged in, redirect to the login page
        header("Location: customer_login.php");
        exit();
    }
    
    // Get the logged-in client's ID from the session
    $client_id = $_SESSION['client_id'];
    
    // Insert the booking into the appointments table
    $stmt = $conn->prepare("INSERT INTO appointments (ClientID, Mechanic, TimeSlotID) VALUES (?, ?, ?)");
    // Assuming you have a predefined time slot ID for booking
    $time_slot_id = 1; // Change this according to your logic
    
    $stmt->bind_param("iss", $client_id, $mechanic_id, $time_slot_id);
    
    if ($stmt->execute()) {
        // Booking successful
        echo "Booking successful!";
    } else {
        // Booking failed
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    // If the mechanic ID is not set, redirect to the mechanics list page
    header("Location: mechanics_list.php");
    exit();
}
?>
