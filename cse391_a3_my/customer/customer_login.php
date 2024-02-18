<?php
session_start();
require_once('../connection/connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check if email and password match
    $stmt = $conn->prepare("SELECT ClientID, Name, Password FROM clients WHERE Email = ?");
    $stmt->bind_param("s", $email); // Change "ss" to "s"
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        // Fetch the hashed password
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['client_id'] = $row['ClientID'];
            $_SESSION['name'] = $row['Name'];
            echo "Hello, $name!, You Have Successfully Logged in!!";

            // Redirect to homepage or any other page after successful login
            header("Location: ../customer/profile.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Customer Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <button type="submit">Login</button>
        </form>
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
    <button onclick="window.location.href = '../index.php';">Back to Homepage</button>
</body>
</html>
