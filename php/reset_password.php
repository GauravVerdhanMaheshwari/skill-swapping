<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "skill_swapping";

$connect = mysqli_connect($host, $username, $password, $db);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <h2>Reset Your Password</h2>
    <form method="POST">
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <br><br>
        <input type="submit" value="Update Password">
    </form>
</body>

</html>