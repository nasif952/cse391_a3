<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: customer_login.php");
    exit();
}

// Fetch client name from the database
$clientID = $_SESSION['client_id'];
$stmt = $conn->prepare("SELECT Name FROM clients WHERE ClientID = ?");
$stmt->bind_param("i", $clientID);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($clientName);
    $stmt->fetch();
} else {
    // Handle error if client name is not found
    $clientName = "Unknown";
}

$stmt->close();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    // Retrieve the timeSlotID and clientID from the form
    $timeSlotID = $_POST['timeSlotID'];
    $clientID = $_POST['clientID'];
    

    // Insert appointment into appointments table
    $stmt = $conn->prepare("INSERT INTO appointments (ClientID, TimeSlotID) VALUES (?, ?)");
    $stmt->bind_param("ii", $clientID, $timeSlotID);
    $stmt->execute();
    $stmt->close();

    // Redirect to success page or refresh the page
    header("Location: success.php");
    exit();
}

// Fetch all time slots from the database
$query = "SELECT * FROM timeslots ORDER BY FIELD(DayOfWeek, 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'), StartTime";
$result = $conn->query($query);

// Create an array to store time slots for each day of the week
$timeSlotsByDay = array(
    'Friday' => array(),
    'Saturday' => array(),
    'Sunday' => array(),
    'Monday' => array(),
    'Tuesday' => array(),
    'Wednesday' => array(),
    'Thursday' => array()
);

// Group time slots by day of the week
while ($row = $result->fetch_assoc()) {
    $dayOfWeek = $row['DayOfWeek'];
    $timeSlotsByDay[$dayOfWeek][] = $row;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Schedule</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Booking Schedule</h2>
    <?php foreach ($timeSlotsByDay as $dayOfWeek => $timeSlots): ?>
        <h3><?php echo $dayOfWeek; ?></h3>
        <table>
            <tr>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
            <?php foreach ($timeSlots as $timeSlot): ?>
                <tr>
                    <td><?php echo $timeSlot['StartTime']; ?></td>
                    <td><?php echo $timeSlot['EndTime']; ?></td>
                    <td>
                        <form action="customer_book2.php" method="POST">
                            <input type="hidden" name="timeSlotID" value="<?php echo $timeSlot['TimeSlotID']; ?>">
                            <input type="hidden" name="clientID" value="<?php echo $clientID; ?>">
                            <input type="hidden" name="clientName" value="<?php echo $clientName; ?>">
                             <!-- Make sure this line is included -->
                            <button type="submit" name="book">Book This Slot</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</body>
</html>
