<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "skill_swapping";

$connect = mysqli_connect($host, $username, $password, $db);

session_start();
$_SESSION['givenEmail'];

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SESSION['givenEmail'] == false) {
    echo "<script>window.location.href='forgetPassword.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/reset_password.css">
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
        $email = $_SESSION['email'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET Password='$password' WHERE Email='$email'";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>alert('Password updated successfully!');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Failed to update password!');</script>";
        }
    }
}

?>