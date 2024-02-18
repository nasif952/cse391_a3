<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: customer_login.php");
    exit();
}

// Fetch user's appointments
$clientID = $_SESSION['client_id'];
$sql = "SELECT a.AppointmentID, m.Name , t.DayOfWeek, t.StartTime, t.EndTime
        FROM appointments a
        LEFT JOIN mechanics m ON a.MechanicID = m.MechanicID
        LEFT JOIN timeslots t ON a.TimeSlotID = t.TimeSlotID
        WHERE a.ClientID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Debugging output 
    // If appointments are found
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Appointments</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <h1>My Appointments</h1>
            <table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Mechanic Name</th>
                    <th>Day of Week</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                <?php
                // Display appointments
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['AppointmentID'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['DayOfWeek'] . "</td>";
                    echo "<td>" . $row['StartTime'] . "</td>";
                    echo "<td>" . $row['EndTime'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <button onclick="window.location.href = 'profile.php';">Back to Profile</button>
        <button onclick="window.location.href = '../index.php';">Back to Homepage</button>
    </body>
    </html>
    <?php
} else {
    // If no appointments found
    echo "No appointments found.";
    ?>
    <br>
    <button onclick="window.location.href = 'profile.php';">Back to Profile</button>
    <button onclick="window.location.href = '../index.php';">Back to Homepage</button>
    <?php
}

$stmt->close();
$conn->close();
?>
