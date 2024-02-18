/* This PHP code snippet is responsible for handling the booking process for mechanics in a scheduling
system. Here's a breakdown of what the code does: */
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
            <h2>Hello, <?php echo htmlspecialchars($clientName); ?>! Available Mechanics</h2>
            <ul>
                <?php
                // Display mechanics with a form for each mechanic
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li>
                        MechanicID: <?php echo $row['MechanicID']; ?>, Name: <?php echo htmlspecialchars($row['Name']); ?>
                        <form action="customer_book3.php" method="POST">
                            <input type="hidden" name="timeSlotID" value="<?php echo htmlspecialchars($timeSlotID); ?>">
                            <input type="hidden" name="clientID" value="<?php echo htmlspecialchars($clientID); ?>">
                            <input type="hidden" name="clientName" value="<?php echo htmlspecialchars($clientName); ?>">
                            <input type="hidden" name="MechanicID" value="<?php echo htmlspecialchars($row['MechanicID']); ?>">
                            <button type="submit" name="book">Book</button>
                        </form>
                    </li>
                    <?php
                }
                ?>
            </ul>
    
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


}
$stmt->close();
$conn->close();
?>


