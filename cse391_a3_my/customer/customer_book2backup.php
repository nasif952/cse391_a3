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
    $MechanicID = $_POST['MechanicID'];

    // Fetch mechanics that do not have appointments for the selected timeSlotID
    $sql = "SELECT m.MechanicID, m.Name FROM mechanics m
            LEFT JOIN appointments a ON m.MechanicID = a.MechanicID
            WHERE a.TimeSlotID <> ? OR a.TimeSlotID IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $timeSlotID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If mechanics are found
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Available Mechanics</title>
        </head>
        <body>
            <h2>Hello, <?php echo $clientName; ?>! Available Mechanics</h2>
            <form action="customer_book3.php" method="POST">
                <input type="hidden" name="timeSlotID" value="<?php echo $timeSlotID; ?>">
                <input type="hidden" name="clientID" value="<?php echo $clientID; ?>">
                <input type="hidden" name="clientName" value="<?php echo $clientName; ?>">
                <input type="hidden" name="MechanicID" value="<?php echo $MechanicID; ?>"> <!-- Add this line -->
                <ul>
                <?php
                // Display mechanics
                    while ($row = $result->fetch_assoc()) {
                     echo "<li>MechanicID: " . $row['MechanicID'] . ", Name: " . $row['Name'] . " <button type='submit' name='book'>Book</button></li>";
    }
    ?>
    </ul>
</form>

            <br>
            <a href="customer_book.php">Back to Booking Schedule</a>
        </body>
        </html>
        <?php
    } else {
        // If no mechanics are found
        echo "No available mechanics.";
        ?>
        <br>
        <a href="customer_book.php">Back to Booking Schedule</a>
        <?php
    }

    $stmt->close();
    $conn->close();
}
?>


