<?php
include 'connect.php';
$connect = dbConnection();
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

// Ensure Admin ID is set
if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Session error. Please log in again.');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$id = $_SESSION["uid"];

$log = date("Y-m-d H:i:s") . " User Deleted ";

$query = "SELECT * FROM user WHERE UID = $id";
$result = mysqli_query($connect, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row["Name"];
    $userEmail = $row["Email"];
    $time = date("Y-m-d H:i:s");

    $query = "INSERT INTO deleted_user (Time, UserName, Email,UID) VALUES ('$time' , '$userName', '$userEmail','$id')";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        echo "<script>alert('Error logging activity.');</script>";
    } else {
        $query = "DELETE FROM user WHERE UID = $id";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>alert('User Deleted Successfully');</script>";
            echo "<script>window.location.href='./index.php';</script>";
        } else {
            echo "<script>alert('Error Deleting User');</script>";
        }
    }
}


?>