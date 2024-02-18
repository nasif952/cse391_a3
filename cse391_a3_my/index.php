
<!DOCTYPE html>

<?php
    session_start();
    include 'connection/connect.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 3</title>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <ul>
                <li><a href="customer/customer_login.php">Login</a></li>
                <li><a href="customer/customer_registration.php">Register</a></li>
                <li><a href="mechanic/mechanics_list.php">Mechanics</a></li>
            </ul>
        </nav>
        <h1>Login</h1>
    </div>
</body>
</html>
