<?php

include 'connect.php';
$connect = dbConnection();

$connect = mysqli_connect($host, $username, $password, $db);

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