<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/password.css">
</head>

<body>

    <div class="password">

        <div class="innerPassword">
            <form method="GET" action="">
                <h1 class="title">Recover Account</h1><br><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" class="input" placeholder="Enter your register email"
                    autocomplete="off" required><br><br><br>
                <input type="submit" value="Recover password" class="button">
            </form>
            <a href="./login.php" class="link">I know my password</a>
        </div>

    </div>

</body>

</html>

<?php

include 'connect.php';
$connect = dbConnection();

session_start();
$_SESSION['givenEmail'] = false;

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $query = "SELECT * FROM user WHERE Email='$email'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['givenEmail'] = true;
        $_SESSION['email'] = $email;
        echo "<script>window.location.href='reset_password.php';</script>";
    } else {
        echo "<script>alert('Email not found, please enter correct email id')</script>";
    }
}
?>