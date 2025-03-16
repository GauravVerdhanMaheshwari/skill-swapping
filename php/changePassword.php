<?php
include 'connect.php';
$connect = dbConnection();

session_start();

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/changePassword.css">
</head>

<body>
    <div class="password">
        <form method="POST">
            <h1 class="title">Reset Your Password</h1><br>
            <label for="password">New Password:</label>
            <input type="password" name="password" class="input" placeholder="Enter your new password" required
                minlength="8" maxlength="10"><br><br><br>
            <label for="password">Confirm Password:</label><br>
            <input type="password" name="confirmPassword" class="input" placeholder="Confirm your new password" required
                minlength="8" maxlength="10">
            <br><br>
            <input type="submit" value="Update Password" class="button">
            <a href="./userProfile.php" class="link">I know my password</a>
        </form>
    </div>
</body>

</html>

<?php

if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    if ($password != $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        echo "<script>window.location.href='reset_password.php';</script>";
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uid = $_SESSION['uid'];
        $email = $_SESSION['email'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $date = date("Y-m-d H:i:s");
        $what = "PASSWORD CHANGED";
        $log = $date . " " . $what;

        // Insert log
        $query = "INSERT INTO LOGS (Log, Time, What, UID) VALUES ('$log','$date','$what','$uid')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $query = "UPDATE user SET Password='$password' WHERE UID='$uid'";
            $result = mysqli_query($connect, $query);
            if ($result) {
                echo "<script>alert('Password updated successfully!');</script>";
                echo "<script>window.location.href='home.php';</script>";
            } else {
                echo "<script>alert('Failed to update password!');</script>";
            }
        } else {
            echo "<script>alert('Failed to update password!');</script>";
        }
    }
}

?>