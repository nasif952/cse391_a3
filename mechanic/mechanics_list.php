<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanics List</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mechanics List</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Remaining Active Cars</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch mechanics list from the database
                require_once('../connection/connect.php'); // Include your database connection file
                
                $sql = "SELECT * FROM mechanics";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['RemActiveCars'] . "</td>";
                        echo "<td><a href='book_mechanic.php?mechanic_id=" . $row['MechanicID'] . "' class='button'>Book This Mechanic</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No mechanics found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
