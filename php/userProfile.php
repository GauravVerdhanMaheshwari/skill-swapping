<?php

include 'connect.php';
$connect = dbConnection();

session_start();
if ($_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$uid = $_SESSION["uid"];

$query = "SELECT Name,Email FROM user WHERE UID = '$uid'";
$result = mysqli_query($connect, $query);

if ($query) {
    $row = mysqli_fetch_assoc($result);
    $name = $row["Name"];
    $email = $row["Email"];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/userProfile.css">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class="userLink">
        <h1 class="title">User Profile</h1>
        <p class="name">Name: <?php echo $name; ?></p>
        <p class="email">Email: <?php echo $email; ?></p>
        <br>
        <a href="editProfile.php" class="editProfile">Edit Profile</a>
        <a href="changePassword.php" class="changePassword">Change Password</a>
        <a href="myCourses.php" class="myCourses">My Courses</a>
        <a href="viewLogs.php" class="myLogs">View Logs</a>
        <a href="logout.php" class="logOut">Log Out</a>
    </div>
</body>

</html>