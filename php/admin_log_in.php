<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin_login.css">
</head>

<body>
    <div class="login">
        <div class="innerLogin">
            <h1 class="title">Admin Login</h1><br>
            <form action="" method="post">
                <label for="admin">Name</label><br>
                <input type="text" name="admin" id="admin" class="input" placeholder="Enter your name" required><br><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" class="input" placeholder="Enter your email"
                    required><br><br>
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="input" placeholder="Enter your password"
                    required><br><br><br>
                <input type="submit" name="Login" value="Login" class="button">
            </form>
        </div>
    </div>
</body>

</html>


<?php

include 'connect.php';
$connect = dbConnection();

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$_SESSION["Admin Login"] = false;
$_SESSION["Admin ID"] = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Login"])) {
    $name = mysqli_real_escape_string($connect, $_POST["admin"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);

    $check = "SELECT AID,Name, Email ,Password FROM admin WHERE Name='$name' AND Email='$email' ";
    $result = mysqli_query($connect, $check);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $aid = $row['AID'];
        $hash = $row['Password'];

        if (password_verify($password, $hash)) {
            $date = date("Y-m-d H:i:s");
            $what = "LOGGED IN";
            $log = $date . " " . $what;

            $query = "INSERT INTO admin_logs (Log, Time, What, AID) VALUES ('$log','$date','$what','$aid')";
            if (mysqli_query($connect, $query)) {
                $_SESSION["Admin Login"] = true;
                $_SESSION["Admin ID"] = $aid;
                echo "<script>window.location.href='admin_dash.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error logging activity.');</script>";
            }
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
        }
    } else {
        echo "<script>alert('Wrong username or email.');</script>";
    }
}

?>