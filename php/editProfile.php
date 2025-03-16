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
    <title>Edit Profile</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/editProfile.css">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class="userLink">
        <h1 class="title">Edit Profile</h1>
        <p class="name">Name
            <input type="text" name="name" value="<?php echo $name; ?>" required>
        </p>
        <p class="email">Email
            <input type="email" name="email" value="<?php echo $email; ?>" required>
        </p>
        <br>
        <input type="submit" value="Save" class="editProfile">
        <a href="deleteProfile.php" onclick="return confirm('Are you sure you want to delete your profile?')">Delete
            Profile</a>
    </div>
</body>

</html>