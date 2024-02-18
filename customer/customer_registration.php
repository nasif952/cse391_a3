<!DOCTYPE html>
<?php
session_start();
require_once('../connection/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $car_color = $_POST['car_color'];
    $license_number = $_POST['license_number'];
    $engine_number = $_POST['engine_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert data into clients table using prepared statement
    $stmt = $conn->prepare("INSERT INTO clients (Name, Phone, CarColor, LicenseNumber, EngineNumber, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $phone, $car_color, $license_number, $engine_number, $email, $hashed_password);
    

    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Customer Signup</title>
</head>
<body>
    <h1>Customer Signup</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        
        <label for="car_color">Car Color:</label>
        <input type="text" id="car_color" name="car_color"><br>
        
        <label for="license_number">License Number:</label>
        <input type="text" id="license_number" name="license_number" required><br>
        
        <label for="engine_number">Engine Number:</label>
        <input type="text" id="engine_number" name="engine_number" required><br>
       
        
        
        <button type="submit">Sign Up</button>
    </form>
    <button onclick="window.location.href = '../index.php';">Back to Homepage</button>
</body>
</html>




